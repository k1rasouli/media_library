@if(session()->get('message'))
    <div class="row mt-4">
        <div class="row-12">
            <div class="alert alert-danger" role="alert">
                {{ session()->get('message') }}
            </div>
        </div>
    </div>
    @php session()->remove('message') @endphp
@endif
