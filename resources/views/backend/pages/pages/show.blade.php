@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.pages.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.pages.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="title">Title</label>
                                    <br>
                                    {{ $pages->title }}
                                </div>
                            </div>                            
                        </div>
                    
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="description">Description</label>
                                    <div>
                                        {!! $pages->description !!}
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
