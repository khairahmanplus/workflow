@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Workflows') }}</h4></div>
                    <div class="col-auto"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#workflows-create-modal">{{ __('New Workflow') }}</a></div>
                </div>
            </section>

            <section class="my-4">
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th colspan="2">{{ __('Updated At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($workflows as $workflow)
                                <tr>
                                    <td>{{ (($workflows->currentPage() - 1) * $workflows->perPage()) + $loop->iteration  }}</td>
                                    <td><a href="{{ route('workflows.show', $workflow) }}" class="font-weight-bold">{{ $workflow->name ?? '-' }}</a></td>
                                    <td>{{ $workflow->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td>{{ $workflow->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                                {{ __('Action') }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('workflows.show', $workflow) }}">{{ __('View') }}</a>
                                                <a class="dropdown-item" href="{{ route('workflows.edit', $workflow) }}">{{ __('Edit') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="{{ route('workflows.destroy', $workflow) }}" data-toggle="modal" data-target="#resources-delete-modal">{{ __('Delete') }}</a>
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

            {{ $workflows->appends(request()->query())->links() }}

        </div>
    </div>
</div>
@endsection

@section('modal')
    @include('components.modals.workflows.create')
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

            $('#workflow-steps-create-modal').on('shown.bs.modal', function () {
                $('#name-input').trigger('focus');
            });

            @if ($errors->workflowsStore && $errors->workflowsStore->any())
                $('#workflows-create-modal').modal('show');
            @endif

            @if ($errors->workflowsDestroy && $errors->workflowsDestroy->any())
                $('#resources-delete-modal').modal('show');
            @endif
        });
    </script>
@endpush
