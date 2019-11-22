@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Role Details') }}</h4></div>
                    <div class="col-auto"><a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">{{ __('Edit Role Details') }}</a></div>
                </div>
            </section>

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Name') }}</div>
                    <div class="col-auto">{{ $role->name ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Has All Permissions') }}</div>
                    <div class="col-auto">{{ $role->hasAllPermissions() ? 'Yes' : 'No' ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Created At') }}</div>
                    <div class="col-auto">{{ $role->created_at->format('d/m/Y h:i:s A') ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Updated At') }}</div>
                    <div class="col-auto">{{ $role->updated_at->format('d/m/Y h:i:s A') ?? '-' }}</div>
                </div>
                <hr>
            </section>

            <section class="my-3">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Permissions') }}</h4></div>
                </div>
            </section>

            <section class="my-3">
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($role->permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name ?? '-' }}</td>
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
