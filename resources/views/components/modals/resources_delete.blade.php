<div class="modal fade" id="resources-delete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Delete Confirmation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="resources-delete-form" action="" method="post">
                    @csrf @method('delete')
                    <div class="form-group">
                        <p class="text-danger">
                            <span class="font-weight-bold d-block">{{ __('Are you sure to delete this record from the database.') }}</span>
                            <span class="">{{ __('This action cannot be undone. This will permanently delete a record from the database.') }}</span>
                            <span class="">{{ __('If you want to delete this record, please insert your password to continue.') }}</span>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-muted" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="resources-delete-form" class="btn btn-primary">{{ __('Yes, delete this resource.') }}</button>
            </div>
        </div>
    </div>
</div>
