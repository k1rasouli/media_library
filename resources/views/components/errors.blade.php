@if(session()->get('errors'))
    <div class="row mt-4">
        <div class="row-12">
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach(session()->get('errors') as $error)
                        <li>{{ $error[0] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
