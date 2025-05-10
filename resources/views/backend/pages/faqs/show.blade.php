@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.faqs.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.faqs.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="title">Question</label>
                                    <br>
                                    {{ $faq->faq_question }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="title">Answer</label>
                                    <br>
                                    {!! $faq->faq_answer !!}
                                </div>
                            </div>                           
                        </div>
                    
                    </div>
                </div>
        </div>
    </div>
@endsection

