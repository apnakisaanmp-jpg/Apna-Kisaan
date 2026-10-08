@extends('layouts.frontend')

@section('content')

{{-- ══ HERO SLIDER ══════════════════════════════════════════════ --}}
<section class="ak-slider-section" id="akHeroSlider" aria-label="मुख्य बैनर स्लाइडर">
  <div class="ak-slider-live" aria-hidden="true"><span class="ak-slider-live-dot"></span> लाइव भाव</div>
  <div class="ak-slider-counter" id="sliderCounter" aria-hidden="true">1 / 6</div>
  <div class="ak-slider-track" id="sliderTrack">
    @foreach($sliders as $sl)
    <div class="ak-slide">
      @if($sl->link_url)<a href="{{ $sl->link_url }}">@endif
      <img src="{{ asset($sl->image) }}" alt="{{ $sl->alt_text ?? $sl->title }}" loading="{{ $loop->first?'eager':'lazy' }}"/>
      @if($sl->link_url)</a>@endif
    </div>
    @endforeach
  </div>
  <button class="ak-slider-arrow ak-slider-prev" id="sliderPrev" aria-label="पिछला"><i class="fa-solid fa-chevron-left"></i></button>
  <button class="ak-slider-arrow ak-slider-next" id="sliderNext" aria-label="अगला"><i class="fa-solid fa-chevron-right"></i></button>
  <div class="ak-slider-dots" role="tablist" id="sliderDots">
    @php $sc = $sliders->count(); @endphp
    @for($i=0;$i<$sc;$i++)
    <button class="ak-slider-dot {{ $i===0?'active':'' }}" role="tab" aria-label="स्लाइड {{ $i+1 }}" aria-selected="{{ $i===0?'true':'false' }}" data-index="{{ $i }}"></button>
    @endfor
  </div>
</section>

{{-- ══ PRICE TICKER ══════════════════════════════════════════════ --}}
<div class="ak-ticker-wrap" aria-label="लाइव भाव">
  <div class="ak-ticker-inner">
    @forelse($prices as $p)
    <span class="ak-ticker-item"><i class="fa-solid fa-leaf"></i> {{ $p->commodity_name }} &nbsp;<span class="{{ $p->trend==='down'?'ak-ticker-down':($p->trend==='up'?'ak-ticker-up':'') }}">{{ $p->trend==='down'?'▼':($p->trend==='up'?'▲':'—') }} {{ is_numeric($p->price) ? '₹' . number_format((float)$p->price) : 'भाव उपलब्ध नहीं' }}/{{ $p->unit }}</span></span>
    @empty
    <span class="ak-ticker-item"><i class="fa-solid fa-circle-info"></i> इस समय मंडी भाव उपलब्ध नहीं हैं। कृपया बाद में फिर देखें।</span>
    @endforelse
  </div>
</div>
<div class="ak-price-source-note" role="status">
  <div class="ak-shell">
    @if(!empty($priceFeed['is_fallback']))
      <i class="fa-solid fa-circle-info"></i> लाइव बाजार डेटा अभी उपलब्ध नहीं है; भाव सूची में दिए गए उदाहरण वास्तविक आज के मंडी भाव नहीं हैं।
    @else
      <i class="fa-solid fa-circle-info"></i> भाव {{ $priceFeed['source'] ?? 'बाजार डेटा' }} से लिए गए हैं; ये मध्य प्रदेश का क्षेत्रीय संदर्भ हैं, किसी खास मंडी का पक्का भाव नहीं।
    @endif
    <a href="{{ route('market-price') }}">डेटा और स्रोत देखें <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</div>

{{-- ══ STATS STRIP ═══════════════════════════════════════════════ --}}
<div class="ak-stats-strip">
  <div class="ak-shell">
    <div class="ak-stats-grid">
      <div class="ak-stat-item"><div class="ak-stat-icon green"><i class="fa-solid fa-map-location-dot"></i></div><div class="ak-stat-text"><strong>12+</strong><span>जिले कवर</span></div></div>
      <div class="ak-stat-item"><div class="ak-stat-icon orange"><i class="fa-solid fa-store"></i></div><div class="ak-stat-text"><strong>50+</strong><span>सब्जी मंडियां</span></div></div>
      <div class="ak-stat-item"><div class="ak-stat-icon yellow"><i class="fa-solid fa-chart-line"></i></div><div class="ak-stat-text"><strong>लाइव</strong><span>मंडी भाव</span></div></div>
      <div class="ak-stat-item"><div class="ak-stat-icon teal"><i class="fa-solid fa-handshake"></i></div><div class="ak-stat-text"><strong>100%</strong><span>मुफ़्त सेवा</span></div></div>
    </div>
  </div>
</div>

{{-- ══ QUICK ACCESS ══════════════════════════════════════════════ --}}
<section class="ak-section" aria-labelledby="quick-h2">
  <div class="ak-shell">
    <div class="ak-section-heading">
      <div><p class="ak-kicker">त्वरित जानकारी</p><h2 id="quick-h2">आज की जरूरी<br/><em>कृषि जानकारी।</em></h2></div>
      <p class="ak-section-desc">किसानों के लिए सबसे जरूरी जानकारी — तेज़, सटीक और बिल्कुल मुफ़्त।</p>
    </div>
    <div class="ak-quick-grid">
      <a class="ak-quick-card" href="{{ route('mandi-bhav') }}"><div class="ak-quick-icon green"><i class="fa-solid fa-store"></i></div><div class="ak-quick-card-body"><h3>आज का मंडी भाव</h3><p>सब्जियों और फसलों के ताज़ा बाजार मूल्य देखें।</p></div><span class="ak-quick-arrow"><i class="fa-solid fa-arrow-right"></i></span></a>
      <a class="ak-quick-card" href="{{ route('vegetable-price') }}"><div class="ak-quick-icon green"><i class="fa-solid fa-leaf"></i></div><div class="ak-quick-card-body"><h3>सब्जी भाव</h3><p>टमाटर, प्याज, आलू सहित सभी सब्जियों के भाव।</p></div><span class="ak-quick-arrow"><i class="fa-solid fa-arrow-right"></i></span></a>
      <a class="ak-quick-card" href="{{ route('crop-price') }}"><div class="ak-quick-icon yellow"><i class="fa-solid fa-wheat-awn"></i></div><div class="ak-quick-card-body"><h3>फसल भाव</h3><p>गेहूं, सोयाबीन, मक्का सहित MP की प्रमुख फसलें।</p></div><span class="ak-quick-arrow"><i class="fa-solid fa-arrow-right"></i></span></a>
      <a class="ak-quick-card" href="{{ route('information') }}"><div class="ak-quick-icon orange"><i class="fa-solid fa-book-open"></i></div><div class="ak-quick-card-body"><h3>कृषि जानकारी</h3><p>खेती की सलाह, मंडी समझ और सही बिक्री के तरीके।</p></div><span class="ak-quick-arrow"><i class="fa-solid fa-arrow-right"></i></span></a>
      <a class="ak-quick-card" href="{{ route('services') }}"><div class="ak-quick-icon blue"><i class="fa-solid fa-map-location-dot"></i></div><div class="ak-quick-card-body"><h3>जिला बाजार</h3><p>अपने जिले की सब्जी मंडी और बाजार की जानकारी।</p></div><span class="ak-quick-arrow"><i class="fa-solid fa-arrow-right"></i></span></a>
      <a class="ak-quick-card" href="{{ route('contact') }}"><div class="ak-quick-icon teal"><i class="fa-solid fa-headset"></i></div><div class="ak-quick-card-body"><h3>विशेषज्ञ सहायता</h3><p>परिवहन, भुगतान या सहायता के लिए संपर्क करें।</p></div><span class="ak-quick-arrow"><i class="fa-solid fa-arrow-right"></i></span></a>
    </div>
  </div>
</section>

{{-- ══ ABOUT ══════════════════════════════════════════════════════ --}}
<section class="ak-section ak-section-alt" aria-labelledby="about-h2">
  <div class="ak-shell">
    <div class="ak-process-grid">
      <div class="ak-about-img-grid">
        <img src="{{ asset('assets/images/ChatGPT Image Sep 8, 2026, 11_23_27 PM.png') }}" alt="किसान और खेत" loading="lazy"/>
        <img src="{{ asset('assets/images/ChatGPT Image Sep 8, 2026, 11_56_46 PM.png') }}" alt="सब्जी बाजार" loading="lazy"/>
        <img src="{{ asset('assets/images/ChatGPT Image Sep 9, 2026, 12_25_22 AM.png') }}" alt="मंडी" loading="lazy"/>
      </div>
      <div>
        <p class="ak-kicker">हमारे बारे में</p>
        <h2 id="about-h2">मध्य प्रदेश के किसानों का<br/><em>भरोसेमंद साथी।</em></h2>
        <p class="ak-muted" style="margin-bottom:16px">अपना किसान मध्य प्रदेश के ग्रामीण किसानों को शहरी बाजार से जोड़ने का एक भरोसेमंद मंच है। हम किसानों को सब्जी बाजार की सटीक जानकारी, लाइव मंडी भाव, सुरक्षित परिवहन और कृषि मार्गदर्शन देते हैं — बिल्कुल मुफ़्त।</p>
        <div class="ak-steps">
          <div class="ak-step"><div class="ak-step-num">01</div><div class="ak-step-body"><strong>सही जानकारी, सही समय</strong><span>लाइव मंडी भाव और बाजार की जानकारी — हर रोज़ अपडेट।</span></div></div>
          <div class="ak-step"><div class="ak-step-num">02</div><div class="ak-step-body"><strong>12+ जिलों में नेटवर्क</strong><span>दमोह, पन्ना, छतरपुर से जबलपुर, इंदौर तक — हर जिले में उपस्थिति।</span></div></div>
          <div class="ak-step"><div class="ak-step-num">03</div><div class="ak-step-body"><strong>भरोसेमंद परिवहन</strong><span>फसल को सुरक्षित बाजार तक पहुंचाने की बेहतर व्यवस्था।</span></div></div>
          <div class="ak-step"><div class="ak-step-num">04</div><div class="ak-step-body"><strong>100% मुफ़्त सेवा</strong><span>किसानों के लिए सभी जानकारी और सहायता बिल्कुल मुफ़्त।</span></div></div>
        </div>
        <div style="margin-top:28px;display:flex;gap:12px;flex-wrap:wrap;">
          <a class="ak-btn-primary" href="{{ route('about') }}"><i class="fa-solid fa-circle-info"></i> और जानें</a>
          <a class="ak-btn-outline-white" style="color:var(--ak-green);border-color:var(--ak-green-bright);background:var(--ak-green-xlight);" href="{{ route('contact') }}"><i class="fa-solid fa-phone"></i> संपर्क करें</a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ══ CATEGORIES ═════════════════════════════════════════════════ --}}
<section class="ak-section" aria-labelledby="cat-h2">
  <div class="ak-shell">
    <div class="ak-section-heading">
      <div><p class="ak-kicker">फसल श्रेणियां</p><h2 id="cat-h2">अपनी फसल की<br/><em>श्रेणी चुनें।</em></h2></div>
      <a class="ak-see-all" href="{{ route('market-price') }}">सभी भाव देखें <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="ak-category-grid">
      @forelse($categories as $cat)
      <a class="ak-category-card" href="{{ $cat->link_url ?: route('crop-price') }}">
        <div class="ak-cat-icon" style="background:#dcfce7;color:#15803d"><i class="{{ $cat->icon_class ?: 'fa-solid fa-leaf' }}"></i></div>
        <h3>{{ $cat->name }}</h3><span>{{ $cat->examples }}</span>
      </a>
      @empty
      <a class="ak-category-card" href="{{ route('vegetable-price') }}"><div class="ak-cat-icon" style="background:#dcfce7;color:#15803d"><i class="fa-solid fa-leaf"></i></div><h3>सब्जियां</h3><span>टमाटर, प्याज, आलू</span></a>
      <a class="ak-category-card" href="{{ route('crop-price') }}"><div class="ak-cat-icon" style="background:#fef9c3;color:#ca8a04"><i class="fa-solid fa-wheat-awn"></i></div><h3>अनाज</h3><span>गेहूं, धान, मक्का</span></a>
      <a class="ak-category-card" href="{{ route('crop-price') }}"><div class="ak-cat-icon" style="background:#fff7ed;color:#ea580c"><i class="fa-solid fa-circle-dot"></i></div><h3>दलहन</h3><span>चना, अरहर, मूंग</span></a>
      <a class="ak-category-card" href="{{ route('crop-price') }}"><div class="ak-cat-icon" style="background:#fef3c7;color:#b45309"><i class="fa-solid fa-droplet"></i></div><h3>तिलहन</h3><span>सोयाबीन, सरसों, तिल</span></a>
      <a class="ak-category-card" href="{{ route('vegetable-price') }}"><div class="ak-cat-icon" style="background:#f0fdf4;color:#16a34a"><i class="fa-solid fa-pepper-hot"></i></div><h3>मसाले</h3><span>मिर्च, अदरक, लहसुन</span></a>
      <a class="ak-category-card" href="{{ route('crop-price') }}"><div class="ak-cat-icon" style="background:#f0f9ff;color:#0369a1"><i class="fa-solid fa-cloud-rain"></i></div><h3>नकदी फसल</h3><span>कपास, गन्ना, जूट</span></a>
      @endforelse
    </div>
  </div>
</section>

{{-- ══ MANDI BHAV PREVIEW ════════════════════════════════════════ --}}
<section class="ak-section ak-section-alt" aria-labelledby="mandi-h2">
  <div class="ak-shell">
    <div class="ak-section-heading">
      <div><p class="ak-kicker">{{ !empty($priceFeed['is_fallback']) ? 'उदाहरण भाव' : 'बाजार भाव · ' . ($priceFeed['source'] ?? 'बाजार डेटा') }}</p><h2 id="mandi-h2">उपलब्ध<br/><em>मंडी भाव।</em></h2></div>
      <a class="ak-see-all" href="{{ route('mandi-bhav') }}">पूरा भाव देखें <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    @if(!empty($priceFeed['is_fallback']))
    <div class="ak-notice mb-3" role="status"><i class="fa-solid fa-circle-info text-success mt-1"></i><p>लाइव डेटा अभी उपलब्ध नहीं है। ये स्थानीय उदाहरण भाव हैं, आज के पक्के मंडी भाव नहीं।</p></div>
    @endif
    <div class="ak-mandi-grid">
      @forelse($prices->take(8) as $p)
      <div class="ak-mandi-card">
        <div class="ak-mandi-card-head">
          <div class="ak-mandi-vegname">{{ $p->commodity_name }}<small>{{ $p->commodity_en ?? '' }}</small></div>
          <div class="ak-mandi-icon" style="background:#dcfce7;color:#15803d"><i class="{{ $p->icon_class ?? 'fa-solid fa-leaf' }}"></i></div>
        </div>
        <div class="ak-mandi-price">₹{{ number_format((float)$p->price) }} <small>/ {{ $p->unit }}</small></div>
        <span class="ak-mandi-trend {{ $p->trend==='up'?'ak-trend-up':($p->trend==='down'?'ak-trend-down':'ak-trend-same') }}">
          @if($p->trend==='up')<i class="fa-solid fa-arrow-trend-up"></i> बढ़त
          @elseif($p->trend==='down')<i class="fa-solid fa-arrow-trend-down"></i> गिरावट
          @else<i class="fa-solid fa-equals"></i> स्थिर@endif
        </span>
      </div>
      @empty
      <div class="ak-notice"><i class="fa-solid fa-circle-info text-success mt-1"></i><p>इस समय दिखाने के लिए कोई भाव उपलब्ध नहीं है। पूरी भाव सूची कुछ देर बाद फिर देखें।</p></div>
      @endforelse
    </div>
    <div style="text-align:center;margin-top:28px;"><a class="ak-btn-primary" href="{{ route('mandi-bhav') }}"><i class="fa-solid fa-chart-line"></i> सभी उपलब्ध भाव देखें</a></div>
  </div>
</section>

{{-- ══ SERVICES ═══════════════════════════════════════════════════ --}}
<section class="ak-section" aria-labelledby="serv-h2">
  <div class="ak-shell">
    <div class="ak-section-heading">
      <div><p class="ak-kicker">हमारी सेवाएं</p><h2 id="serv-h2">खेती से बाजार तक,<br/><em>हर कदम पर साथ।</em></h2></div>
      <p class="ak-section-desc">किसानों को अपनी फसल के लिए सही निर्णय लेने में मदद करने वाली सेवाएं।</p>
    </div>
    <div class="ak-service-grid">
      @forelse($services as $sv)
      <a class="ak-service-card" href="{{ route('services.show', $sv) }}" style="--ak-stripe:var(--ak-green)">
        <span class="ak-service-num">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span>
        <div class="ak-service-icon-wrap" style="background:#dcfce7;color:#15803d"><i class="{{ $sv->icon ?: 'fa-solid fa-shop' }}"></i></div>
        <h3>{{ $sv->title }}</h3><p>{{ $sv->short_description }}</p>
        <span class="ak-service-link">विस्तार से देखें <i class="fa-solid fa-arrow-right"></i></span>
      </a>
      @empty
      <a class="ak-service-card" href="{{ route('services') }}" style="--ak-stripe:#22c55e"><span class="ak-service-num">01</span><div class="ak-service-icon-wrap" style="background:#dcfce7;color:#15803d"><i class="fa-solid fa-shop"></i></div><h3>सब्जी बाजार</h3><p>12 जिलों की सब्जी मंडी और बाजार की सटीक जानकारी।</p><span class="ak-service-link">बाजार देखें <i class="fa-solid fa-arrow-right"></i></span></a>
      <a class="ak-service-card" href="{{ route('mandi-bhav') }}" style="--ak-stripe:#f59e0b"><span class="ak-service-num">02</span><div class="ak-service-icon-wrap" style="background:#fef9c3;color:#ca8a04"><i class="fa-solid fa-chart-line"></i></div><h3>लाइव मंडी भाव</h3><p>ताज़ा मंडी भाव — सब्जी और फसल दोनों के न्यूनतम, अधिकतम और मोडल भाव।</p><span class="ak-service-link">भाव देखें <i class="fa-solid fa-arrow-right"></i></span></a>
      <a class="ak-service-card" href="{{ route('transport') }}" style="--ak-stripe:#f97316"><span class="ak-service-num">03</span><div class="ak-service-icon-wrap" style="background:#fff7ed;color:#ea580c"><i class="fa-solid fa-truck-moving"></i></div><h3>परिवहन सहायता</h3><p>सब्जियों को एक स्थान से दूसरे स्थान पर सुरक्षित पहुंचाने की व्यवस्था।</p><span class="ak-service-link">संपर्क करें <i class="fa-solid fa-arrow-right"></i></span></a>
      @endforelse
    </div>
  </div>
</section>

{{-- ══ HOW IT WORKS ═══════════════════════════════════════════════ --}}
<section class="ak-section ak-section-alt" aria-labelledby="how-h2">
  <div class="ak-shell">
    <div class="ak-process-grid">
      <div class="ak-process-img-wrap">
        <img src="{{ asset('assets/images/ChatGPT Image Sep 8, 2026, 11_31_14 PM.png') }}" alt="इंदौर, मध्य प्रदेश" loading="lazy"/>
        <span class="ak-process-img-label"><i class="fa-solid fa-location-dot"></i> इंदौर, मध्य प्रदेश</span>
      </div>
      <div>
        <p class="ak-kicker">हमारा तरीका</p>
        <h2 id="how-h2">जानकारी से निर्णय तक,<br/><em>सरल और स्पष्ट।</em></h2>
        <p class="ak-muted" style="margin-bottom:4px">किसान को सही बाजार तक पहुंचने के लिए भरोसेमंद जानकारी और समय पर सहयोग मिलना जरूरी है।</p>
        <div class="ak-steps">
          <div class="ak-step"><div class="ak-step-num">01</div><div class="ak-step-body"><strong>आज का भाव देखें</strong><span>लाइव मंडी भाव से अपनी फसल का सही दाम जानें।</span></div></div>
          <div class="ak-step"><div class="ak-step-num">02</div><div class="ak-step-body"><strong>अपना जिला चुनें</strong><span>अपने क्षेत्र की बाजार जानकारी और मांग समझें।</span></div></div>
          <div class="ak-step"><div class="ak-step-num">03</div><div class="ak-step-body"><strong>बेहतर दाम पाएं</strong><span>सही जानकारी और सही बाजार से उचित मूल्य प्राप्त करें।</span></div></div>
          <div class="ak-step"><div class="ak-step-num">04</div><div class="ak-step-body"><strong>हमसे संपर्क करें</strong><span>परिवहन या किसी भी सहायता के लिए हमेशा तैयार।</span></div></div>
        </div>
        <div style="margin-top:28px;"><a class="ak-btn-primary" href="{{ route('information') }}"><i class="fa-solid fa-book-open"></i> कृषि जानकारी पढ़ें</a></div>
      </div>
    </div>
  </div>
</section>

{{-- ══ DISTRICT GRID ══════════════════════════════════════════════ --}}
<section class="ak-section" aria-labelledby="dist-h2">
  <div class="ak-shell">
    <div class="ak-section-heading">
      <div><p class="ak-kicker">जिले के अनुसार</p><h2 id="dist-h2">अपने नजदीकी<br/><em>बाजार को खोजें।</em></h2></div>
      <div class="ak-district-search-bar">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" id="districtSearch" placeholder="जिले का नाम खोजें…" aria-label="जिले का नाम खोजें"/>
      </div>
    </div>
    @php $grads=['ak-dist-g1','ak-dist-g2','ak-dist-g3','ak-dist-g4','ak-dist-g5','ak-dist-g6','ak-dist-g7','ak-dist-g8','ak-dist-g9','ak-dist-g10','ak-dist-g11','ak-dist-g12']; @endphp
    <div class="ak-district-img-grid" id="districtGrid">
      @forelse($districts as $dist)
      <a class="ak-dist-card" href="{{ route('districts.show', $dist) }}" aria-label="{{ $dist->name }} — सब्जी मंडी" data-name="{{ mb_strtolower($dist->name) }}">
        <div class="ak-dist-card-top {{ $grads[$loop->index % 12] }}"><i class="fa-solid fa-location-dot"></i></div>
        <div class="ak-dist-card-bottom"><span class="ak-dist-card-name">{{ $dist->name }}</span><span class="ak-dist-card-region">{{ $dist->region ?? 'मध्य प्रदेश' }}</span></div>
      </a>
      @empty
      @foreach([['दमोह','विंध्य क्षेत्र'],['पन्ना','विंध्य'],['छतरपुर','विंध्य'],['भोपाल','राजधानी'],['सागर','विंध्य'],['नरसिंहपुर','महाकौशल'],['जबलपुर','महाकौशल'],['ग्वालियर','चंबल'],['बालाघाट','महाकौशल'],['रीवा','विंध्य'],['टीकमगढ़','विंध्य'],['राजगढ़','मालवा']] as $i=>[$n,$r])
      <div class="ak-dist-card"><div class="ak-dist-card-top {{ $grads[$i%12] }}"><i class="fa-solid fa-location-dot"></i></div><div class="ak-dist-card-bottom"><span class="ak-dist-card-name">{{ $n }}</span><span class="ak-dist-card-region">{{ $r }}</span></div></div>
      @endforeach
      @endforelse
    </div>
    <p class="ak-district-empty" id="districtEmpty" aria-live="polite" style="display:none;text-align:center;padding:24px;color:var(--ak-text-muted);">इस नाम का जिला नहीं मिला।</p>
  </div>
</section>

{{-- ══ TEAM ══════════════════════════════════════════════════════ --}}
<section class="ak-section ak-section-alt" aria-labelledby="team-h2">
  <div class="ak-shell">
    <div class="ak-section-heading">
      <div><p class="ak-kicker">हमारी टीम</p><h2 id="team-h2">किसानों के लिए<br/><em>हमारा समर्पण।</em></h2></div>
      <a class="ak-see-all" href="{{ route('about') }}">हमारे बारे में <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="ak-team-grid">
      @forelse($team as $m)
      <div class="ak-team-card">
        @if($m->image)<img class="ak-team-card-img" src="{{ asset($m->image) }}" alt="{{ $m->name }}" loading="lazy"/>
        @else<img class="ak-team-card-img" src="{{ asset('assets/images/ChatGPT Image Sep 8, 2026, 11_56_46 PM.png') }}" alt="{{ $m->name }}" loading="lazy"/>@endif
        <div class="ak-team-card-body"><strong>{{ $m->name }}</strong><span>{{ $m->designation }}</span><p>{{ Str::limit($m->bio,120) }}</p></div>
      </div>
      @empty
      @foreach([['हेमंत कच्छी','संस्थापक एवं CEO','ChatGPT Image Sep 8, 2026, 11_56_46 PM.png','मध्य प्रदेश के किसानों को डिजिटल जानकारी से जोड़ने का सपना लेकर अपना किसान की नींव रखी।'],['कृषि विशेषज्ञ','बाजार एवं फसल सलाहकार','ChatGPT Image Sep 8, 2026, 11_31_14 PM.png','12+ जिलों में बाजार अनुसंधान और किसानों को मंडी की सटीक जानकारी देना हमारी प्राथमिकता है।'],['परिवहन टीम','लॉजिस्टिक्स एवं ढुलाई','ChatGPT Image Sep 9, 2026, 12_22_32 AM.png','फसल को खेत से बाजार तक सुरक्षित पहुंचाने और समय पर भुगतान सुनिश्चित करने में हमारी भूमिका।']] as [$nm,$dg,$img,$bio])
      <div class="ak-team-card"><img class="ak-team-card-img" src="{{ asset('assets/images/'.$img) }}" alt="{{ $nm }}" loading="lazy"/><div class="ak-team-card-body"><strong>{{ $nm }}</strong><span>{{ $dg }}</span><p>{{ $bio }}</p></div></div>
      @endforeach
      @endforelse
    </div>
  </div>
</section>

{{-- ══ MP MAP ══════════════════════════════════════════════════════ --}}
<section class="ak-section" aria-labelledby="mp-h2">
  <div class="ak-shell">
    <div class="ak-process-grid">
      <div>
        <p class="ak-kicker">मध्य प्रदेश</p><h2 id="mp-h2">12+ जिलों में<br/><em>सक्रिय नेटवर्क।</em></h2>
        <p class="ak-muted" style="margin-bottom:24px">अपना किसान मध्य प्रदेश के दमोह, पन्ना, छतरपुर, भोपाल, सागर, जबलपुर, ग्वालियर सहित 12 से अधिक जिलों में किसानों को सीधे बाजार से जोड़ रहा है।</p>
        <div class="ak-content-grid" style="grid-template-columns:repeat(2,1fr);gap:14px">
          <div class="ak-content-card"><div class="ak-content-card-icon" style="background:#dcfce7;color:#15803d"><i class="fa-solid fa-map-location-dot"></i></div><h3>विंध्य क्षेत्र</h3><p>दमोह, पन्ना, छतरपुर, सागर, रीवा, टीकमगढ़</p></div>
          <div class="ak-content-card"><div class="ak-content-card-icon" style="background:#fef9c3;color:#ca8a04"><i class="fa-solid fa-wheat-awn"></i></div><h3>मालवा क्षेत्र</h3><p>भोपाल, राजगढ़, इंदौर और आसपास के जिले</p></div>
          <div class="ak-content-card"><div class="ak-content-card-icon" style="background:#eff6ff;color:#2563eb"><i class="fa-solid fa-water"></i></div><h3>महाकौशल</h3><p>जबलपुर, नरसिंहपुर, बालाघाट</p></div>
          <div class="ak-content-card"><div class="ak-content-card-icon" style="background:#fff7ed;color:#ea580c"><i class="fa-solid fa-tractor"></i></div><h3>चंबल क्षेत्र</h3><p>ग्वालियर और आसपास के जिले</p></div>
        </div>
        <div style="margin-top:24px;"><a class="ak-btn-primary" href="{{ route('services') }}"><i class="fa-solid fa-map-location-dot"></i> अपना जिला खोजें</a></div>
      </div>
      <div class="ak-mp-map-wrap"><img src="{{ asset('assets/images/mp naksha.jpg') }}" alt="मध्य प्रदेश नक्शा" loading="lazy"/></div>
    </div>
  </div>
</section>

{{-- ══ CTA ════════════════════════════════════════════════════════ --}}
<section class="ak-cta-section" aria-labelledby="cta-h2">
  <div class="ak-shell ak-cta-inner">
    <div>
      <p class="ak-kicker">आज ही शुरुआत करें</p>
      <h2 id="cta-h2">आपकी फसल का बेहतर कल,<br/><em>आज की जानकारी से।</em></h2>
      <p>अभी हमसे जुड़ें और मध्य प्रदेश के हजारों किसानों की तरह सही बाजार की जानकारी पाएं।</p>
    </div>
    <div class="ak-cta-actions">
      <a class="ak-btn-white" href="{{ route('contact') }}"><i class="fa-solid fa-phone"></i> संपर्क करें</a>
      <a class="ak-btn-outline-light" href="{{ route('mandi-bhav') }}"><i class="fa-solid fa-chart-line"></i> मंडी भाव देखें</a>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
/* Slider */
.ak-slider-section{position:relative;width:100%;height:clamp(250px,42vw,620px);overflow:hidden;background:var(--ak-green-dark)}
.ak-slider-track{display:flex;height:100%;transition:transform .6s cubic-bezier(.4,0,.2,1)}
.ak-slide{min-width:100%;height:100%;overflow:hidden}.ak-slide a{display:block;width:100%;height:100%}.ak-slide img{width:100%;height:100%;display:block;object-fit:contain}
.ak-slider-arrow{position:absolute;top:50%;transform:translateY(-50%);z-index:20;width:46px;height:46px;background:rgba(255,255,255,.92);border:none;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--ak-green);cursor:pointer;box-shadow:0 4px 16px rgba(0,0,0,.18);transition:background .2s,color .2s}
.ak-slider-arrow:hover{background:var(--ak-green);color:#fff}.ak-slider-prev{left:14px}.ak-slider-next{right:14px}
.ak-slider-dots{position:absolute;bottom:14px;left:50%;transform:translateX(-50%);display:flex;gap:8px;z-index:20}
.ak-slider-dot{width:10px;height:10px;border-radius:50%;background:rgba(255,255,255,.5);border:none;cursor:pointer;transition:background .2s,transform .2s;padding:0}
.ak-slider-dot.active{background:var(--ak-green-bright);transform:scale(1.3)}
.ak-slider-live{position:absolute;top:16px;right:16px;background:rgba(26,92,42,.88);color:#fff;font:700 11px var(--ak-font-en);padding:5px 12px;border-radius:20px;z-index:20;display:flex;align-items:center;gap:6px;backdrop-filter:blur(4px)}
.ak-slider-live-dot{width:7px;height:7px;background:var(--ak-green-bright);border-radius:50%;animation:ak-pulse-dot 1.4s ease-in-out infinite}
@keyframes ak-pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.7)}}
.ak-slider-counter{position:absolute;bottom:14px;right:14px;background:rgba(0,0,0,.45);color:rgba(255,255,255,.9);font:700 12px var(--ak-font-en);padding:4px 10px;border-radius:20px;z-index:20}
/* Ticker */
.ak-ticker-wrap{background:var(--ak-green-dark);padding:11px 0;overflow:hidden;white-space:nowrap}
.ak-ticker-inner{display:inline-flex;animation:ak-ticker 35s linear infinite}
.ak-ticker-wrap:hover .ak-ticker-inner{animation-play-state:paused}
.ak-ticker-item{display:inline-flex;align-items:center;gap:8px;padding:0 26px;border-right:1px solid rgba(255,255,255,.14);font:600 13px var(--ak-font-hi);color:#fff}
.ak-ticker-item i{color:var(--ak-lime);font-size:12px}.ak-ticker-up{color:var(--ak-green-bright);font-size:11px}.ak-ticker-down{color:#f87171;font-size:11px}
@keyframes ak-ticker{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
/* Mandi cards */
.ak-mandi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.ak-mandi-card{background:var(--ak-white);border:1.5px solid var(--ak-border);border-radius:var(--ak-r-lg);padding:18px 16px;box-shadow:var(--ak-shadow-card);transition:transform var(--ak-transition)}
.ak-mandi-card:hover{transform:translateY(-3px);box-shadow:var(--ak-shadow-lg)}
.ak-mandi-card-head{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px}
.ak-mandi-vegname{font:700 15px var(--ak-font-hi);color:var(--ak-text)}.ak-mandi-vegname small{display:block;font:400 11px var(--ak-font-en);color:var(--ak-text-muted)}
.ak-mandi-icon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px}
.ak-mandi-price{font:800 20px var(--ak-font-en);color:var(--ak-text);margin-bottom:8px}.ak-mandi-price small{font:500 11px var(--ak-font-hi);color:var(--ak-text-muted)}
.ak-mandi-trend{display:inline-flex;align-items:center;gap:5px;font:600 12px var(--ak-font-hi);padding:4px 10px;border-radius:var(--ak-r-full)}
.ak-trend-up{background:#dcfce7;color:#15803d}.ak-trend-down{background:#fee2e2;color:#dc2626}.ak-trend-same{background:#f3f4f6;color:#6b7280}
/* Team */
.ak-team-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.ak-team-card{background:var(--ak-white);border:1.5px solid var(--ak-border);border-radius:var(--ak-r-xl);overflow:hidden;box-shadow:var(--ak-shadow-card);transition:all var(--ak-transition)}
.ak-team-card:hover{transform:translateY(-5px);box-shadow:var(--ak-shadow-lg)}
.ak-team-card-img{width:100%;aspect-ratio:3/3.2;object-fit:cover;object-position:top center;display:block}
.ak-team-card-body{padding:18px 16px 20px}.ak-team-card-body strong{display:block;font:700 16px var(--ak-font-hi);color:var(--ak-text);margin-bottom:4px}
.ak-team-card-body span{font:500 12px var(--ak-font-hi);color:var(--ak-green);display:block;margin-bottom:8px}
.ak-team-card-body p{font:400 12px/1.7 var(--ak-font-hi);color:var(--ak-text-muted)}
/* About imgs */
.ak-about-img-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.ak-about-img-grid img{width:100%;border-radius:var(--ak-r-lg);object-fit:cover;box-shadow:var(--ak-shadow)}
.ak-about-img-grid img:first-child{grid-row:span 2;height:100%}
/* District grid */
.ak-district-img-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.ak-dist-card{display:flex;flex-direction:column;align-items:center;border-radius:var(--ak-r-lg);overflow:hidden;box-shadow:var(--ak-shadow-card);text-decoration:none;transition:transform var(--ak-transition),box-shadow var(--ak-transition);min-height:160px;background:var(--ak-white);border:1.5px solid var(--ak-border)}
.ak-dist-card:hover{transform:translateY(-5px);box-shadow:var(--ak-shadow-lg)}
.ak-dist-card-top{width:100%;flex:1;display:flex;align-items:center;justify-content:center;padding:20px 12px 14px;min-height:100px}
.ak-dist-card-top i{font-size:40px;color:#fff;filter:drop-shadow(0 3px 8px rgba(0,0,0,.22));transition:transform .3s ease}
.ak-dist-card:hover .ak-dist-card-top i{transform:translateY(-4px) scale(1.12)}
.ak-dist-card-bottom{width:100%;background:var(--ak-white);padding:10px 12px 12px;text-align:center;border-top:1.5px solid var(--ak-border)}
.ak-dist-card-name{display:block;font:700 15px var(--ak-font-hi);color:var(--ak-text);margin-bottom:2px}.ak-dist-card:hover .ak-dist-card-name{color:var(--ak-green)}
.ak-dist-card-region{display:block;font:400 11px var(--ak-font-hi);color:var(--ak-text-muted)}
.ak-dist-g1{background:linear-gradient(145deg,#0f3d1c,#1a5c2a)}.ak-dist-g2{background:linear-gradient(145deg,#1a3a5c,#2563a8)}.ak-dist-g3{background:linear-gradient(145deg,#5c1a1a,#b91c1c)}.ak-dist-g4{background:linear-gradient(145deg,#1a3c1a,#16a34a)}.ak-dist-g5{background:linear-gradient(145deg,#3c2c1a,#c47a1a)}.ak-dist-g6{background:linear-gradient(145deg,#1a2c3c,#0d9488)}.ak-dist-g7{background:linear-gradient(145deg,#1a1a3c,#7c3aed)}.ak-dist-g8{background:linear-gradient(145deg,#1c3a2a,#15803d)}.ak-dist-g9{background:linear-gradient(145deg,#3c1a1a,#dc2626)}.ak-dist-g10{background:linear-gradient(145deg,#1a3c3a,#059669)}.ak-dist-g11{background:linear-gradient(145deg,#3c2c1a,#f97316)}.ak-dist-g12{background:linear-gradient(145deg,#1a2c3c,#2563eb)}
/* MP map */
.ak-mp-map-wrap{border-radius:var(--ak-r-xl);overflow:hidden;box-shadow:var(--ak-shadow-lg);border:3px solid var(--ak-green-light)}.ak-mp-map-wrap img{width:100%;display:block}
@media(max-width:1024px){.ak-district-img-grid{grid-template-columns:repeat(3,1fr)}.ak-mandi-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:768px){.ak-district-img-grid{grid-template-columns:repeat(2,1fr);gap:10px}.ak-team-grid{grid-template-columns:repeat(2,1fr)}.ak-mandi-grid{grid-template-columns:repeat(2,1fr)}.ak-about-img-grid{grid-template-columns:1fr}.ak-about-img-grid img:first-child{grid-row:auto;height:180px}.ak-slider-counter{display:none}.ak-slider-arrow{width:36px;height:36px;font-size:14px}}
@media(max-width:768px){.ak-slider-section{height:clamp(220px,62vw,390px)}}
@media(max-width:480px){.ak-district-img-grid{grid-template-columns:repeat(2,1fr)}.ak-dist-card-top i{font-size:26px}.ak-dist-card-region{display:none}.ak-team-grid{grid-template-columns:1fr}.ak-mandi-grid{grid-template-columns:1fr}.ak-slider-arrow{display:none}}
</style>
@endpush

@push('scripts')
<script>
(function(){
  'use strict';
  var SC={{ $sliders->count() }},INTERVAL=4500;
  var track=document.getElementById('sliderTrack'),dots=document.querySelectorAll('.ak-slider-dot'),counter=document.getElementById('sliderCounter'),prev=document.getElementById('sliderPrev'),nxt=document.getElementById('sliderNext'),sec=document.getElementById('akHeroSlider');
  var cur=0,timer=null,reduced=window.matchMedia('(prefers-reduced-motion:reduce)').matches;
  function goTo(i){cur=(i+SC)%SC;track&&(track.style.transform='translateX(-'+cur*100+'%)');dots.forEach(function(d,j){d.classList.toggle('active',j===cur);d.setAttribute('aria-selected',String(j===cur));});counter&&(counter.textContent=(cur+1)+' / '+SC);}
  function next(){goTo(cur+1);}function prv(){goTo(cur-1);}
  function startAuto(){if(reduced)return;clearInterval(timer);timer=setInterval(next,INTERVAL);}
  function stopAuto(){clearInterval(timer);}
  prev&&prev.addEventListener('click',function(){prv();stopAuto();startAuto();});
  nxt&&nxt.addEventListener('click',function(){next();stopAuto();startAuto();});
  dots.forEach(function(d){d.addEventListener('click',function(){goTo(parseInt(this.getAttribute('data-index'),10));stopAuto();startAuto();});});
  if(sec){sec.setAttribute('tabindex','0');sec.addEventListener('keydown',function(e){if(e.key==='ArrowLeft'){prv();stopAuto();startAuto();}if(e.key==='ArrowRight'){next();stopAuto();startAuto();}});sec.addEventListener('mouseenter',stopAuto);sec.addEventListener('mouseleave',startAuto);}
  var tx=0,ty=0;
  if(track){track.addEventListener('touchstart',function(e){tx=e.touches[0].clientX;ty=e.touches[0].clientY;},{passive:true});track.addEventListener('touchend',function(e){var dx=e.changedTouches[0].clientX-tx,dy=e.changedTouches[0].clientY-ty;if(Math.abs(dx)>Math.abs(dy)&&Math.abs(dx)>40){dx<0?next():prv();stopAuto();startAuto();}},{passive:true});}
  document.addEventListener('visibilitychange',function(){document.hidden?stopAuto():startAuto();});
  goTo(0);startAuto();
  /* District search */
  var ds=document.getElementById('districtSearch'),dg=document.getElementById('districtGrid'),de=document.getElementById('districtEmpty');
  if(ds&&dg){ds.addEventListener('input',function(){var q=this.value.trim().toLowerCase(),v=0;dg.querySelectorAll('a[data-name]').forEach(function(c){var m=!q||c.getAttribute('data-name').indexOf(q)!==-1;c.style.display=m?'':'none';if(m)v++;});if(de)de.style.display=v?'none':'block';});}
})();
</script>
@endpush
