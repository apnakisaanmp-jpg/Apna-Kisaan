<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\FarmerRegistration;
use App\Models\TransportBooking;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'district' => ['nullable', 'string', 'max:120'],
            'subject' => ['nullable', 'string', 'max:150'],
            'vegetable' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:2000'],
            'source_page' => ['nullable', 'string', 'max:80'],
        ], [
            'name.required' => 'कृपया अपना नाम लिखें।',
            'name.max' => 'नाम 120 अक्षरों से छोटा होना चाहिए।',
            'phone.required' => 'कृपया मोबाइल नंबर लिखें।',
            'phone.regex' => 'सही 10 अंकों का मोबाइल नंबर लिखें।',
            'district.max' => 'जिले का नाम 120 अक्षरों से छोटा होना चाहिए।',
            'subject.max' => 'विषय 150 अक्षरों से छोटा होना चाहिए।',
            'vegetable.max' => 'फसल या क्षेत्र का नाम 120 अक्षरों से छोटा होना चाहिए।',
            'message.required' => 'कृपया अपनी जरूरत का विवरण लिखें।',
            'message.max' => 'संदेश 2000 अक्षरों से छोटा होना चाहिए।',
        ]);

        $data['ip_address'] = $request->ip();
        Contact::create($data);

        return back()->with('success', 'धन्यवाद! आपकी जानकारी सुरक्षित रूप से दर्ज हो गई है। हमारी टीम जल्द संपर्क करेगी।');
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
            'type.required' => 'कृपया किसान या खरीदार का विकल्प चुनें।',
            'type.in' => 'पंजीकरण का सही प्रकार चुनें।',
            'name.required' => 'कृपया अपना नाम लिखें।',
            'mobile.required' => 'कृपया मोबाइल नंबर लिखें।',
            'mobile.regex' => 'सही 10 अंकों का मोबाइल नंबर लिखें।',
            'district.required_if' => 'कृपया अपना जिला चुनें।',
            'main_crop.required_if' => 'कृपया अपनी मुख्य फसल लिखें।',
            'farm_area.numeric' => 'खेती का क्षेत्रफल अंकों में लिखें।',
            'farm_area.min' => 'खेती का क्षेत्रफल शून्य से कम नहीं हो सकता।',
            'business_type.required_if' => 'कृपया अपने व्यवसाय का प्रकार चुनें।',
            'city.required_if' => 'कृपया अपने शहर का नाम लिखें।',
            'required_crop.required_if' => 'कृपया वह फसल लिखें जिसकी आपको जरूरत है।',
            'required_quantity.required_if' => 'कृपया फसल की जरूरी मात्रा लिखें।',
            'required_quantity.numeric' => 'मात्रा अंकों में लिखें।',
            'required_quantity.min' => 'मात्रा शून्य से अधिक होनी चाहिए।',
        ]);

        $data['ip_address'] = $request->ip();
        FarmerRegistration::create($data);

        return back()->with('success', 'आपका पंजीकरण हो गया है। Apna Kisaan टीम सत्यापन के बाद संपर्क करेगी।');
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
            'vehicle_type.required' => 'कृपया वाहन का प्रकार चुनें।',
            'vehicle_type.in' => 'दिए गए विकल्पों में से वाहन चुनें।',
            'crop_name.required' => 'कृपया फसल का नाम लिखें।',
            'quantity.required' => 'कृपया फसल की मात्रा लिखें।',
            'quantity.numeric' => 'मात्रा अंकों में लिखें।',
            'quantity.min' => 'मात्रा कम से कम 0.01 क्विंटल होनी चाहिए।',
            'preferred_date.required' => 'कृपया परिवहन की तारीख चुनें।',
            'preferred_date.after_or_equal' => 'परिवहन की तारीख आज या उसके बाद की चुनें।',
            'mobile.required' => 'कृपया मोबाइल नंबर लिखें।',
            'mobile.regex' => 'सही 10 अंकों का मोबाइल नंबर लिखें।',
            'notes.max' => 'अन्य जानकारी 1000 अक्षरों से छोटी होनी चाहिए।',
        ]);

        $data['ip_address'] = $request->ip();
        $booking = TransportBooking::create($data);

        return back()->with('success', 'बुकिंग अनुरोध दर्ज हो गया है। आपका बुकिंग नंबर '.$booking->booking_number.' है।');
    }
}
