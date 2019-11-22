<div class="modal fade" id="workflows-create-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('New Workflow') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="workflows-create-form" action="{{ route('workflows.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="name-input">{{ __('Name') }}</label>
                        <input class="form-control @if ($errors->workflowsStore->has('name')) is-invalid @endif" id="name-input" type="text" name="name" value="{{ old('name') }}">
                        @if ($errors->workflowsStore->has('name'))
                            <div class="small invalid-feedback">
                                {{ $errors->workflowsStore->first('name') }}
                            </div>
                        @endif
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-muted" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="workflows-create-form" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
