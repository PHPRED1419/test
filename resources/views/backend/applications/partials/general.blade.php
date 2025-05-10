<div class="row">
    <div class="col-md-6">
    @php
    use App\Models\ApplicationsCategories; 
    $oldParentCategoryId = old('parent_category_id',$application->category_id);
    $categories = ApplicationsCategories::printCategory($oldParentCategoryId, $layer = 2);
    @endphp
        <div class="form-group">
            <label class="control-label" for="parent_categories">Category <span class="required">*</span></label>
            <select class=" form-control" id="parent_category_id" name="parent_category_id" required>
                <option value="">Select Category</option>
                {!! $categories !!}
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="name">Application Name <span class="required">*</span></label>
            <input type="text" class="form-control" id="application_name" name="application_name" placeholder="Enter application name."
                value="{{ old('application_name',$application->application_name) }}" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="slug">Short URL <span class="optional">(optional)</span></label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug',$application->slug) }}" placeholder="Enter short url (Keep blank to auto generate)" />
        </div>
    </div>  

    <div class="col-md-6">
        <div class="form-group has-success">
            <label class="control-label" for="status">Status <span class="required">*</span></label>
            <select class="form-control custom-select" id="status" name="status" required>
                <option value="1" {{ $application->status === 1 ? 'selected' : null }}>Active</option>
                <option value="0" {{ $application->status === 0 ? 'selected' : null }}>Inactive</option>
            </select>
        </div>
    </div>   
    
    <div class="col-md-12">
        <div class="form-group">        
            <label class="control-label" for="description">Description <span class="optional">(optional)</span></label>
            <textarea  id="editor1" name="applications_description">{{ old('applications_description',$application->applications_description) }}</textarea>
        </div>
    </div>

    
</div>
<script>
    CKEDITOR.replace('editor1', {
        toolbar: 'Full',
        filebrowserUploadUrl: "{{ route('admin.applications.upload.media', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form',
        width: '100%', // Set the width of the editor
        height: '300px', // Set the height of the editor
    });
    CKEDITOR.replace('editor2', {
        toolbar: 'Full',
        filebrowserUploadUrl: "{{ route('admin.applications.upload.media', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form',
        width: '100%', // Set the width of the editor
        height: '300px', // Set the height of the editor
    });
</script>
