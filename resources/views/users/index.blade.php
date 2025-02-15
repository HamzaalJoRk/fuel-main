@extends('layouts.app')

@section('content')

<a href="{{ route('users.create') }}" class="btn btn-success">
    Add User
</a>
@if(session('success'))
    <div class="mb-4">
        <div class="font-medium text-green-600">
            {{ session('success') }}
        </div>
    </div>
@endif
<div>
@livewire('users-table')

@endsection