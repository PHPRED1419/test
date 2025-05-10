@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.blogs.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.blogs.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                @csrf
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                        <div class="col-md-6">
                                <div class="form-group">                               
                                <label class="control-label" for="title">Blog Category <span class="required">*</span></label>
                                <select name="category_id" id="category_id" style="width:527px !important;" class="form-control select2 @error('category_id') is-invalid @enderror" required>
                                    @if($categories->isEmpty())
                                        <option value="">No categories available</option>
                                    @else
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}" 
                                                {{ (old('category_id') == $category->category_id || (isset($blog) && $blog->category_id == $category->id)) ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">
                                        <i class="fa fa-exclamation-triangle"></i> {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="title">Blog Title <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter Title" required=""/>
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
                                    <label class="control-label" for="image">Blog Image1 <span class="optional">(optional)</span></label>
                                    <input type="file" class="form-control dropify" data-height="70" data-allowed-file-extensions="png jpg jpeg webp" id="image" name="image" value="{{ old('image') }}"/>
                                    [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 685X685) ]
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Blog Image2 <span class="optional">(optional)</span></label>
                                    <input type="file" class="form-control dropify" data-height="70" data-allowed-file-extensions="png jpg jpeg webp" id="image2" name="image2" value="{{ old('image2') }}"/>
                                    [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 685X685) ]
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Blog Image3 <span class="optional">(optional)</span></label>
                                    <input type="file" class="form-control dropify" data-height="70" data-allowed-file-extensions="png jpg jpeg webp" id="image3" name="image3" value="{{ old('image3') }}"/>
                                    [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 685X685) ]
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Blog Image4 <span class="optional">(optional)</span></label>
                                    <input type="file" class="form-control dropify" data-height="70" data-allowed-file-extensions="png jpg jpeg webp" id="image4" name="image4" value="{{ old('image4') }}"/>
                                    [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 685X685) ]
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
                                <div class="form-group">
                                    <label class="control-label" for="description">Blog Description <span class="optional">(optional)</span></label>
                                    <textarea type="text" class="form-control tinymce_advance" id="description" name="description" value="{{ old('description') }}"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="meta_description">Blog Meta Description <span class="optional">(optional)</span></label>
                                    <textarea type="text" class="form-control" id="meta_description" name="meta_description" value="{{ old('meta_description') }}" placeholder="Meta description for SEO"></textarea>
                                </div>
                                <div class="form-actions">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-dark">Cancel</a>
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