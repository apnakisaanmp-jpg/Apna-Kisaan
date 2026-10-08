@extends('layouts.frontend')

@php
    $pageLabel = match ($type) {
        'vegetable-price' => 'सब्जी भाव',
        'crop-price' => 'फसल भाव',
        'market-price' => 'बाजार भाव',
        default => 'मंडी भाव',
    };
    $records = $livePrices['records'] ?? [];
    $recordCategories = collect($records)->pluck('category')->filter()->unique()->values();
    $highestPrice = collect($records)->pluck('modal_price')->filter(fn ($price) => is_numeric($price))->max();
@endphp

@section('content')
    <section class="ak-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="eyebrow text-warning">लाइव बाजार जानकारी</div>
                    <h1 class="display-5 fw-bold mt-2">आज का {{ $pageLabel }}।</h1>
                    <p class="lead mb-0">प्रमुख फसलों और सब्जियों के उपलब्ध नवीनतम भाव देखें और अपनी फसल के अनुसार सूची खोजें।</p>
                </div>
                <div class="col-lg-4">
                    <div class="ak-card p-4 text-dark">
                        <div class="ak-icon mb-3"><i class="fa-solid fa-chart-line"></i></div>
                        <strong>{{ count($records) }} भाव उपलब्ध</strong>
                        <span class="d-block small text-secondary mt-1">
                            अपडेट: {{ isset($livePrices['updated']) ? \Illuminate\Support\Carbon::parse($livePrices['updated'])->format('d-m-Y, h:i A') : 'उपलब्ध नहीं' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-white">
        <div class="container">
            <div class="d-flex flex-wrap gap-2 mb-4" aria-label="भाव का प्रकार चुनें">
                <a class="ak-btn {{ $type === 'mandi-bhav' ? '' : 'secondary' }}" href="{{ route('mandi-bhav') }}">मंडी भाव</a>
                <a class="ak-btn {{ $type === 'market-price' ? '' : 'secondary' }}" href="{{ route('market-price') }}">बाजार भाव</a>
                <a class="ak-btn {{ $type === 'vegetable-price' ? '' : 'secondary' }}" href="{{ route('vegetable-price') }}">सब्जी भाव</a>
                <a class="ak-btn {{ $type === 'crop-price' ? '' : 'secondary' }}" href="{{ route('crop-price') }}">फसल भाव</a>
            </div>

            @if (!empty($livePrices['is_fallback']))
                <div class="alert alert-warning" role="status">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    लाइव डेटा सेवा अभी उपलब्ध नहीं है; नीचे स्पष्ट रूप से चिह्नित स्थानीय डेमो भाव दिखाए गए हैं।
                </div>
            @endif

            <div class="alert alert-info" role="note">
                <i class="fa-solid fa-map-location-dot me-2"></i>
                डेटा फीड में अलग-अलग मंडियों के जिला-स्तरीय रिकॉर्ड उपलब्ध नहीं हैं; दिखाए गए भाव मध्य प्रदेश के क्षेत्रीय संदर्भ के लिए हैं।
                स्रोत: {{ $livePrices['attribution'] ?? $livePrices['source'] ?? 'कृषि बाजार डेटा' }}
            </div>

            <div class="ak-card p-3 p-md-4 mb-4">
                <div class="row align-items-end g-3">
                    <div class="col-md-7">
                        <label class="form-label fw-semibold" for="priceSearch">फसल या सब्जी खोजें</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input class="form-control" type="search" id="priceSearch" placeholder="जैसे: गेहूं, टमाटर">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="priceCategory">श्रेणी</label>
                        <select class="form-select" id="priceCategory">
                            <option value="">सभी श्रेणियां</option>
                            @foreach ($recordCategories as $category)
                                <option value="{{ mb_strtolower($category) }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="ak-btn secondary w-100" type="button" id="clearPriceFilters">साफ करें</button>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-4">
                    <div class="ak-card p-3 h-100">
                        <span class="small text-secondary d-block">कुल रिकॉर्ड</span>
                        <strong id="priceRecordCount" class="fs-4">{{ count($records) }}</strong>
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="ak-card p-3 h-100">
                        <span class="small text-secondary d-block">सबसे अधिक उपलब्ध भाव</span>
                        <strong class="fs-4">{{ is_numeric($highestPrice) ? '₹' . number_format((float) $highestPrice, 2) : '—' }}</strong>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="ak-card p-3 h-100">
                        <span class="small text-secondary d-block">डेटा स्रोत</span>
                        <strong>{{ $livePrices['is_fallback'] ?? false ? 'स्थानीय उदाहरण डेटा' : ($livePrices['source'] ?? 'कृषि बाजार डेटा') }}</strong>
                    </div>
                </div>
            </div>

            <div class="table-responsive ak-card">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-success">
                        <tr>
                            <th scope="col">फसल / सब्जी</th>
                            <th scope="col">श्रेणी</th>
                            <th scope="col">न्यूनतम – अधिकतम</th>
                            <th scope="col">आज का भाव</th>
                            <th scope="col">बदलाव</th>
                            <th scope="col">इकाई</th>
                        </tr>
                    </thead>
                    <tbody id="priceRows">
                        @forelse ($records as $record)
                            @php
                                $searchText = mb_strtolower(implode(' ', array_filter([
                                    $record['commodity'] ?? '',
                                    $record['commodity_en'] ?? '',
                                    $record['category'] ?? '',
                                ])));
                                $minPrice = $record['min_price'] ?? null;
                                $maxPrice = $record['max_price'] ?? null;
                                $modalPrice = $record['modal_price'] ?? null;
                                $change = $record['change'] ?? null;
                            @endphp
                            <tr data-search="{{ $searchText }}" data-category="{{ mb_strtolower($record['category'] ?? '') }}">
                                <th scope="row">
                                    {{ $record['commodity'] ?? 'फसल' }}
                                    @if (!empty($record['commodity_en']))
                                        <small class="d-block text-secondary fw-normal">{{ $record['commodity_en'] }}</small>
                                    @endif
                                </th>
                                <td>{{ $record['category'] ?? '—' }}</td>
                                <td>
                                    {{ is_numeric($minPrice) ? '₹' . number_format((float) $minPrice, 2) : '—' }}
                                    –
                                    {{ is_numeric($maxPrice) ? '₹' . number_format((float) $maxPrice, 2) : '—' }}
                                </td>
                                <td class="fw-bold text-success">
                                    {{ is_numeric($modalPrice) ? '₹' . number_format((float) $modalPrice, 2) : '—' }}
                                </td>
                                <td>
                                    @if (($record['trend'] ?? '') === 'up')
                                        <span class="text-success"><i class="fa-solid fa-arrow-trend-up"></i> बढ़त</span>
                                    @elseif (($record['trend'] ?? '') === 'down')
                                        <span class="text-danger"><i class="fa-solid fa-arrow-trend-down"></i> गिरावट</span>
                                    @else
                                        <span class="text-secondary">स्थिर</span>
                                    @endif
                                    @if (is_numeric($change) && (float) $change !== 0.0)
                                        <small class="d-block">{{ number_format((float) $change, 2) }}</small>
                                    @endif
                                </td>
                                <td>{{ $record['unit'] ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4">अभी कोई भाव उपलब्ध नहीं है।</td></tr>
                        @endforelse
                        @if (count($records))
                            <tr id="priceNoResults" hidden>
                                <td colspan="6" class="text-center py-4">आपकी खोज से मेल खाता कोई भाव नहीं मिला।</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($categories->isNotEmpty())
                <div class="mt-5">
                    <div class="eyebrow">कृषि जानकारी</div>
                    <h2 class="h3 fw-bold">फसल श्रेणियां</h2>
                    <div class="row g-3 mt-1">
                        @foreach ($categories as $category)
                            <div class="col-md-6 col-lg-4">
                                <div class="ak-card h-100 p-3">
                                    <strong>{{ $category->name }}</strong>
                                    <p class="text-secondary mb-0 mt-2">{{ $category->examples }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            var search = document.getElementById('priceSearch');
            var category = document.getElementById('priceCategory');
            var clear = document.getElementById('clearPriceFilters');
            var count = document.getElementById('priceRecordCount');
            var noResults = document.getElementById('priceNoResults');
            var rows = Array.prototype.slice.call(document.querySelectorAll('#priceRows tr[data-search]'));

            function filterPrices() {
                var query = search.value.trim().toLocaleLowerCase();
                var selectedCategory = category.value;
                var visible = 0;

                rows.forEach(function (row) {
                    var matches = row.dataset.search.indexOf(query) !== -1
                        && (!selectedCategory || row.dataset.category === selectedCategory);
                    row.hidden = !matches;
                    if (matches) visible++;
                });

                count.textContent = String(visible);
                if (noResults) noResults.hidden = visible !== 0;
            }

            search.addEventListener('input', filterPrices);
            category.addEventListener('change', filterPrices);
            clear.addEventListener('click', function () {
                search.value = '';
                category.value = '';
                filterPrices();
            });
        })();
    </script>
@endpush
