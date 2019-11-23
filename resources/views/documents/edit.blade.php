@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row">
                    <div class="col"><h4>{{ __('Edit Document Details') }}</h4></div>
                </div>
            </section>

            <section class="my-4">
                <form action="{{ route('documents.update', $document) }}" method="post">
                    @csrf @method('put')

                    <div class="form-group">
                        <label for="name-input">{{ __('Name') }}</label>
                        <input class="form-control @if ($errors->has('name')) is-invalid @endif" id="name-input" type="text" name="name" value="{{ old('name', $document->name) }}">
                        @if ($errors->has('name'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                </form>
            </section>

        </div>
    </div>
</div>
@endsection
