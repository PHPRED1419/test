@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.pages.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.pages.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                @csrf
                @method('put')
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="title">Title :</label>
                                    <label class="control-label" for="status">{{ $page->title }}</label>
                                </div>
                            </div>                            
                            
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-success">
                                <label class="control-label" for="status">Description <span class="required">*</span></label>
                                <textarea  id="editor" name="description">{{ $page->description }}</textarea>
                            </div>
                        </div>

                        
                        
                        <div class="row ">                           
                            <div class="col-md-12">                                
                                <div class="form-actions">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <a href="{{ route('admin.pages.index') }}" class="btn btn-dark">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    
                </div>
            </form>
        </div>
    </div>
    <script>
    CKEDITOR.replace('editor', {
        toolbar: 'Full',
        filebrowserUploadUrl: "{{ route('admin.pages.upload.media', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form',
        width: '100%', // Set the width of the editor
        height: '300px', // Set the height of the editor
    });
</script>
@endsection
