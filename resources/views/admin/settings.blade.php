@extends('layouts.admin')
@section('content')
<h1 class="fw-bold mb-3">Settings</h1>
<form class="card p-4" method="post">@csrf
@foreach($settings as $group => $items)<h5 class="mt-3">{{ Str::headline($group) }}</h5><div class="row g-3">@foreach($items as $setting)<div class="col-md-6"><label class="form-label">{{ $setting->label }}</label>@if($setting->type === 'textarea')<textarea class="form-control" name="{{ $setting->key }}" rows="3">{{ $setting->value }}</textarea>@else<input class="form-control" name="{{ $setting->key }}" value="{{ $setting->value }}">@endif</div>@endforeach</div>@endforeach
<button class="btn btn-success mt-4">Save Settings</button>
</form>
@endsection
