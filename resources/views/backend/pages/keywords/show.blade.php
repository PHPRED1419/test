@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.keywords.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.keywords.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="title">keywords Title</label>
                                    <br>
                                    {{ $keywords->title }}
                                </div>
                            </div>
                         
                        </div>

             
                        <div class="row ">
                        
                            <div class="col-md-12">
                          
                                <div class="form-actions">
                                    <div class="card-body">
                                        <a  class="btn btn-success" href="{{ route('admin.keywords.edit', $keywords->id) }}"> <i class="fa fa-edit"></i> Edit Now</a>
                                        <a href="{{ route('admin.keywords.index') }}" class="btn btn-dark ml-2">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    $(".categories_select").select2({
        placeholder: "Select a Category"
    });
    </script>
@endsection