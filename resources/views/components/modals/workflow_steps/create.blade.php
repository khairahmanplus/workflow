<div class="modal fade" id="workflow-steps-create-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('New Workflow Step') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="workflow-steps-create-form" action="{{ route('workflows.workflow-steps.store', $workflow) }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{ __('Step (From)') }}</label>
                                <select class="form-control @if ($errors->workflowStepsStore->has('from_document_status')) is-invalid @endif" name="from_document_status">
                                    <option selected disabled>{{ __('Please Select') }}</option>
                                    @foreach ($documentStatuses as $documentStatus)
                                        <option value="{{ $documentStatus->id }}" {{ $documentStatus->id == old('from_document_status')  ? 'selected' : null }}>{{ $documentStatus->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->workflowStepsStore->has('from_document_status'))
                                    <div class="small invalid-feedback">
                                        {{ $errors->workflowStepsStore->first('from_document_status') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{ __('Step (To)') }}</label>
                                <select class="form-control @if ($errors->workflowStepsStore->has('to_document_status')) is-invalid @endif" name="to_document_status">
                                    <option selected disabled>{{ __('Please Select') }}</option>
                                    @foreach ($documentStatuses as $documentStatus)
                                        <option value="{{ $documentStatus->id }}" {{ $documentStatus->id == old('to_document_status') ? 'selected' : null }}>{{ $documentStatus->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->workflowStepsStore->has('to_document_status'))
                                    <div class="small invalid-feedback">
                                        {{ $errors->workflowStepsStore->first('to_document_status') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Step Must Carried By') }}</label>
                        <select class="form-control @if ($errors->workflowStepsStore->has('step_action_by')) is-invalid @endif" name="step_action_by">
                            <option selected disabled>{{ __('Please Select') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == old('step_action_by') ? 'selected' : null }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->workflowStepsStore->has('step_action_by'))
                            <div class="small invalid-feedback">
                                {{ $errors->workflowStepsStore->first('step_action_by') }}
                            </div>
                        @endif
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-muted" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="workflow-steps-create-form" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
