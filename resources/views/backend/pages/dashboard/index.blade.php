@extends('backend.layouts.master')
@section('title')
@include('backend.pages.dashboard.partials.title')
@endsection
@section('admin-content')
@include('backend.pages.dashboard.partials.header-breadcrumbs')

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->

<div class="container-fluid">
    <h4>
        Hello, <strong>{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</strong> Welcome to {{ env('APP_NAME') }}.
    </h4> 
    @include('backend.pages.dashboard.partials.top-show') 
    {{-- @include('backend.pages.dashboard.partials.email-campaign') --}}
    {{-- @include('backend.pages.dashboard.partials.revinue-page-bounce') --}}
    {{-- @include('backend.pages.dashboard.partials.recent-data')  --}}
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection
