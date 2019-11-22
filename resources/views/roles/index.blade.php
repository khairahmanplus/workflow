@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Roles') }}</h4></div>
                    <div class="col-auto"><a href="{{ route('roles.create') }}" class="btn btn-primary">{{ __('New Role') }}</a></div>
                </div>
            </section>

            <section class="my-4">
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Has All Permissions') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th colspan="2">{{ __('Updated At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ (($roles->currentPage() - 1) * $roles->perPage()) + $loop->iteration  }}</td>
                                    <td><a href="{{ route('roles.show', $role) }}" class="font-weight-bold">{{ $role->name ?? '-' }}</a></td>
                                    <td>{{ $role->hasAllPermissions() ? 'Yes' : 'No' }}</td>
                                    <td>{{ $role->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td>{{ $role->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                                {{ __('Action') }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('roles.show', $role) }}">{{ __('View') }}</a>
                                                <a class="dropdown-item" href="{{ route('roles.edit', $role) }}">{{ __('Edit') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="{{ route('roles.destroy', $role) }}" data-toggle="modal" data-target="#resources-delete-modal">{{ __('Delete') }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">{{ __('There is no data.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{ $roles->appends(request()->query())->links() }}

        </div>
    </div>
</div>
@endsection

@section ('modal')
    @include('components.modals.resources_delete')
@endsection

@push('js')
    <script>
        $(function () {
            $('#resources-delete-modal').on('show.bs.modal', function (event) {
                var button, action, modal = null;
                button = $(event.relatedTarget) || null;
                action = button.prop('href') || null;
                modal = $(this);

                action = (action != null && action != '') ? action : '{{ old('action') }}';

                modal.find('#resources-delete-form').prop('action', action);
            });

            $('#resources-delete-modal').on('shown.bs.modal', function () {
                $('#password-input').trigger('focus');
            });

            @if ($errors->any())
                $('#resources-delete-modal').modal('show');
            @endif
        });
    </script>
@endpush
