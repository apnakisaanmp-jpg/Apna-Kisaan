@php($formId = $source ?? 'contact')
<form method="post" action="{{ route('leads.contact') }}" class="ak-form">
    @csrf
    <input type="hidden" name="source_page" value="{{ $formId }}">

    <div class="ak-form-intro">
        <h2>{{ $formId === 'internship' ? 'अपनी रुचि दर्ज करें' : 'संदेश भेजें' }}</h2>
        <p>{{ $formId === 'internship' ? 'इंटर्नशिप से जुड़ी जानकारी के लिए अपने संपर्क विवरण और रुचि का क्षेत्र लिखें।' : 'अपनी जरूरत बताएं; हमारी सहायता टीम आपसे संपर्क करेगी।' }}</p>
    </div>

    <datalist id="{{ $formId }}-districts">
        @foreach ($districts as $district)
            <option value="{{ $district->name }}"></option>
        @endforeach
    </datalist>

    <div class="row g-3">
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="{{ $formId }}-name">पूरा नाम <span class="ak-required">*</span></label>
                <input class="form-control @error('name') is-invalid @enderror" id="{{ $formId }}-name" name="name"
                    value="{{ old('name') }}" autocomplete="name" maxlength="120" required>
                @error('name')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="{{ $formId }}-phone">मोबाइल नंबर <span class="ak-required">*</span></label>
                <input class="form-control @error('phone') is-invalid @enderror" id="{{ $formId }}-phone" name="phone"
                    type="tel" inputmode="tel" autocomplete="tel" pattern="[0-9+\-\s]{10,15}" maxlength="15"
                    value="{{ old('phone') }}" placeholder="उदाहरण: 9876543210" required>
                @error('phone')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="{{ $formId }}-district">जिला</label>
                <input class="form-control @error('district') is-invalid @enderror" id="{{ $formId }}-district"
                    name="district" value="{{ old('district') }}" list="{{ $formId }}-districts" maxlength="120"
                    autocomplete="address-level1" placeholder="अपना जिला चुनें या लिखें">
                @error('district')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="{{ $formId }}-crop">{{ $formId === 'internship' ? 'रुचि का क्षेत्र' : 'फसल / सब्जी' }}</label>
                <input class="form-control @error('vegetable') is-invalid @enderror" id="{{ $formId }}-crop"
                    name="vegetable" value="{{ old('vegetable') }}" maxlength="120"
                    placeholder="{{ $formId === 'internship' ? 'जैसे: कृषि, बाजार, डिजिटल सेवाएं' : 'जैसे: गेहूं, टमाटर' }}">
                @error('vegetable')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12">
            <div class="ak-form-field">
                <label for="{{ $formId }}-subject">विषय</label>
                <input class="form-control @error('subject') is-invalid @enderror" id="{{ $formId }}-subject"
                    name="subject" value="{{ old('subject') }}" maxlength="150"
                    placeholder="{{ $formId === 'internship' ? 'इंटर्नशिप में आपकी रुचि' : 'आपके संदेश का विषय' }}">
                @error('subject')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12">
            <div class="ak-form-field">
                <label for="{{ $formId }}-message">आपकी जरूरत <span class="ak-required">*</span></label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="{{ $formId }}-message"
                    name="message" rows="5" maxlength="2000" required
                    placeholder="{{ $formId === 'internship' ? 'अपनी पढ़ाई, उपलब्धता और रुचि के क्षेत्र की जानकारी दें।' : 'कृपया अपनी जरूरत का विवरण लिखें।' }}">{{ old('message') }}</textarea>
                @error('message')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <p class="ak-field-hint mt-3"><span class="ak-required">*</span> जरूरी जानकारी</p>
    <div class="ak-form-actions">
        <button class="ak-btn" type="submit"><i class="fa-solid fa-paper-plane"></i> संदेश भेजें</button>
        <span class="ak-field-hint">आपकी जानकारी सुरक्षित रखी जाएगी।</span>
    </div>
</form>
