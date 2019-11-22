@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Workflow Details') }}</h4></div>
                    <div class="col-auto"><a href="{{ route('workflows.edit', $workflow) }}" class="btn btn-primary">{{ __('Edit Workflow Details') }}</a></div>
                </div>
            </section>

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Name') }}</div>
                    <div class="col-auto">{{ $workflow->name ?? '-' }}</div>
                </div>
                <hr>
            </section>

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Workflow Step') }}</h4></div>
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
                                <th>{{ __('Updated At') }}</th>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">{{ __('There is no data.') }}</td>
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
