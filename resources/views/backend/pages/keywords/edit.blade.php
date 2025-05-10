@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.keywords.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.keywords.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
            <form action="{{ route('admin.keywords.update', $keywords->keywords_id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                @csrf
                @method('put')
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="title">Title <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="keywords_name" name="keywords_name" value="{{ $keywords->keywords_name }}" placeholder="Enter Title" required=""/>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group has-success">
                                    <label class="control-label" for="status">Status <span class="required">*</span></label>
                                    <select class="form-control custom-select" id="status" name="status" required>
                                        <option value="1" {{ $keywords->status === 1 ? 'selected' : null }}>Active</option>
                                        <option value="0" {{ $keywords->status === 0 ? 'selected' : null }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        
                        
                        <div class="row ">
                           
                            <div class="col-md-12">
                                
                                <div class="form-actions">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <a href="{{ route('admin.keywords.index') }}" class="btn btn-dark">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    
                </div>
            </form>
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