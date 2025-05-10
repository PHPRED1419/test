@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.video_gallery.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.video_gallery.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
            <form action="{{ route('admin.video_gallery.update', $gallery->gallery_id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                @csrf
                @method('put')
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">

                        <div class="col-md-6">
                            <div class="form-group">                               
                            <label class="control-label" for="title">Album <span class="required">*</span></label>
                            <select name="category_id" id="category_id" style="width:527px !important;" class="form-control select2 @error('category_id') is-invalid @enderror" required>
                                @if($categories->isEmpty())
                                    <option value="">No categories available</option>
                                @else
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" 
                                            {{ (old('category_id') == $category->category_id || (isset($gallery) && $gallery->category_id == $category->category_id)) ? 'selected' : '' }}>
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
                                    <label class="control-label" for="title">Title <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $gallery->title }}" placeholder="Enter Title" required=""/>
                                </div>
                            </div>
                         
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Image <span class="optional">(optional)</span></label>
                                    <input type="file" class="form-control dropify" data-height="70" data-allowed-file-extensions="png jpg jpeg webp" id="photo" name="photo" data-default-file="{{ $gallery->photo != null ? asset('assets/images/video_gallery/'.$gallery->photo) : null }}"/>
                                    <p style="padding-top:2px; color: red;"><label><input type="checkbox" name="delete_check" id="delete_check" value="yes"> Delete Image</label></p>
                                    [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 281X283) ]
                                </div>
                            </div>

                            </div>
                            <div class="row ">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Youtube link <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="youtube_link" name="youtube_link" value="{{ $gallery->youtube_link }}" placeholder="Enter youtube link" required=""/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-success">
                                    <label class="control-label" for="status">Status <span class="required">*</span></label>
                                    <select class="form-control custom-select" id="status" name="status" required>
                                        <option value="1" {{ $gallery->status === 1 ? 'selected' : null }}>Active</option>
                                        <option value="0" {{ $gallery->status === 0 ? 'selected' : null }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row ">
                                <div class="form-actions">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <a href="{{ route('admin.video_gallery.index') }}" class="btn btn-dark">Cancel</a>
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