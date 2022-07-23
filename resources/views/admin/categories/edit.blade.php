<x-layouts.main title="{{ __('category_list') }}">
    <x-title-separator title="{{ __('edit') }} : {{ $category->category_title }}"></x-title-separator>
    <form method="post" enctype="multipart/form-data" action="{{ route('CategoriesUpdate', ['category' => $category]) }}">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col">
                <x-input keyValue="category_title" type="input" value="{{ $category->category_title }}"></x-input>
            </div>
            <div class="col mt-4">
                <x-button class="btn-primary w-100 mt-2" text="{{ __('edit') }}"></x-button>
            </div>
        </div>
    </form>
   <x-errors></x-errors>
</x-layouts.main>
