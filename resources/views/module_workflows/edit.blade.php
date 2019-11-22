@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row">
                    <div class="col"><h4>{{ __('Edit Module Workflow Details') }}</h4></div>
                </div>
            </section>

            <section class="my-4">
                <form action="{{ route('module-workflows.update', $moduleWorkflow) }}" method="post">
                    @csrf @method('put')

                    <div class="form-group">
                        <label for="">{{ __('Module') }}</label>
                        <select class="form-control @if ($errors->has('module')) is-invalid @endif" name="module">
                            <option selected disabled>{{ __('Please Select') }}</option>
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}" {{ $module->id == old('module', $moduleWorkflow->module_id) ? 'selected' : null }}>{{ $module->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('module'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('module') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Workflow') }}</label>
                        <select class="form-control @if ($errors->has('workflow')) is-invalid @endif" name="workflow">
                            <option selected disabled>{{ __('Please Select') }}</option>
                            @foreach ($workflows as $workflow)
                                <option value="{{ $workflow->id }}" {{ $workflow->id == old('workflow', $moduleWorkflow->workflow_id) ? 'selected' : null }}>{{ $workflow->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('workflow'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('workflow') }}
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
