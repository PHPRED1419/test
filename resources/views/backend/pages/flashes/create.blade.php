@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.flashes.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.flashes.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
            <form action="{{ route('admin.flashes.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                @csrf
                <div class="form-body">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="image">Banner Image <span class="required">*</span></label>
                                    <input type="file" class="form-control dropify" data-height="100" data-allowed-file-extensions="png jpg jpeg webp" id="flash_image" name="flash_image" value="{{ old('flash_image') }}"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-success">
                                    <label class="control-label" for="status">Title <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="flash_title" name="flash_title" value="{{ old('flash_title') }}" placeholder="Enter Title" required=""/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-success">
                                    <label class="control-label" for="status">Status <span class="required">*</span></label>
                                    <select class="form-control custom-select" id="status" name="status" required>
                                        <option value="1" {{ old('status') === 1 ? 'selected' : null }}>Active</option>
                                        <option value="0" {{ old('status') === 0 ? 'selected' : null }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row ">
                            
                            <div class="col-md-12">                                
                                <div class="form-actions">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <a href="{{ route('admin.flashes.index') }}" class="btn btn-dark">Cancel</a>
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
    
    </script>
@endsection