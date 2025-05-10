@extends('backend.layouts.master')

@section('title')
    @include('backend.products.partials.title')
@endsection

@section('styles')

@endsection

@section('admin-content')
    @include('backend.products.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                @csrf
                <div class="form-body">
                    <div class="card-body">
                        <div class="row">                        

                            <div class="col-md-8">
                                <div class="nav  nav-pills border" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-general-tab" data-toggle="pill"
                                        href="#v-pills-general" role="tab" aria-controls="v-pills-general"
                                        aria-selected="true">
                                        <i class="fa fa-th"></i> &nbsp;
                                        General
                                    </a>
                                    {{-- <a class="nav-link" id="v-pills-contact-tab" data-toggle="pill" href="#v-pills-contact"
                                        role="tab" aria-controls="v-pills-contact" aria-selected="false">
                                        <i class="fa fa-paper-plane"></i> &nbsp;
                                        Entities
                                    </a> --}}
                                    <a class="nav-link" id="v-pills-social-tab" data-toggle="pill" href="#v-pills-social"
                                        role="tab" aria-controls="v-pills-social" aria-selected="false">
                                        <i class="fa fa-share-square"></i> &nbsp;
                                        Images
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-4 text-right border">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i>
                            Save
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-dark">
                            Cancel
                        </a>
                        </div>


                            <div class="col-md-12 mt-4">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel"
                                        aria-labelledby="v-pills-general-tab">
                                        @include('backend.products.partials.general')
                                    </div>
                                    {{-- 
                                    <div class="tab-pane fade" id="v-pills-contact" role="tabpanel"
                                        aria-labelledby="v-pills-contact-tab">
                                        @include('backend.products.partials.entities', 
                                        ['brands' => $brands,'sizes' => $sizes,'colors' => $colors]
                                        )
                                    </div>
                                    --}}
                                    <div class="tab-pane fade" id="v-pills-social" role="tabpanel"
                                        aria-labelledby="v-pills-social-tab">
                                        @include('backend.products.partials.images',
                                        ['product' => $product, 'medias' => []]
                                        )
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
@include('backend.products.partials.scripts')
@endsection
