@extends('admin.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Dashboard' }} @endsection
@section('content')
    @include('admin.master.dashboard')
@endsection
