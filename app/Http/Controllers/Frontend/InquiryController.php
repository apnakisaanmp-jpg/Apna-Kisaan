<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        return view('user.inquiries', [
            'inquiries' => auth()->user()->inquiries()->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('frontend.inquiry');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:4000'],
        ]);

        $user = $request->user();
        $user->inquiries()->create($data + [
            'name' => $user->name,
            'email' => $user->email,
            'status' => 'pending',
        ]);

        return redirect()->route('inquiries.index')->with('success', 'आपकी inquiry दर्ज हो गई है।');
    }
}
