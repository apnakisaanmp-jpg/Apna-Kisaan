@php
    $farmerType = old('type', 'farmer');
    $farmerFields = ['district', 'main_crop'];
    $buyerFields = ['business_type', 'city', 'required_crop', 'required_quantity'];
@endphp
<form method="post" action="{{ route('leads.farmer') }}" class="ak-form">
    @csrf

    <div class="ak-form-intro">
        <h2>पंजीकरण फॉर्म</h2>
        <p>सही जानकारी भरें। हमारी टीम आपके पंजीकरण की पुष्टि के लिए संपर्क करेगी।</p>
    </div>

    <div class="row g-3">
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-type">आपका पंजीकरण <span class="ak-required">*</span></label>
                <select class="form-select" id="registration-type" name="type" required>
                    <option value="farmer" @selected($farmerType === 'farmer')>मैं किसान हूं</option>
                    <option value="buyer" @selected($farmerType === 'buyer')>मैं खरीदार / व्यापारी हूं</option>
                </select>
                @error('type')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <h3 class="ak-form-section"><i class="fa-solid fa-user"></i> संपर्क जानकारी</h3>
    <div class="row g-3">
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-name">पूरा नाम <span class="ak-required">*</span></label>
                <input class="form-control @error('name') is-invalid @enderror" id="registration-name" name="name"
                    value="{{ old('name') }}" autocomplete="name" maxlength="120" required>
                @error('name')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-mobile">मोबाइल नंबर <span class="ak-required">*</span></label>
                <input class="form-control @error('mobile') is-invalid @enderror" id="registration-mobile" name="mobile"
                    type="tel" inputmode="tel" autocomplete="tel" pattern="[0-9+\-\s]{10,15}" maxlength="15"
                    value="{{ old('mobile') }}" placeholder="उदाहरण: 9876543210" required>
                <span class="ak-field-hint">10 अंकों का सही संपर्क नंबर दर्ज करें।</span>
                @error('mobile')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1" data-registration-fields="farmer">
        <div class="col-12"><h3 class="ak-form-section"><i class="fa-solid fa-tractor"></i> किसान की जानकारी</h3></div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-district">जिला <span class="ak-required">*</span></label>
                <select class="form-select @error('district') is-invalid @enderror" id="registration-district" name="district">
                    <option value="">अपना जिला चुनें</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->name }}" @selected(old('district') === $district->name)>{{ $district->name }}</option>
                    @endforeach
                </select>
                @error('district')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-village">गांव</label>
                <input class="form-control @error('village') is-invalid @enderror" id="registration-village" name="village"
                    value="{{ old('village') }}" maxlength="120" autocomplete="address-level3">
                @error('village')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-main-crop">मुख्य फसल <span class="ak-required">*</span></label>
                <input class="form-control @error('main_crop') is-invalid @enderror" id="registration-main-crop" name="main_crop"
                    value="{{ old('main_crop') }}" maxlength="120" placeholder="उदाहरण: गेहूं, सोयाबीन">
                @error('main_crop')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-farm-area">खेती का क्षेत्रफल (एकड़)</label>
                <input class="form-control @error('farm_area') is-invalid @enderror" id="registration-farm-area" name="farm_area"
                    type="number" min="0" step="0.01" value="{{ old('farm_area') }}" inputmode="decimal">
                @error('farm_area')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1" data-registration-fields="buyer">
        <div class="col-12"><h3 class="ak-form-section"><i class="fa-solid fa-store"></i> खरीदार की जानकारी</h3></div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-business-type">व्यवसाय का प्रकार <span class="ak-required">*</span></label>
                <select class="form-select @error('business_type') is-invalid @enderror" id="registration-business-type" name="business_type">
                    <option value="">व्यवसाय चुनें</option>
                    @foreach (['थोक व्यापारी', 'खुदरा व्यापारी', 'प्रसंस्करण इकाई', 'निर्यातक', 'अन्य'] as $businessType)
                        <option value="{{ $businessType }}" @selected(old('business_type') === $businessType)>{{ $businessType }}</option>
                    @endforeach
                </select>
                @error('business_type')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-city">शहर <span class="ak-required">*</span></label>
                <input class="form-control @error('city') is-invalid @enderror" id="registration-city" name="city"
                    value="{{ old('city') }}" maxlength="120" autocomplete="address-level2">
                @error('city')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-required-crop">कौन-सी फसल चाहिए? <span class="ak-required">*</span></label>
                <input class="form-control @error('required_crop') is-invalid @enderror" id="registration-required-crop" name="required_crop"
                    value="{{ old('required_crop') }}" maxlength="120" placeholder="उदाहरण: टमाटर, गेहूं">
                @error('required_crop')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="registration-required-quantity">आवश्यक मात्रा (क्विंटल) <span class="ak-required">*</span></label>
                <input class="form-control @error('required_quantity') is-invalid @enderror" id="registration-required-quantity"
                    name="required_quantity" type="number" min="0.01" step="0.01" inputmode="decimal"
                    value="{{ old('required_quantity') }}">
                @error('required_quantity')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <p class="ak-field-hint mt-3"><span class="ak-required">*</span> जरूरी जानकारी</p>
    <div class="ak-form-actions">
        <button class="ak-btn" type="submit"><i class="fa-solid fa-user-plus"></i> पंजीकरण भेजें</button>
        <span class="ak-field-hint">आपकी जानकारी केवल पंजीकरण और संपर्क के लिए उपयोग होगी।</span>
    </div>
</form>

@push('scripts')
    <script>
        (function () {
            var typeSelect = document.getElementById('registration-type');
            if (!typeSelect) return;

            var fieldGroups = document.querySelectorAll('[data-registration-fields]');
            var conditionalFields = {
                farmer: ['district', 'main_crop'],
                buyer: ['business_type', 'city', 'required_crop', 'required_quantity']
            };

            function updateRegistrationFields() {
                var activeType = typeSelect.value;
                fieldGroups.forEach(function (group) {
                    var isActive = group.dataset.registrationFields === activeType;
                    group.hidden = !isActive;
                    group.querySelectorAll('input, select, textarea').forEach(function (field) {
                        field.disabled = !isActive;
                        field.required = isActive && conditionalFields[activeType].indexOf(field.name) !== -1;
                    });
                });
            }

            typeSelect.addEventListener('change', updateRegistrationFields);
            updateRegistrationFields();
        })();
    </script>
@endpush
