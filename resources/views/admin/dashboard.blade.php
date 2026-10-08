@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <div class="text-success fw-bold small">CONTROL CENTRE</div>
            <h1 class="fw-bold mb-1">Good morning, {{ auth()->user()->name }}</h1>
            <p class="text-secondary mb-0">आज की farmer activity और follow-ups एक जगह.</p>
        </div><a class="btn btn-success" href="{{ route('admin.resources.index', 'contacts') }}"><i
                class="fa-solid fa-list-check me-1"></i> View inquiries</a>
    </div>
    <div class="row g-3 mb-4">
        @foreach ($stats as $label => $value)
            <div class="col-sm-6 col-lg-4 col-xl-2">
                <div class="card p-3 h-100"><small class="text-secondary">{{ Str::headline($label) }}</small><strong
                        class="fs-2">{{ $value }}</strong><span class="text-success small"><i
                            class="fa-solid fa-arrow-trend-up"></i> Live data</span></div>
            </div>
        @endforeach
    </div>
    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold mb-0">Recent inquiries</h5><a href="{{ route('admin.resources.index', 'contacts') }}"
                        class="text-success text-decoration-none">View all</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Farmer</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>When</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentContacts as $lead)
                                <tr>
                                    <td>{{ $lead->name }}<br><small class="text-secondary">{{ $lead->phone }}</small>
                                    </td>
                                    <td>{{ Str::limit($lead->subject ?: 'Support request', 28) }}</td>
                                    <td><span class="badge text-bg-success">{{ $lead->status }}</span></td>
                                    <td class="text-secondary">{{ $lead->created_at->diffForHumans() }}</td>
                            </tr>@empty<tr>
                                    <td colspan="4" class="text-center text-secondary py-4">No inquiries yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold mb-0">Recent bookings</h5><a
                        href="{{ route('admin.resources.index', 'transport') }}"
                        class="text-success text-decoration-none">View all</a>
                </div>
                @forelse($recentBookings as $booking)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <div><strong>{{ $booking->booking_number }}</strong><br><small
                                class="text-secondary">{{ $booking->crop_name ?: 'Crop not specified' }}</small></div>
                        <div class="text-end"><span class="badge text-bg-light">{{ $booking->status }}</span><br><small
                                class="text-secondary">{{ $booking->created_at->diffForHumans() }}</small></div>
                </div>@empty<p class="text-secondary py-3 mb-0">No bookings yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
