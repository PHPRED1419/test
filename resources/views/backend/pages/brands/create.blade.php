@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.brands.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.brands.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                @csrf
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="title">Brand Title <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name') }}" placeholder="Enter Title" required=""/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="slug">Short URL <span class="optional">(optional)</span></label>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Enter short url (Keep blank to auto generate)" />
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Brand Image <span class="optional">(optional)</span></label>
                                    <input type="file" class="form-control dropify" data-height="70" data-allowed-file-extensions="png jpg jpeg webp" id="brand_image" name="brand_image" value="{{ old('brand_image') }}"/>
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
                                        <a href="{{ route('admin.brands.index') }}" class="btn btn-dark">Cancel</a>
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