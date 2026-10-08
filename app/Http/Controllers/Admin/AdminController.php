<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\CropCategory;
use App\Models\District;
use App\Models\Faq;
use App\Models\FarmerRegistration;
use App\Models\PriceTicker;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\TransportBooking;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private array $resources = [
        'users' => ['model' => User::class, 'title' => 'Users', 'search' => ['name', 'email', 'mobile'], 'fields' => ['name', 'email', 'mobile', 'role', 'is_active']],
        'services' => ['model' => Service::class, 'title' => 'Services', 'search' => ['title', 'short_description'], 'fields' => ['title', 'slug', 'short_description', 'description', 'icon', 'link_url', 'link_text', 'sort_order', 'is_active']],
        'districts' => ['model' => District::class, 'title' => 'Districts', 'search' => ['name', 'name_en', 'region'], 'fields' => ['name', 'name_en', 'slug', 'region', 'description', 'market_info', 'is_featured', 'is_active', 'sort_order']],
        'contacts' => ['model' => Contact::class, 'title' => 'Inquiries', 'search' => ['name', 'phone', 'district', 'subject'], 'fields' => ['name', 'phone', 'district', 'subject', 'vegetable', 'message', 'status', 'admin_notes']],
        'inquiries' => ['model' => Inquiry::class, 'title' => 'User Inquiries', 'search' => ['name', 'email', 'phone', 'subject', 'message'], 'fields' => ['name', 'email', 'phone', 'subject', 'message', 'status', 'admin_reply']],
        'registrations' => ['model' => FarmerRegistration::class, 'title' => 'Farmer / Buyer Registrations', 'search' => ['name', 'mobile', 'district', 'city'], 'fields' => ['type', 'name', 'mobile', 'district', 'village', 'main_crop', 'farm_area', 'business_type', 'city', 'required_crop', 'required_quantity', 'status', 'admin_notes']],
        'transport' => ['model' => TransportBooking::class, 'title' => 'Transport Bookings', 'search' => ['booking_number', 'mobile', 'pickup_location', 'delivery_location', 'crop_name'], 'fields' => ['pickup_location', 'delivery_location', 'vehicle_type', 'crop_name', 'quantity', 'preferred_date', 'mobile', 'notes', 'status', 'admin_notes', 'estimated_cost', 'driver_name', 'driver_phone', 'vehicle_number']],
        'sliders' => ['model' => Slider::class, 'title' => 'Sliders', 'search' => ['title', 'alt_text'], 'fields' => ['title', 'image', 'link_url', 'alt_text', 'sort_order', 'is_active']],
        'team' => ['model' => TeamMember::class, 'title' => 'Team Members', 'search' => ['name', 'designation', 'email'], 'fields' => ['name', 'designation', 'bio', 'image', 'phone', 'email', 'sort_order', 'is_active']],
        'faqs' => ['model' => Faq::class, 'title' => 'FAQs', 'search' => ['question', 'answer', 'page'], 'fields' => ['question', 'answer', 'page', 'sort_order', 'is_active']],
        'prices' => ['model' => PriceTicker::class, 'title' => 'Price Tickers', 'search' => ['commodity_name', 'commodity_en'], 'fields' => ['commodity_name', 'commodity_en', 'icon_class', 'price', 'unit', 'trend', 'sort_order', 'is_active']],
        'crops' => ['model' => CropCategory::class, 'title' => 'Crop Categories', 'search' => ['name', 'name_en', 'examples'], 'fields' => ['name', 'name_en', 'slug', 'icon_class', 'link_url', 'examples', 'sort_order', 'is_active']],
    ];

    public function dashboard()
    {
        return view('admin.dashboard', [
            'stats' => [
                'users' => User::count(),
                'contacts' => Contact::count(),
                'newContacts' => Contact::where('status', 'new')->count(),
                'registrations' => FarmerRegistration::count(),
                'bookings' => TransportBooking::count(),
                'services' => Service::count(),
            ],
            'recentContacts' => Contact::latest()->limit(8)->get(),
            'recentBookings' => TransportBooking::latest()->limit(8)->get(),
        ]);
    }

    public function index(Request $request, string $resource)
    {
        $config = $this->resource($resource);
        $query = $config['model']::query();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($config, $search) {
                foreach ($config['search'] as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        if ($request->filled('status') && in_array('status', $config['fields'], true)) {
            $query->where('status', $request->status);
        }

        $items = $query->latest()->paginate(15)->withQueryString();

        return view('admin.resource-index', compact('resource', 'config', 'items'));
    }

    public function create(string $resource)
    {
        $config = $this->resource($resource);
        $item = new $config['model'];

        return view('admin.resource-form', compact('resource', 'config', 'item'));
    }

    public function store(Request $request, string $resource)
    {
        $config = $this->resource($resource);
        $data = $this->validated($request, $config, $resource);

        $config['model']::create($data);

        return redirect()->route('admin.resources.index', $resource)->with('success', 'Record created successfully.');
    }

    public function edit(string $resource, int $id)
    {
        $config = $this->resource($resource);
        $item = $config['model']::findOrFail($id);

        return view('admin.resource-form', compact('resource', 'config', 'item'));
    }

    public function update(Request $request, string $resource, int $id)
    {
        $config = $this->resource($resource);
        $item = $config['model']::findOrFail($id);
        $item->update($this->validated($request, $config, $resource, $item));

        return redirect()->route('admin.resources.index', $resource)->with('success', 'Record updated successfully.');
    }

    public function destroy(string $resource, int $id)
    {
        $config = $this->resource($resource);
        $config['model']::findOrFail($id)->delete();

        return back()->with('success', 'Record deleted successfully.');
    }

    public function settings(Request $request)
    {
        if ($request->isMethod('post')) {
            foreach ($request->except('_token') as $key => $value) {
                Setting::where('key', $key)->update(['value' => $value]);
            }
            Setting::flushCache();

            return back()->with('success', 'Settings updated successfully.');
        }

        return view('admin.settings', ['settings' => Setting::orderBy('group')->orderBy('label')->get()->groupBy('group')]);
    }

    private function resource(string $resource): array
    {
        abort_unless(isset($this->resources[$resource]), 404);
        return $this->resources[$resource];
    }

    private function validated(Request $request, array $config, string $resource, ?Model $item = null): array
    {
        $rules = [];
        foreach ($config['fields'] as $field) {
            $rules[$field] = str_contains($field, 'email') ? ['nullable', 'email', 'max:180'] : ['nullable'];
        }

        foreach (['name', 'title', 'question', 'commodity_name', 'pickup_location', 'delivery_location'] as $required) {
            if (in_array($required, $config['fields'], true)) {
                $rules[$required] = ['required', 'string', 'max:255'];
            }
        }

        if ($resource === 'users') {
            $rules['name'] = ['required', 'string', 'max:120'];
            $rules['email'] = ['required', 'email', 'max:180', 'unique:users,email,' . ($item?->id ?? 'NULL')];
            $rules['password'] = [$item ? 'nullable' : 'required', 'confirmed', 'min:8'];
        }

        $data = $request->validate($rules);

        foreach ($config['fields'] as $field) {
            if (str_starts_with($field, 'is_')) {
                $data[$field] = $request->boolean($field);
            }
        }

        if (isset($data['slug']) && blank($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($resource === 'users') {
            if (! empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            } else {
                unset($data['password']);
            }
        }

        return $data;
    }
}
