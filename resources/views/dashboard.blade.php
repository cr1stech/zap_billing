@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    @php
        dump(auth()->user());
    @endphp
@endsection
