@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.flashes.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.flashes.partials.header-breadcrumbs')
    
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
                <div class="form-body">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">Banner Image</label>
                                    <br>
                                    @if ($flashe->flash_image != null)
                                    <img src="{{ asset('assets/images/flashes/'.$flashe->flash_image) }}" width="100%" alt="Image" class="img " /> 
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
                                    {{ $flashe->status == 1 ? 'Active' : 'Inactive' }}
                                </div>
                            </div>
                        </div>
                    
                        
                    </div>
                </div>
        </div>
    </div>
@endsection

