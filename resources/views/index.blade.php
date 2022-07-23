<x-layouts.main title="{{ __('index_title') }}">
    <div class="row">
        <x-title-separator title="{{ __('login') }}"></x-title-separator>
        <form method="post" action="{{ route('HomeLogin') }}">
            @csrf
            <fieldset>
                <x-input keyValue="email" type="email" value="{{ old('email') }}"></x-input>
                <x-input keyValue="password" type="password" ></x-input>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" checked>
                        <label class="form-check-label" for="remember">
                            {{ __('keep_logged_in') }}
                        </label>
                    </div>
                </div>
                <x-button class="btn-primary" text="{{ __('login') }}"></x-button>
            </fieldset>
        </form>
    </div>
    <x-message></x-message>
</x-layouts.main>
