@extends('layouts.app')

@section('content')
    <h2>Dashboard</h2>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <p>You are logged in!</p>
@endsection
