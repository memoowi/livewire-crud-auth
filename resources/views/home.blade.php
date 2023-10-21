@extends('layouts.app')

@section('content')
@if (Auth::check() && Auth::user()->role == 'admin')    
@livewire('book')
@else
<div class="container">
        <div class="row justify-content-center">
            <div class="mt-3">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
<h5 class="text-center my-5 py-5 bg-secondary-subtle rounded">
    You don't have access
</h5>
</div>
@endif
@endsection
