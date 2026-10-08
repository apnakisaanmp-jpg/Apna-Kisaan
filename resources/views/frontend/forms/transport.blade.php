<form method="post" action="{{ route('leads.transport') }}" class="ak-form">
    @csrf

    <div class="ak-form-intro">
        <h2>परिवहन अनुरोध</h2>
        <p>फसल और यात्रा की जानकारी दें। टीम उपलब्धता और अनुमानित किराये की पुष्टि के लिए संपर्क करेगी।</p>
    </div>

    <h3 class="ak-form-section"><i class="fa-solid fa-route"></i> उठाने और पहुंचाने का स्थान</h3>
    <datalist id="transport-districts">
        @foreach ($districts as $district)
            <option value="{{ $district->name }}"></option>
        @endforeach
    </datalist>

    <div class="row g-3">
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="transport-pickup">फसल कहां से उठानी है? <span class="ak-required">*</span></label>
                <input class="form-control @error('pickup_location') is-invalid @enderror" id="transport-pickup"
                    name="pickup_location" value="{{ old('pickup_location') }}" list="transport-districts"
                    autocomplete="street-address" maxlength="160" required>
                <span class="ak-field-hint">गांव, जिला या मंडी का नाम लिखें।</span>
                @error('pickup_location')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="transport-delivery">फसल कहां पहुंचानी है? <span class="ak-required">*</span></label>
                <input class="form-control @error('delivery_location') is-invalid @enderror" id="transport-delivery"
                    name="delivery_location" value="{{ old('delivery_location') }}" list="transport-districts"
                    maxlength="160" required>
                @error('delivery_location')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <h3 class="ak-form-section"><i class="fa-solid fa-truck-fast"></i> फसल और वाहन</h3>
    <div class="row g-3">
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="transport-vehicle">वाहन का प्रकार <span class="ak-required">*</span></label>
                <select class="form-select @error('vehicle_type') is-invalid @enderror" id="transport-vehicle"
                    name="vehicle_type" required>
                    <option value="truck" @selected(old('vehicle_type', 'truck') === 'truck')>ट्रक</option>
                    <option value="pickup" @selected(old('vehicle_type') === 'pickup')>छोटा वाहन (पिकअप)</option>
                    <option value="cold" @selected(old('vehicle_type') === 'cold')>कोल्ड ट्रांसपोर्ट</option>
                </select>
                @error('vehicle_type')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="transport-crop">फसल का नाम <span class="ak-required">*</span></label>
                <input class="form-control @error('crop_name') is-invalid @enderror" id="transport-crop" name="crop_name"
                    value="{{ old('crop_name') }}" maxlength="120" required>
                @error('crop_name')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="transport-quantity">कुल मात्रा (क्विंटल) <span class="ak-required">*</span></label>
                <input class="form-control @error('quantity') is-invalid @enderror" id="transport-quantity" name="quantity"
                    type="number" min="0.01" step="0.01" inputmode="decimal" value="{{ old('quantity') }}" required>
                @error('quantity')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="transport-date">परिवहन की तारीख <span class="ak-required">*</span></label>
                <input class="form-control @error('preferred_date') is-invalid @enderror" id="transport-date"
                    name="preferred_date" type="date" min="{{ now()->toDateString() }}"
                    value="{{ old('preferred_date') }}" required>
                @error('preferred_date')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <h3 class="ak-form-section"><i class="fa-solid fa-phone"></i> संपर्क विवरण</h3>
    <div class="row g-3">
        <div class="col-12 col-md-6">
            <div class="ak-form-field">
                <label for="transport-mobile">मोबाइल नंबर <span class="ak-required">*</span></label>
                <input class="form-control @error('mobile') is-invalid @enderror" id="transport-mobile" name="mobile"
                    type="tel" inputmode="tel" autocomplete="tel" pattern="[0-9+\-\s]{10,15}" maxlength="15"
                    value="{{ old('mobile') }}" placeholder="उदाहरण: 9876543210" required>
                @error('mobile')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-12">
            <div class="ak-form-field">
                <label for="transport-notes">अन्य जानकारी <span class="text-secondary fw-normal">(वैकल्पिक)</span></label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="transport-notes" name="notes"
                    rows="4" maxlength="1000" placeholder="लोडिंग, समय या फसल की पैकिंग से जुड़ी जानकारी">{{ old('notes') }}</textarea>
                @error('notes')<span class="ak-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <p class="ak-field-hint mt-3"><span class="ak-required">*</span> जरूरी जानकारी</p>
    <div class="ak-form-actions">
        <button class="ak-btn" type="submit"><i class="fa-solid fa-truck-fast"></i> परिवहन अनुरोध भेजें</button>
        <span class="ak-field-hint">अनुरोध भेजने पर बुकिंग नंबर स्क्रीन पर दिखेगा।</span>
    </div>
</form>
