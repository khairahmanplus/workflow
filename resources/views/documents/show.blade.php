@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Document') }}</h4></div>
                    <div class="col-auto">

                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                {{ __('Action') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <h6 class="dropdown-header">{{ __('Approval Action') }}</h6>
                                @if ($document->isNew())
                                    @can ('review_document')
                                        <a class="dropdown-item" href="{{ route('documents.approval', [$document, 'action' => 'approval', 'step-to' => 'reviewed']) }}" data-toggle="modal" data-target="#resources-approval-modal">{{ __('Review') }}</a>
                                    @endcan
                                    @can ('query_to_document_creator')
                                        <a class="dropdown-item" href="{{ route('documents.approval', [$document, 'action' => 'approval', 'step-to' => 'query_new']) }}" data-toggle="modal" data-target="#resources-approval-modal">{{ __('Query → Document Creator') }}</a>
                                    @endcan
                                @endif
                                @if ($document->isReviewed())
                                    @can ('support_document_level1')
                                        <a class="dropdown-item" href="{{ route('documents.approval', [$document, 'action' => 'approval', 'step-to' => 'supported_level1']) }}" data-toggle="modal" data-target="#resources-approval-modal">{{ __('Support') }}</a>
                                    @endcan
                                    @can ('query_to_document_reviewer')
                                        <a class="dropdown-item" href="{{ route('documents.approval', [$document, 'action' => 'approval', 'step-to' => 'new']) }}" data-toggle="modal" data-target="#resources-approval-modal">{{ __('Query → Document Reviewer') }}</a>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Name') }}</div>
                    <div class="col-auto">{{ $document->name ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Created At') }}</div>
                    <div class="col-auto">{{ $document->created_at->format('d/m/Y h:i:s A') ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Updated At') }}</div>
                    <div class="col-auto">{{ $document->updated_at->format('d/m/Y h:i:s A') ?? '-' }}</div>
                </div>
                <hr>
            </section>

            <section class="my-3">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Activity') }}</h4></div>
                </div>
            </section>

            <section class="my-3">
                <div class="my-3 d-flex align-items-center">
                    @foreach ($document->latestDocumentActivities->reverse() as $documentActivity)
                        <span class="badge badge-pill {{ $loop->last ? 'badge-primary' : 'badge-secondary' }}">
                            {{ $documentActivity->documentStatus->name }}
                        </span>
                        @if ($loop->remaining)
                            <span class="px-1">
                                &rightarrow;
                            </span>
                        @endif
                    @endforeach
                </div>
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action By') }}</th>
                                <th>{{ __('Created At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($document->latestDocumentActivities as $documentActivity)
                                <tr>
                                    <td>{{ $documentActivity->documentStatus->name ?? '-' }}</td>
                                    <td>{{ $documentActivity->actionBy->name ?? '-' }}</td>
                                    <td>{{ $documentActivity->created_at->format('d/m/Y h:i:s A') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>{{ __('There is no data.') }}</td>
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
    @include('components.modals.resources_approval')
@endsection

@push('js')
    <script>
        $(function () {
            $('#resources-approval-modal').on('show.bs.modal', function (event) {
                var button, action, modal = null;
                button = $(event.relatedTarget) || null;
                action = button.prop('href') || null;
                modal = $(this);

                action = (action != null && action != '') ? action : '{{ old('action') }}';

                modal.find('#resources-approval-form').prop('action', action);
            });
        });
    </script>
@endpush
