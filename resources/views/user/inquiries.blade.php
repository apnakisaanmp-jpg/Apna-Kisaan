@extends('layouts.frontend')

@section('content')
    <section class="section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div>
                    <div class="eyebrow">किसान account</div>
                    <h1 class="fw-bold mb-1">मेरी inquiries</h1>
                </div>
                <a class="ak-btn" href="{{ route('inquiries.create') }}"><i class="fa-solid fa-plus"></i> नई inquiry</a>
            </div>
            <div class="ak-card p-4">
                @forelse($inquiries as $inquiry)
                    <article class="border-bottom py-3">
                        <div class="d-flex justify-content-between gap-3 flex-wrap">
                            <h5 class="fw-bold mb-1">{{ $inquiry->subject }}</h5><span
                                class="status-pill">{{ $inquiry->status_label }}</span>
                        </div>
                        <p class="mb-2 text-secondary">{{ $inquiry->message }}</p>
                        @if ($inquiry->admin_reply)
                            <div class="ak-notice ak-notice-green"><strong>Admin reply:</strong> {{ $inquiry->admin_reply }}
                            </div>
                        @endif
                        <small class="text-secondary">{{ $inquiry->created_at->format('d M Y, h:i A') }}</small>
                    </article>
                @empty
                    <p class="text-secondary mb-0">अभी कोई inquiry नहीं है।</p>
                @endforelse
                <div class="mt-3">{{ $inquiries->links() }}</div>
            </div>
        </div>
    </section>
@endsection
