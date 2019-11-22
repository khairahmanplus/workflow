<div class="modal fade" id="workflow-steps-edit-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Workflow Step') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="workflow-steps-edit-form" action="" method="post">
                    @csrf @method('put')

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="workflow-steps-edit-step-from">{{ __('Step (From)') }}</label>
                                <select class="form-control @if ($errors->workflowStepsUpdate->has('from_document_status')) is-invalid @endif" id="workflow-steps-edit-step-from" name="from_document_status">
                                    <option selected disabled>{{ __('Please Select') }}</option>
                                    @foreach ($documentStatuses as $documentStatus)
                                        <option value="{{ $documentStatus->id }}" {{ $documentStatus->id == old('from_document_status')  ? 'selected' : null }}>{{ $documentStatus->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->workflowStepsUpdate->has('from_document_status'))
                                    <div class="small invalid-feedback">
                                        {{ $errors->workflowStepsUpdate->first('from_document_status') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="workflow-steps-edit-step-to">{{ __('Step (To)') }}</label>
                                <select class="form-control @if ($errors->workflowStepsUpdate->has('to_document_status')) is-invalid @endif" id="workflow-steps-edit-step-to" name="to_document_status">
                                    <option selected disabled>{{ __('Please Select') }}</option>
                                    @foreach ($documentStatuses as $documentStatus)
                                        <option value="{{ $documentStatus->id }}" {{ $documentStatus->id == old('to_document_status') ? 'selected' : null }}>{{ $documentStatus->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->workflowStepsUpdate->has('to_document_status'))
                                    <div class="small invalid-feedback">
                                        {{ $errors->workflowStepsUpdate->first('to_document_status') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="workflow-steps-edit-step-action-by">{{ __('Step Must Carried By') }}</label>
                        <select class="form-control @if ($errors->workflowStepsUpdate->has('step_action_by')) is-invalid @endif" id="workflow-steps-edit-step-action-by" name="step_action_by">
                            <option selected disabled>{{ __('Please Select') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == old('step_action_by') ? 'selected' : null }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->workflowStepsUpdate->has('step_action_by'))
                            <div class="small invalid-feedback">
                                {{ $errors->workflowStepsUpdate->first('step_action_by') }}
                            </div>
                        @endif
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-muted" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="workflow-steps-edit-form" class="btn btn-primary">{{ __('Save changes') }}</button>
            </div>
        </div>
    </div>
</div>
