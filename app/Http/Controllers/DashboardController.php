<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\FarmerRegistration;
use App\Models\TransportBooking;

class DashboardController extends Controller
{
    public function user()
    {
        return view('user.dashboard', [
            'contacts' => Contact::where('phone', auth()->user()->mobile)->latest()->limit(5)->get(),
            'inquiries' => auth()->user()->inquiries()->latest()->limit(5)->get(),
            'registrations' => FarmerRegistration::where('mobile', auth()->user()->mobile)->latest()->limit(5)->get(),
            'bookings' => TransportBooking::where('mobile', auth()->user()->mobile)->latest()->limit(5)->get(),
        ]);
    }
}
