<x-layouts.main title="{{ __('media_list') }}">
    <x-title-separator title="{{ __('edit') }}: {{ $media->media_title }}"></x-title-separator>
    <form method="post" enctype="multipart/form-data" action="{{ route('MediaUpdate', ['media' => $media]) }}">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col">
                <x-input keyValue="media_title" type="input" value="{{ $media->media_title }}"></x-input>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="media_type" class="form-label">{{ __('media_type') }}</label>
                    <select class="form-select" id="media_type" name="media_type">
                        @foreach(\App\Models\Media::$media_type as $key => $media_type)
                            <option @if($media->media_type == $key) selected @endif value="{{ $key }}">{{ $media_type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="category_id" class="form-label">{{ __('category_title') }}</label>
                    <select class="form-select" id="category_id" name="category_id">
                        @foreach($categories as $category)
                            <option @if($media->category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->category_title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-input keyValue="media_file" type="file"></x-input>
            </div>
            <div class="col mt-4">
                <x-button class="btn-primary w-100 mt-2" text="{{ __('edit') }}"></x-button>
            </div>
        </div>
    </form>
    <x-errors></x-errors>
    <x-message></x-message>
</x-layouts.main>
