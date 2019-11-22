@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row">
                    <div class="col"><h4>{{ __('Edit Workflow Details') }}</h4></div>
                </div>
            </section>

            <section class="my-4">
                <form action="{{ route('workflows.update', $workflow) }}" method="post">
                    @csrf @method('put')

                    <div class="form-group">
                        <label for="">{{ __('Name') }}</label>
                        <input class="form-control @if ($errors->workflowsUpdate->has('name')) is-invalid @endif" type="text" name="name" value="{{ old('name', $workflow->name) }}" autofocus>
                        @if ($errors->workflowsUpdate->has('name'))
                            <div class="small invalid-feedback">
                                {{ $errors->workflowsUpdate->first('name') }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                </form>
            </section>

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Workflow Step') }}</h4></div>
                    <div class="col-auto"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#workflow-steps-create-modal">{{ __('New Workflow Step') }}</a></div>
                </div>
            </section>

            <section class="my-4">
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('From') }}</th>
                                <th>{{ __('To') }}</th>
                                <th>{{ __('Action By') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th colspan="2">{{ __('Updated At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($workflow->workflowSteps as $workflowStep)
                                <tr>
                                    <td>{{ $workflowStep->fromDocumentStatus->name ?? '-' }}</td>
                                    <td>{{ $workflowStep->toDocumentStatus->name ?? '-' }}</td>
                                    <td>{{ $workflowStep->stepActionBy->name ?? '-' }}</td>
                                    <td>{{ $workflowStep->created_at->format('d/m/Y h:i:s A') ?? '-' }}</td>
                                    <td>{{ $workflowStep->updated_at->format('d/m/Y h:i:s A') ?? '-' }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                                {{ __('Action') }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('workflows.workflow-steps.update', [$workflow, $workflowStep]) }}" data-toggle="modal" data-target="#workflow-steps-edit-modal" data-step-from="{{ $workflowStep->from_document_status_id }}" data-step-to="{{ $workflowStep->to_document_status_id }}" data-action-by="{{ $workflowStep->step_action_by }}">{{ __('Edit') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="{{ route('workflows.workflow-steps.destroy', [$workflow, $workflowStep]) }}" data-toggle="modal" data-target="#resources-delete-modal">{{ __('Delete') }}</a>
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

        </div>
    </div>
</div>
@endsection

@section ('modal')
    @include('components.modals.workflow_steps.create')
    @include('components.modals.workflow_steps.edit')
    @include('components.modals.resources_delete')
@endsection

@push('js')
    <script>
        $(function () {
            $('#workflow-steps-edit-modal').on('show.bs.modal', function (event) {
                var button, action, stepFrom, stepTo, actionBy, modal = null;
                button = $(event.relatedTarget) || null;
                action = button.prop('href') || null;
                stepFrom = button.data('step-from');
                stepTo = button.data('step-to');
                actionBy = button.data('action-by');
                modal = $(this);

                action = (action != null && action != '') ? action : '{{ old('action') }}';
                stepFrom = (stepFrom != null && stepFrom != '') ? stepFrom : '{{ old('from_document_status') }}';
                stepTo = (stepTo != null && stepTo != '') ? stepTo : '{{ old('to_document_status') }}';
                actionBy = (actionBy != null && actionBy != '') ? actionBy : '{{ old('step_action_by') }}';

                modal.find('#workflow-steps-edit-form').prop('action', action);
                modal.find('#workflow-steps-edit-step-from').val(parseInt(stepFrom));
                modal.find('#workflow-steps-edit-step-to').val(parseInt(stepTo));
                modal.find('#workflow-steps-edit-step-action-by').val(parseInt(actionBy));
            });

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

            @if ($errors->workflowStepsDestroy && $errors->workflowStepsDestroy->any())
                $('#resources-delete-modal').modal('show');
            @endif

            @if ($errors->workflowStepsStore && $errors->workflowStepsStore->any())
                $('#workflow-steps-create-modal').modal('show');
            @endif

            @if ($errors->workflowStepsUpdate && $errors->workflowStepsUpdate->any())
                $('#workflow-steps-edit-modal').modal('show');
            @endif
        });
    </script>
@endpush
