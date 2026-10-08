<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CropCategory;
use App\Models\District;
use App\Models\Faq;
use App\Models\SeoMeta;
use App\Models\Service;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Services\FarmerPriceService;

class PageController extends Controller
{
    public function home(FarmerPriceService $priceService)
    {
        $sliders = Slider::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get()
            ->values();

        $sliderImage = 'assets/images/ChatGPT Image Sep 9, 2026, 12_15_07 AM.png';

        $defaultSlides = [
            ['title' => 'किसानों के लिए एक ही प्लेटफॉर्म', 'image' => $sliderImage, 'link_url' => '/services', 'alt_text' => 'किसानों के लिए एक ही प्लेटफॉर्म | अपना किसान'],
            ['title' => 'मध्य प्रदेश का अपना किसान', 'image' => $sliderImage, 'link_url' => '/about', 'alt_text' => 'मध्य प्रदेश का अपना किसान — आपकी फसल, आपका सही बाजार'],
            ['title' => 'लाइव मंडी भाव', 'image' => $sliderImage, 'link_url' => '/mandi-bhav', 'alt_text' => 'अपना किसान — लाइव मंडी भाव'],
            ['title' => 'सब्जी बाजार जानकारी', 'image' => $sliderImage, 'link_url' => '/vegetable-price', 'alt_text' => 'अपना किसान — सब्जी बाजार'],
            ['title' => 'परिवहन सहायता', 'image' => $sliderImage, 'link_url' => '/transport', 'alt_text' => 'अपना किसान — परिवहन सेवा'],
            ['title' => 'किसान संपर्क', 'image' => $sliderImage, 'link_url' => '/farmer-connect', 'alt_text' => 'अपना किसान — किसान और खेत'],
        ];

        $sliders->each(function ($slide) use ($sliderImage) {
            $slide->image = $sliderImage;
        });

        foreach ($defaultSlides as $slide) {
            if ($sliders->count() >= 6) {
                break;
            }

            $sliders->push((object) $slide);
        }

        $marketFeed = $priceService->prices('market');
        $prices = collect($marketFeed['records'])->take(12)->map(fn (array $record) => (object) [
            'commodity_name' => $record['commodity'] ?? 'फसल',
            'commodity_en' => $record['commodity_en'] ?? '',
            'price' => $record['modal_price'] ?? null,
            'unit' => $record['unit'] ?? 'रुपये',
            'trend' => $record['trend'] ?? 'same',
            'icon_class' => str_contains($record['category'] ?? '', 'सब्ज') ? 'fa-solid fa-leaf' : 'fa-solid fa-wheat-awn',
        ]);

        return view('frontend.home', [
            'seo' => $this->seo('home'),
            'sliders' => $sliders,
            'services' => Service::active()->get(),
            'districts' => District::active()->featured()->ordered()->limit(12)->get(),
            'prices' => $prices,
            'priceFeed' => $marketFeed,
            'categories' => CropCategory::where('is_active', true)->orderBy('sort_order')->get(),
            'team' => TeamMember::where('is_active', true)->orderBy('sort_order')->get(),
            'faqs' => Faq::where('is_active', true)->orderBy('sort_order')->limit(6)->get(),
        ]);
    }

    public function about()
    {
        return view('frontend.about', [
            'seo' => $this->seo('about'),
            'team' => TeamMember::where('is_active', true)->orderBy('sort_order')->get(),
            'districts' => District::active()->featured()->ordered()->get(),
        ]);
    }

    public function services()
    {
        return view('frontend.services', [
            'seo' => $this->seo('services'),
            'services' => Service::active()->get(),
        ]);
    }

    public function service(Service $service)
    {
        abort_unless($service->is_active, 404);

        return view('frontend.service-show', [
            'seo' => $this->seo('service-' . $service->slug),
            'service' => $service,
            'relatedServices' => Service::active()->whereKeyNot($service->id)->limit(3)->get(),
        ]);
    }

    public function contact()
    {
        return view('frontend.contact', [
            'seo' => $this->seo('contact'),
            'districts' => District::active()->ordered()->get(),
        ]);
    }

    public function farmerConnect()
    {
        return view('frontend.farmer-connect', [
            'seo' => $this->seo('farmer-connect'),
            'districts' => District::active()->ordered()->get(),
        ]);
    }

    public function transport()
    {
        return view('frontend.transport', [
            'seo' => $this->seo('transport'),
            'districts' => District::active()->ordered()->get(),
        ]);
    }

    public function prices(FarmerPriceService $priceService, string $type = 'mandi-bhav')
    {
        $apiType = match ($type) {
            'vegetable-price' => 'vegetable',
            'crop-price' => 'crop',
            default => 'market',
        };

        return view('frontend.prices', [
            'seo' => $this->seo($type),
            'type' => $type,
            'livePrices' => $priceService->prices($apiType),
            'categories' => CropCategory::where('is_active', true)->orderBy('sort_order')->get(),
            'districts' => District::active()->ordered()->get(),
        ]);
    }

    public function district(District $district)
    {
        abort_unless($district->is_active, 404);

        return view('frontend.district', [
            'seo' => $this->seo('district-' . $district->slug),
            'district' => $district,
            'services' => Service::active()->get(),
        ]);
    }

    public function information()
    {
        return view('frontend.information', [
            'seo' => $this->seo('information'),
            'faqs' => Faq::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function internship()
    {
        return view('frontend.internship', [
            'seo' => $this->seo('internship'),
            'districts' => District::active()->ordered()->get(),
        ]);
    }

    public function legal(string $page)
    {
        abort_unless(in_array($page, ['privacy', 'terms', 'payment'], true), 404);

        return view('frontend.legal', [
            'seo' => $this->seo($page),
            'page' => $page,
        ]);
    }

    private function seo(string $pageKey): ?SeoMeta
    {
        return SeoMeta::where('page_key', $pageKey)->first();
    }
}
