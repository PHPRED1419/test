@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.video_album.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.video_album.partials.header-breadcrumbs')
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
                                    {{ $category->category_name }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="slug">Short URL</label>
                                    <br>
                                    {{ $category->slug }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Image</label>
                                    <br>
                                    @if ($category->category_image != null)
                                    <img src="{{ asset('assets/images/video_album/'.$category->category_image) }}" alt="Image" class="img " /> {{--width-100--}}
                                    @else 
                                    <span class="border p-2">
                                        No Image
                                    </span>
                                    @endif
                                    
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-success">
                                    <label class="control-label" for="status">Status</label>
                                    <br>
                                    {{ $category->status === 1 ? 'Active' : 'Inactive' }}
                                </div>
                            </div>
                        </div>
                    
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="description">Description</label>
                                    <div>
                                        {!! $category->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="meta_description">Meta Description</label>
                                    <div>
                                        {!! $category->meta_description !!}
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="card-body">
                                        <a  class="btn btn-success" href="{{ route('admin.video_album.edit', $category->category_id) }}"> <i class="fa fa-edit"></i> Edit Now</a>
                                        <a href="{{ route('admin.video_album.index') }}" class="btn btn-dark ml-2">Cancel</a>
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