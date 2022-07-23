<x-layouts.main title="{{ __('category_list') }}">
    <x-title-separator title="{{ __('new_category') }}"></x-title-separator>
    <form method="post" enctype="multipart/form-data" action="{{ route('CategoriesStore') }}">
        @csrf
        <div class="row">
            <div class="col">
                <x-input keyValue="category_title" type="input" value="{{ old('category_title') }}"></x-input>
            </div>
            <div class="col mt-4">
                <x-button class="btn-primary w-100 mt-2" text="{{ __('add') }}"></x-button>
            </div>
        </div>
    </form>
    <x-errors></x-errors>
    <hr />
    <x-title-separator title="{{ __('category_list') }}"></x-title-separator>
    <div class="row">
        <div class="col-12">
            <table id="media_list" class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>{{ __('category_title') }}</th>
                        <th>{{ __('slug') }}</th>
                        <th>{{ __('edit') }}</th>
                        <th>{{ __('delete') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->category_title }}</td>
                            <td>{{ $category->slug }}</td>
                            <td><a class="btn btn-outline-success" href="{{ route('CategoriesShow', ['category' => $category->slug]) }}">{{ __('edit') }}</a></td>
                            <td>
                                <form method="post" action="{{ route('CategoriesDestroy', ['category' => $category->id]) }}">
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
                        <th>{{ __('category_title') }}</th>
                        <th>{{ __('edit') }}</th>
                        <th>{{ __('delete') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-layouts.main>
