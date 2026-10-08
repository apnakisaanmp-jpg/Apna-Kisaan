<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FarmerPriceService
{
    private const API_URL = 'https://farmer.in/api/open/prices.json';

    private array $vegetableKeywords = [
        'tomato', 'onion', 'potato', 'brinjal', 'eggplant', 'cauliflower', 'cabbage',
        'okra', 'ladyfinger', 'carrot', 'radish', 'spinach', 'peas', 'beans',
        'cucumber', 'gourd', 'capsicum', 'chilli', 'chili', 'coriander', 'ginger',
        'garlic', 'mushroom', 'turnip', 'beetroot', 'pumpkin', 'bitter', 'bottle',
        'methi', 'palak', 'bhindi', 'baingan', 'shimla',
    ];

    private array $cropKeywords = [
        'wheat', 'rice', 'paddy', 'maize', 'corn', 'soybean', 'soya', 'soyabean',
        'mustard', 'cotton', 'sugarcane', 'jowar', 'bajra', 'barley', 'chana',
        'gram', 'chickpea', 'lentil', 'masoor', 'arhar', 'toor', 'moong', 'urad',
        'groundnut', 'peanut', 'sesame', 'til', 'sunflower', 'ragi', 'millet',
    ];

    private array $mpCrops = [
        'soybean', 'soya', 'soyabean', 'wheat', 'gram', 'chana', 'chickpea',
        'mustard', 'maize', 'corn', 'arhar', 'toor', 'moong', 'urad', 'linseed',
        'til', 'sesame', 'groundnut', 'cotton', 'paddy', 'ragi',
    ];

    public function prices(string $type = 'market'): array
    {
        return Cache::remember("farmer-prices-{$type}", 300, function () use ($type) {
            try {
                $payload = Http::timeout(10)->acceptJson()->get(self::API_URL)->throw()->json();
                $commodities = collect($payload['commodities'] ?? []);
                $records = $commodities
                    ->filter(fn ($item) => $this->matchesType($item, $type))
                    ->map(fn ($item) => $this->normalise($item))
                    ->sortByDesc('is_mp')
                    ->values()
                    ->all();

                return [
                    'success' => true,
                    'records' => $records,
                    'total' => count($records),
                    'mp_count' => collect($records)->where('is_mp', true)->count(),
                    'source' => $payload['source'] ?? 'farmer.in',
                    'attribution' => $payload['attribution'] ?? 'Powered by farmer.in Open Agriculture Data',
                    'updated' => $payload['updated'] ?? now()->toIso8601String(),
                    'is_fallback' => false,
                ];
            } catch (\Throwable $exception) {
                Log::warning('Could not fetch farmer price feed; serving fallback price data.', [
                    'exception' => $exception,
                ]);

                return [
                    'success' => true,
                    'records' => $this->fallback($type),
                    'total' => count($this->fallback($type)),
                    'mp_count' => collect($this->fallback($type))->where('is_mp', true)->count(),
                    'source' => 'स्थानीय fallback data',
                    'attribution' => 'farmer.in API उपलब्ध न होने पर fallback',
                    'updated' => now()->toIso8601String(),
                    'is_fallback' => true,
                ];
            }
        });
    }

    private function matchesType(array $item, string $type): bool
    {
        $name = Str::lower($item['name'] ?? '');
        $category = Str::lower($item['category'] ?? '');
        $isVeg = collect($this->vegetableKeywords)->contains(fn ($keyword) => str_contains($name, $keyword) || str_contains($category, 'vegetable'));
        $isCrop = collect($this->cropKeywords)->contains(fn ($keyword) => str_contains($name, $keyword) || str_contains($category, 'crop') || str_contains($category, 'grain') || str_contains($category, 'pulse'));

        return match ($type) {
            'vegetable' => $isVeg,
            'crop' => $isCrop && ! $isVeg,
            default => $this->isMp($item) || $isVeg || $isCrop,
        };
    }

    private function normalise(array $item): array
    {
        $name = Str::lower($item['name'] ?? '');
        $isVeg = collect($this->vegetableKeywords)->contains(fn ($keyword) => str_contains($name, $keyword));

        return [
            'commodity' => $item['hindi'] ?? $item['name'] ?? 'फसल',
            'commodity_en' => $item['name'] ?? '',
            'market' => 'मध्य प्रदेश क्षेत्रीय भाव',
            'district' => $this->isMp($item) ? 'मध्य प्रदेश' : 'भारत',
            'category' => $this->category($item['category'] ?? null, $isVeg),
            'min_price' => $item['min'] ?? null,
            'max_price' => $item['max'] ?? null,
            'modal_price' => $item['price'] ?? null,
            'change' => $item['change'] ?? 0,
            'trend' => $this->trend($item['trend'] ?? null),
            'unit' => $this->unit($item['unit'] ?? null),
            'arrival_date' => $item['updated'] ?? now()->toDateString(),
            'season' => $item['season'] ?? '',
            'description' => $item['description'] ?? '',
            'is_mp' => $this->isMp($item),
            'major_states' => $item['major_states'] ?? [],
        ];
    }

    private function isMp(array $item): bool
    {
        $states = collect($item['major_states'] ?? [])->map(fn ($state) => Str::lower($state));
        if ($states->contains(fn ($state) => str_contains($state, 'madhya') || $state === 'mp')) {
            return true;
        }

        $name = Str::lower($item['name'] ?? '');
        return collect($this->mpCrops)->contains(fn ($keyword) => str_contains($name, $keyword));
    }

    private function trend(?string $trend): string
    {
        return match (Str::lower((string) $trend)) {
            'up', 'increase', 'rise' => 'up',
            'down', 'decrease', 'fall' => 'down',
            default => 'same',
        };
    }

    private function unit(?string $unit): string
    {
        return match (Str::lower((string) $unit)) {
            'kg' => 'रु./किग्रा',
            'tonne' => 'रु./टन',
            'quintal', 'qtl', '' => 'रु./क्विंटल',
            default => $unit,
        };
    }

    private function category(?string $category, bool $isVegetable): string
    {
        $category = Str::lower(trim((string) $category));

        foreach ([
            'vegetable' => 'सब्जियां',
            'fruit' => 'फल',
            'cereal' => 'अनाज',
            'grain' => 'अनाज',
            'pulse' => 'दलहन',
            'legume' => 'दलहन',
            'oilseed' => 'तिलहन',
            'spice' => 'मसाले',
            'commercial' => 'नकदी फसल',
            'cash crop' => 'नकदी फसल',
        ] as $keyword => $label) {
            if (str_contains($category, $keyword)) {
                return $label;
            }
        }

        return $category === '' ? ($isVegetable ? 'सब्जियां' : 'अन्य फसलें') : trim((string) $category);
    }

    private function fallback(string $type): array
    {
        $records = [
            ['commodity' => 'टमाटर', 'commodity_en' => 'Tomato', 'category' => 'सब्जी', 'modal_price' => 2500, 'min_price' => 1400, 'max_price' => 3500, 'trend' => 'same', 'unit' => 'रु./क्विंटल', 'is_mp' => true],
            ['commodity' => 'प्याज', 'commodity_en' => 'Onion', 'category' => 'सब्जी', 'modal_price' => 2400, 'min_price' => 1800, 'max_price' => 3200, 'trend' => 'up', 'unit' => 'रु./क्विंटल', 'is_mp' => true],
            ['commodity' => 'गेहूं', 'commodity_en' => 'Wheat', 'category' => 'अनाज', 'modal_price' => 2400, 'min_price' => 2200, 'max_price' => 2600, 'trend' => 'up', 'unit' => 'रु./क्विंटल', 'is_mp' => true],
            ['commodity' => 'सोयाबीन', 'commodity_en' => 'Soybean', 'category' => 'तिलहन', 'modal_price' => 4900, 'min_price' => 4500, 'max_price' => 5200, 'trend' => 'down', 'unit' => 'रु./क्विंटल', 'is_mp' => true],
        ];

        return collect($records)
            ->filter(fn ($record) => $type === 'market' || ($type === 'vegetable' ? $record['category'] === 'सब्जी' : $record['category'] !== 'सब्जी'))
            ->map(fn ($record) => $record + ['market' => 'मध्य प्रदेश क्षेत्रीय भाव', 'district' => 'मध्य प्रदेश', 'arrival_date' => now()->toDateString(), 'change' => 0, 'season' => '', 'description' => '', 'major_states' => ['Madhya Pradesh']])
            ->values()
            ->all();
    }
}
