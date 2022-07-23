<x-layouts.main title="{{ __('media_list') }}">
    <x-title-separator title="{{ __('new_media') }}"></x-title-separator>
    <form method="post" enctype="multipart/form-data" action="{{ route('MediaStore') }}">
        @csrf
        <div class="row">
            <div class="col">
                <x-input keyValue="media_title" type="input" value="{{ old('media_title') }}"></x-input>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="media_type" class="form-label">{{ __('media_type') }}</label>
                    <select class="form-select" id="media_type" name="media_type">
                        @foreach(\App\Models\Media::$media_type as $key => $media_type)
                            <option value="{{ $key }}">{{ $media_type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="category_id" class="form-label">{{ __('category_title') }}</label>
                    <select class="form-select" id="category_id" name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_title }}</option>
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
                <x-button class="btn-primary w-100 mt-2" text="{{ __('add') }}"></x-button>
            </div>
        </div>
    </form>
    <x-errors></x-errors>

    <x-message></x-message>
    <hr />
    <x-title-separator title="{{ __('media_list') }}"></x-title-separator>
    <div class="row">
        <div class="col-12">
            <table id="media_list" class="table table-striped w-100">
                <thead>
                <tr>
                    <th>{{ __('media_type') }}</th>
                    <th>{{ __('media_title') }}</th>
                    <th>{{ __('media_file') }}</th>
                    <th>{{ __('category_title') }}</th>
                    <th>{{ __('edit') }}</th>
                    <th>{{ __('delete') }}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($media_list as $media)
                    <tr>
                        <td>{{ $media->type }}</td>
                        <td>{{ $media->title }}</td>
                        <td>{{ \App\libs\Universal::mediaLink($media->type, $media->order, $media->file_name) }}</td>
                        <td>{{ $media->category_title }}</td>
                        <td><a class="btn btn-outline-success" href="{{ route('MediaShow', ['media' => $media->id]) }}">{{ __('edit') }}</a></td>
                        <td>
                            <form method="post" action="{{ route('MediaDestroy', ['media' => $media->id]) }}">
                                @csrf
                                @method('delete')
                                <x-button onclick="confirm('{{ __('RU_sure') }}');" class="btn-outline-danger" text="{{ __('delete') }}"></x-button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>{{ __('media_type') }}</th>
                    <th>{{ __('media_title') }}</th>
                    <th>{{ __('media_file') }}</th>
                    <th>{{ __('category_title') }}</th>
                    <th>{{ __('edit') }}</th>
                    <th>{{ __('delete') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-layouts.main>
