@extends('layouts.admin')
@section('content')
<h1 class="fw-bold mb-3">{{ $item->exists ? 'Edit' : 'Add' }} {{ $config['title'] }}</h1>
<form class="card p-4" method="post" action="{{ $item->exists ? route('admin.resources.update', [$resource,$item->id]) : route('admin.resources.store', $resource) }}">@csrf @if($item->exists) @method('put') @endif
    <div class="row g-3">
        @foreach($config['fields'] as $field)
            <div class="{{ in_array($field, ['description','message','admin_notes','bio','market_info','answer'], true) ? 'col-12' : 'col-md-6' }}">
                <label class="form-label">{{ Str::headline($field) }}</label>
                @if(str_starts_with($field, 'is_'))
                    <select class="form-select" name="{{ $field }}"><option value="1" @selected(old($field, $item->$field) == 1)>Yes</option><option value="0" @selected(old($field, $item->$field) == 0)>No</option></select>
                @elseif(in_array($field, ['description','message','admin_notes','bio','market_info','answer','short_description','notes'], true))
                    <textarea class="form-control" name="{{ $field }}" rows="4">{{ old($field, $item->$field) }}</textarea>
                @else
                    <input class="form-control" name="{{ $field }}" value="{{ old($field, $item->$field) }}">
                @endif
            </div>
        @endforeach
        @if($resource === 'users')
            <div class="col-md-6"><label class="form-label">Password</label><input type="password" class="form-control" name="password"></div>
            <div class="col-md-6"><label class="form-label">Confirm Password</label><input type="password" class="form-control" name="password_confirmation"></div>
        @endif
    </div>
    <div class="mt-4 d-flex gap-2"><button class="btn btn-success">Save</button><a class="btn btn-outline-secondary" href="{{ route('admin.resources.index', $resource) }}">Back</a></div>
</form>
@endsection
