<div class="mb-3">
    <label for="{{ $keyValue }}" class="form-label">{{ __($keyValue) }}</label>
    <input @if(!($type == "password" || $type == "file")) value="{{ $value }}" @endif type="{{ $type }}" id="{{ $keyValue }}" name="{{ $keyValue }}" class="form-control" placeholder="{{ __($keyValue) }}">
</div>
