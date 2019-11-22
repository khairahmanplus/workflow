@if (session()->has('app::message'))
    <div class="alert {{ session('app::class', 'alert-success') }} alert-dismissable fade show mt-3 mb-0">
        {{ session('app::message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
