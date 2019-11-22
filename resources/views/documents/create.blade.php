@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row">
                    <div class="col"><h4>{{ __('New Document') }}</h4></div>
                </div>
            </section>

            <section class="my-4">
                <form action="{{ route('documents.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="name-input">{{ __('Name') }}</label>
                        <input class="form-control @if ($errors->has('name')) is-invalid @endif" id="name-input" type="text" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </form>
            </section>

        </div>
    </div>
</div>
@endsection
