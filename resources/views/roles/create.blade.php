@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row">
                    <div class="col"><h4>{{ __('New Role') }}</h4></div>
                </div>
            </section>

            <section class="my-4">
                <form action="{{ route('roles.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="">{{ __('Name') }}</label>
                        <input class="form-control @if ($errors->has('name')) is-invalid @endif" type="text" name="name" value="{{ old('name') }}" autofocus>
                        @if ($errors->has('name'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="has-all-permissions-checkbox">{{ __('Has All Permissions') }}</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input  @if ($errors->has('has_all_permissions')) is-invalid @endif" id="has-all-permissions-checkbox" name="has_all_permissions" {{ old('has_all_permissions') ? 'checked' : null }}>
                            <label class="custom-control-label" for="has-all-permissions-checkbox">{{ __('Yes') }}</label>
                            <div class="small help-text">
                                {{ __('For super administrator role only.') }}
                            </div>
                            @if ($errors->has('has_all_permissions'))
                                <div class="small invalid-feedback">
                                    {{ $errors->first('has_all_permissions') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" id="permissions-form-group">
                        <label for="">{{ __('Permissions') }}</label>
                        <div class="custom-control custom-checkbox">
                            @forelse ($permissions as $permission)
                                <div>
                                    <input type="checkbox" class="custom-control-input  @if ($errors->has('permissions')) is-invalid @endif" id="{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"  {{ in_array($permission->id, old('permissions', [])) ? 'checked' : null }}>
                                    <label class="custom-control-label" for="{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            @empty
                                <div>
                                    {{ __('There is no data.') }}
                                </div>
                            @endforelse
                        </div>
                        @if ($errors->has('permissions'))
                            <div class="small text-danger">
                                {{ $errors->first('permissions') }}
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

@push('js')
    <script>
        $(function () {
            let $hasAllPermissionsCheckbox = $("input[name=has_all_permissions]");
            let $permissionsFromGroup = $("#permissions-form-group");

            function hasAllPermissions()
            {
                let hasAllPermissions = $hasAllPermissionsCheckbox.prop('checked');
                if (hasAllPermissions) {
                    $permissionsFromGroup.addClass('d-none');
                }else {
                    $permissionsFromGroup.removeClass('d-none');
                }
            }

            hasAllPermissions();

            $hasAllPermissionsCheckbox.on('change', function () {
                hasAllPermissions();
            });
        });
    </script>
@endpush
