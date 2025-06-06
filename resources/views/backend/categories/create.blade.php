@extends('backend.layouts.master')

@section('title')
    @include('backend.categories.partials.title')
@endsection

@section('styles')

@endsection

@section('admin-content')
    @include('backend.categories.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                @csrf
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Category Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Category Name" required=""/>
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
                                    <label class="control-label" for="parent_category_id">Parent Category <span class="optional">(optional)</span></label>
                                    <br>
                                    <select class="parent_categories_select form-control custom-select " id="parent_categories" name="parent_category_id" style="width: 100%;">
                                        <option value="">Select Parent Category</option>
                                        {!! $categories !!}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="priority">Display Order <span class="optional">(optional)</span></label>
                                    <input type="text" class="form-control" id="priority" name="priority" value="{{ old('priority') }}" placeholder="Enter Display Order (Lower=Higher); eg-1" min="0"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="status">Status <span class="required">*</span></label>
                                    <select class="form-control custom-select" id="status" name="status" required>
                                        <option value="1" {{ old('status') == "1" ? 'selected' : null }}>Active</option>
                                        <option value="0" {{ old('status') == "0" ? 'selected' : null }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                           <?php
                           /* <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="banner_image">Category Banner Image <span class="optional">(optional)</span></label>
                                    <input type="file" class="form-control dropify" data-height="70" data-allowed-file-extensions="png jpg jpeg webp" id="banner_image" name="banner_image" value="{{ old('banner_image') }}"/>
                                </div>
                            </div>
                            */
                            ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="logo_image">Category Image <span class="optional">(optional)</span></label>
                                    <input type="file" class="form-control dropify" data-height="100" data-allowed-file-extensions="png jpg jpeg webp" id="category_image" name="category_image" value="{{ old('category_image') }}"/>
                                    [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 281X283) ]
                                </div>
                            </div>
                        </div>


                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="description">Category Description <span class="optional">(optional)</span></label>
                                    <textarea type="text" class="form-control tinymce_simple" id="description" name="description" value="{{ old('description') }}"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="meta_description">Category Meta Description <span class="optional">(optional)</span></label>
                                    <textarea type="text" class="form-control" id="meta_description" name="meta_description" value="{{ old('meta_description') }}" placeholder="Meta description for SEO"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php /*?><div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="enable_bg" name="enable_bg">
                                            <label class="custom-control-label" for="enable_bg">
                                                <strong>Enable Color</strong>
                                            </label>
                                        </div><?php */?>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-dark">Cancel</a>
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
@include('backend.categories.partials.scripts')
@endsection
