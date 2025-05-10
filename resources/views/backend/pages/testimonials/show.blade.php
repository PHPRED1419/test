@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.testimonials.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.testimonials.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="title">Name</label>
                                    <br>
                                    {{ $testimonial->name }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="slug">Email</label>
                                    <br>
                                    {{ $testimonial->email }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <?php
                        /*
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Profile Photo</label>
                                    <br>
                                    @if ($testimonial->photo != null)
                                    <img src="{{ asset('assets/images/testimonials/'.$testimonial->photo) }}" alt="Image" class="img " />
                                    @else 
                                    <span class="border p-2">
                                        No Image
                                    </span>
                                    @endif
                                    
                                </div>
                            </div>
                            */
                            ?>
                            <div class="col-md-6">
                                <div class="form-group has-success">
                                    <label class="control-label" for="status">Status</label>
                                    <br>
                                    {{ $testimonial->status === 1 ? 'Active' : 'Inactive' }}
                                </div>
                            </div>
                        </div>
                    
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="description">Description</label>
                                    <div>
                                        {!! $testimonial->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                
                                <div class="form-actions">
                                    <div class="card-body">
                                        <a  class="btn btn-success" href="{{ route('admin.testimonials.edit', $testimonial->testimonial_id) }}"> <i class="fa fa-edit"></i> Edit Now</a>
                                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-dark ml-2">Cancel</a>
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