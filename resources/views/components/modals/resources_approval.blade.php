<div class="modal fade" id="resources-approval-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Approval Confirmation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="resources-approval-form" action="" method="post">
                    @csrf @method('put')
                    <div class="form-group">
                        <p class="text-danger">
                            <span class="d-block font-weight-bold">{{ __('Are you sure to  continue?') }}</span>
                            <span class="d-block">{{ __('This action cannot be undone. This will permanently change a record status. If you want to continue, please insert your password.') }}</span>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="password-input">{{ __('Password') }}</label>
                        <input class="form-control @if ($errors->has('password')) is-invalid @endif" id="password-input" type="password" name="password">
                        @if ($errors->has('password'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="remarks-input">{{ __('Remarks') }}</label>
                        <textarea class="form-control" id="remarks-textarea" name="remarks" rows="5"></textarea>
                        @if ($errors->has('remarks'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('remarks') }}
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-muted" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="resources-approval-form" class="btn btn-primary">{{ __('Yes, continue') }}</button>
            </div>
        </div>
    </div>
</div>
