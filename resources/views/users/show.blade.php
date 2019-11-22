@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('User Details') }}</h4></div>
                    <div class="col-auto"><a href="{{ route('users.edit', $user) }}" class="btn btn-primary">{{ __('Edit User Details') }}</a></div>
                </div>
            </section>

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Name') }}</div>
                    <div class="col-auto">{{ $user->name ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Email') }}</div>
                    <div class="col-auto">{{ $user->email ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Roles') }}</div>
                    <div class="col-auto">{{ $user->getRoleNames() ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Created At') }}</div>
                    <div class="col-auto">{{ $user->created_at->format('d/m/Y h:i:s A') ?? '-' }}</div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col font-weight-bold">{{ __('Updated At') }}</div>
                    <div class="col-auto">{{ $user->updated_at->format('d/m/Y h:i:s A') ?? '-' }}</div>
                </div>
                <hr>
            </section>

            <section class="my-4">
                <div class="row align-items-center">
                    <div class="col"><h4>{{ __('Roles') }}</h4></div>
                </div>
            </section>

            <section class="my-4">
                <table class="table table-striped text-nowrap">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user->roles as $role)
                            <tr>
                                <td>{{ $role->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td>{{ __('There is no data.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

        </div>
    </div>
</div>
@endsection
