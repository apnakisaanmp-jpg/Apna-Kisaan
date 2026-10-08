<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\CropCategory;
use App\Models\District;
use App\Models\Faq;
use App\Models\FarmerRegistration;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\Slider;
use App\Models\TransportBooking;
use App\Models\User;
use App\Services\FarmerPriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180', 'unique:users,email'],
            'mobile' => ['nullable', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'password' => ['required', 'confirmed', 'min:8'],
            'device_name' => ['nullable', 'string', 'max:80'],
        ], $this->authValidationMessages());

        $deviceName = $data['device_name'] ?? 'mobile-app';
        unset($data['device_name']);
        $user = User::create($data + ['role' => 'user', 'is_active' => true]);

        return $this->respond([
            'user' => $this->publicUser($user),
            'token' => $this->issueToken($user, $deviceName),
            'token_type' => 'Bearer',
        ], 'पंजीकरण सफल रहा।', 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:80'],
        ], $this->authValidationMessages());
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'ईमेल या पासवर्ड सही नहीं है।'], 401);
        }

        if (! $user->is_active) {
            return response()->json(['success' => false, 'message' => 'यह खाता अभी सक्रिय नहीं है।'], 403);
        }

        return $this->respond([
            'user' => $this->publicUser($user),
            'token' => $this->issueToken($user, $data['device_name'] ?? 'mobile-app'),
            'token_type' => 'Bearer',
        ], 'लॉगिन सफल रहा।');
    }

    public function logout(Request $request)
    {
        DB::table('api_tokens')->where('token_hash', hash('sha256', $request->bearerToken()))->delete();

        return $this->respond(null, 'लॉगआउट सफल रहा।');
    }

    public function profile(Request $request)
    {
        return $this->respond($this->publicUser($request->user()), 'प्रोफाइल प्राप्त हुई।');
    }

    public function services()
    {
        return $this->respond(Service::active()->get(), 'सेवाएं प्राप्त हुईं।');
    }

    public function service(Service $service)
    {
        abort_unless($service->is_active, 404);

        return $this->respond($service, 'सेवा प्राप्त हुई।');
    }

    public function districts()
    {
        return $this->respond(District::active()->ordered()->get(), 'जिलों की सूची प्राप्त हुई।');
    }

    public function district(District $district)
    {
        abort_unless($district->is_active, 404);

        return $this->respond($district, 'जिले की जानकारी प्राप्त हुई।');
    }

    public function cropCategories()
    {
        return $this->respond(CropCategory::active()->get(), 'फसल श्रेणियां प्राप्त हुईं।');
    }

    public function faqs(Request $request)
    {
        $data = $request->validate(['page' => ['sometimes', 'string', 'max:80']]);
        $faqs = Faq::active()
            ->when(isset($data['page']), fn ($query) => $query->forPage($data['page']))
            ->get(['id', 'question', 'answer', 'page', 'sort_order']);

        return $this->respond($faqs, 'अक्सर पूछे जाने वाले प्रश्न प्राप्त हुए।');
    }

    public function sliders()
    {
        return $this->respond(
            Slider::active()->get(['id', 'title', 'image', 'link_url', 'alt_text', 'sort_order']),
            'होमपेज स्लाइडर प्राप्त हुआ।'
        );
    }

    public function prices(Request $request, FarmerPriceService $priceService, string $type = 'market')
    {
        $filters = $request->validate([
            'q' => ['sometimes', 'string', 'max:100'],
            'category' => ['sometimes', 'string', 'max:80'],
            'min_price' => ['sometimes', 'numeric', 'min:0'],
            'max_price' => ['sometimes', 'numeric', 'min:0', 'gte:min_price'],
            'is_mp' => ['sometimes', 'boolean'],
            'trend' => ['sometimes', 'in:up,down,same'],
            'sort' => ['sometimes', 'in:commodity,modal_price,arrival_date'],
            'order' => ['sometimes', 'in:asc,desc'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ], [
            'max_price.gte' => 'अधिकतम भाव, न्यूनतम भाव से कम नहीं हो सकता।',
            'is_mp.boolean' => 'is_mp के लिए 0 या 1 चुनें।',
            'trend.in' => 'trend के लिए up, down या same चुनें।',
            'sort.in' => 'sort के लिए commodity, modal_price या arrival_date चुनें।',
            'order.in' => 'order के लिए asc या desc चुनें।',
            'per_page.max' => 'एक पेज पर अधिकतम 100 रिकॉर्ड मांगे जा सकते हैं।',
        ]);
        $priceData = $priceService->prices($type);
        $records = collect($priceData['records'])
            ->filter(fn (array $record) => $this->matchesPriceFilters($record, $filters))
            ->values();

        if (isset($filters['sort'])) {
            $sortField = $filters['sort'];
            $records = $records->sortBy(
                fn (array $record) => $sortField === 'modal_price'
                    ? (float) ($record[$sortField] ?? 0)
                    : Str::lower((string) ($record[$sortField] ?? '')),
                SORT_REGULAR,
                ($filters['order'] ?? 'asc') === 'desc'
            )->values();
        }

        $total = $records->count();
        $page = (int) ($filters['page'] ?? 1);
        $perPage = (int) ($filters['per_page'] ?? 20);
        $pageRecords = $records->slice(($page - 1) * $perPage, $perPage)->values();

        return response()->json([
            'success' => true,
            'message' => 'मंडी भाव प्राप्त हुए।',
            'records' => $pageRecords,
            'total' => $total,
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'last_page' => max(1, (int) ceil($total / $perPage)),
                'is_fallback' => (bool) ($priceData['is_fallback'] ?? false),
                'filters' => $filters,
            ],
            'source' => $priceData['source'] ?? null,
            'attribution' => $priceData['attribution'] ?? null,
            'updated' => $priceData['updated'] ?? null,
        ]);
    }

    private function matchesPriceFilters(array $record, array $filters): bool
    {
        if (isset($filters['q'])) {
            $searchable = Str::lower(implode(' ', [
                $record['commodity'] ?? '',
                $record['commodity_en'] ?? '',
                $record['market'] ?? '',
                $record['district'] ?? '',
                $record['category'] ?? '',
            ]));

            if (! str_contains($searchable, Str::lower($filters['q']))) {
                return false;
            }
        }

        if (isset($filters['category']) && ! str_contains(
            Str::lower((string) ($record['category'] ?? '')),
            Str::lower($filters['category'])
        )) {
            return false;
        }

        $modalPrice = isset($record['modal_price']) ? (float) $record['modal_price'] : null;
        if (isset($filters['min_price']) && ($modalPrice === null || $modalPrice < (float) $filters['min_price'])) {
            return false;
        }
        if (isset($filters['max_price']) && ($modalPrice === null || $modalPrice > (float) $filters['max_price'])) {
            return false;
        }
        if (isset($filters['is_mp']) && (bool) ($record['is_mp'] ?? false) !== (bool) $filters['is_mp']) {
            return false;
        }
        if (isset($filters['trend']) && ($record['trend'] ?? 'same') !== $filters['trend']) {
            return false;
        }

        return true;
    }

    public function inquiry(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'district' => ['nullable', 'string', 'max:120'],
            'subject' => ['nullable', 'string', 'max:150'],
            'vegetable' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'कृपया अपना नाम लिखें।',
            'phone.required' => 'कृपया मोबाइल नंबर लिखें।',
            'phone.regex' => 'कृपया सही मोबाइल नंबर दर्ज करें।',
            'message.required' => 'कृपया अपना संदेश लिखें।',
        ]);
        $lead = Contact::create($data + ['source_page' => 'api', 'ip_address' => $request->ip()]);

        return $this->respond($lead, 'आपकी पूछताछ दर्ज हो गई है।', 201);
    }

    public function farmer(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:farmer,buyer'],
            'name' => ['required', 'string', 'max:120'],
            'mobile' => ['required', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'district' => ['required_if:type,farmer', 'nullable', 'string', 'max:120'],
            'village' => ['nullable', 'string', 'max:120'],
            'main_crop' => ['required_if:type,farmer', 'nullable', 'string', 'max:120'],
            'farm_area' => ['nullable', 'numeric', 'min:0'],
            'business_type' => ['required_if:type,buyer', 'nullable', 'string', 'max:120'],
            'city' => ['required_if:type,buyer', 'nullable', 'string', 'max:120'],
            'required_crop' => ['required_if:type,buyer', 'nullable', 'string', 'max:120'],
            'required_quantity' => ['required_if:type,buyer', 'nullable', 'numeric', 'min:0.01'],
        ], [
            'type.required' => 'कृपया किसान या खरीदार चुनें।',
            'name.required' => 'कृपया अपना नाम लिखें।',
            'mobile.required' => 'कृपया मोबाइल नंबर लिखें।',
            'district.required_if' => 'किसान पंजीकरण के लिए जिला जरूरी है।',
            'main_crop.required_if' => 'किसान पंजीकरण के लिए मुख्य फसल जरूरी है।',
            'business_type.required_if' => 'खरीदार पंजीकरण के लिए व्यवसाय का प्रकार जरूरी है।',
            'city.required_if' => 'खरीदार पंजीकरण के लिए शहर जरूरी है।',
            'required_crop.required_if' => 'खरीदार पंजीकरण के लिए आवश्यक फसल जरूरी है।',
            'required_quantity.required_if' => 'खरीदार पंजीकरण के लिए मात्रा जरूरी है।',
            'required_quantity.min' => 'मात्रा शून्य से अधिक होनी चाहिए।',
        ]);

        $data['ip_address'] = $request->ip();

        return $this->respond(FarmerRegistration::create($data), 'आपका पंजीकरण दर्ज हो गया है।', 201);
    }

    public function transport(Request $request)
    {
        $data = $request->validate([
            'pickup_location' => ['required', 'string', 'max:160'],
            'delivery_location' => ['required', 'string', 'max:160'],
            'vehicle_type' => ['required', 'in:truck,pickup,cold'],
            'crop_name' => ['required', 'string', 'max:120'],
            'quantity' => ['required', 'numeric', 'min:0.01'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'mobile' => ['required', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'pickup_location.required' => 'कृपया फसल उठाने का स्थान लिखें।',
            'delivery_location.required' => 'कृपया फसल पहुंचाने का स्थान लिखें।',
            'vehicle_type.in' => 'दिए गए विकल्पों में से वाहन चुनें।',
            'quantity.min' => 'मात्रा कम से कम 0.01 क्विंटल होनी चाहिए।',
            'preferred_date.after_or_equal' => 'तारीख आज या उसके बाद की चुनें।',
            'mobile.regex' => 'कृपया सही मोबाइल नंबर दर्ज करें।',
            'notes.max' => 'नोट 1000 अक्षरों से अधिक नहीं होना चाहिए।',
        ]);
        $booking = TransportBooking::create($data + ['ip_address' => $request->ip()]);

        return $this->respond($booking, 'परिवहन अनुरोध दर्ज हो गया है।', 201);
    }

    public function myInquiries(Request $request)
    {
        $inquiries = Inquiry::where('user_id', $request->user()->id)
            ->latest()
            ->get(['id', 'subject', 'message', 'status', 'admin_reply', 'created_at']);

        return $this->respond($inquiries, 'आपकी पूछताछ प्राप्त हुई।');
    }

    public function createMyInquiry(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
            'phone' => ['nullable', 'regex:/^[0-9+\-\s]{10,15}$/'],
        ], [
            'subject.required' => 'कृपया पूछताछ का विषय लिखें।',
            'subject.max' => 'विषय 150 अक्षरों से छोटा होना चाहिए।',
            'message.required' => 'कृपया अपना संदेश लिखें।',
            'message.max' => 'संदेश 2000 अक्षरों से छोटा होना चाहिए।',
            'phone.regex' => 'कृपया सही मोबाइल नंबर दर्ज करें।',
        ]);
        $user = $request->user();
        $inquiry = Inquiry::create($data + [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        return $this->respond($inquiry, 'आपकी पूछताछ दर्ज हो गई है।', 201);
    }

    private function issueToken(User $user, string $deviceName): string
    {
        $plain = Str::random(64);
        DB::table('api_tokens')->insert([
            'user_id' => $user->id,
            'name' => $deviceName,
            'token_hash' => hash('sha256', $plain),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $plain;
    }

    private function publicUser(User $user): array
    {
        return $user->only(['id', 'name', 'email', 'mobile', 'role', 'is_active', 'created_at']);
    }

    private function authValidationMessages(): array
    {
        return [
            'name.required' => 'कृपया अपना नाम भरें।',
            'name.max' => 'नाम 120 अक्षरों से अधिक नहीं होना चाहिए।',
            'email.required' => 'कृपया ईमेल पता भरें।',
            'email.email' => 'कृपया सही ईमेल पता दर्ज करें।',
            'email.max' => 'ईमेल पता 180 अक्षरों से अधिक नहीं होना चाहिए।',
            'email.unique' => 'इस ईमेल से पहले ही खाता बना हुआ है।',
            'mobile.regex' => 'कृपया सही मोबाइल नंबर दर्ज करें।',
            'password.required' => 'कृपया पासवर्ड भरें।',
            'password.confirmed' => 'दोनों पासवर्ड एक जैसे नहीं हैं।',
            'password.min' => 'पासवर्ड कम से कम 8 अक्षरों का होना चाहिए।',
        ];
    }

    private function respond(mixed $data, string $message, int $status = 200)
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $status);
    }
}
