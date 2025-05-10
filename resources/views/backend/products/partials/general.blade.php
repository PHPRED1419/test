@php
    use App\Models\Category; 
    $oldParentCategoryId = old('parent_category_id',$product->category_id);
    $categories = Category::printCategory($oldParentCategoryId, $layer = 3);
@endphp
<div class="row">
<?php
/*<div class="col-md-6">    
    <div class="form-group">
        <label class="control-label">Product Type <span class="required">*</span></label>
        <label class="control-label"> 
            <input type="radio" name="product_type" class="" style="" value="1" 
                   @if(old('product_type', $product->product_type) == '1') checked @endif> Product
        </label>
        <label class="control-label"> 
            <input type="radio" name="product_type" class="" style="" value="2" 
                   @if(old('product_type', $product->product_type) == '2') checked @endif> Service
        </label>
    </div>
</div>

*/
?>
</div>

<div class="row">
    <div class="col-md-6">    
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
            <label class="control-label" for="name">Product Name <span class="required">*</span></label>
            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name."
                value="{{ old('product_name',$product->product_name) }}" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="slug">Short URL <span class="optional">(optional)</span></label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug',$product->slug) }}" placeholder="Enter short url (Keep blank to auto generate)" />
        </div>
    </div>  
    
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="description">Product Code<span class="required">*</span></label>
            <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter product code."
                value="{{ old('product_code',$product->product_code) }}" required />
        </div>
    </div>
    <?php
    /*
    <div class="col-md-6">
        <div class="form-group">
        <label class="control-label" for="price">Product Price<span class="required">*</span></label>
            <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter product price."
                value="{{ old('product_price',$product->product_price) }}" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        <label class="control-label" for="price">Discounted Price<span class="optional">(optional)</span></label>
            <input type="text" class="form-control" id="product_discounted_price" name="product_discounted_price" placeholder="Enter product discounted price."
                value="{{ old('product_discounted_price',$product->product_discounted_price) }}" required />
        </div>
    </div>
    */
    ?>
    <div class="col-md-12">
        <div class="form-group">        
            <label class="control-label" for="description">Description <span class="optional">(optional)</span></label>
            <textarea  id="editor1" name="products_description">{{ old('products_description',$product->products_description) }}</textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">        
            <label class="control-label" for="description">Specification <span class="optional">(optional)</span></label>
            <textarea  id="editor2" name="products_specification">{{ old('products_specification',$product->products_specification) }}</textarea>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group has-success">
            <label class="control-label" for="status">Status <span class="required">*</span></label>
            <select class="form-control custom-select" id="status" name="status" required>
                <option value="1" {{ old('status',$product->status) === 1 ? 'selected' : null }}>Active</option>
                <option value="0" {{ old('status',$product->status) === 0 ? 'selected' : null }}>Inactive</option>
            </select>
        </div>
    </div>
    
</div>
<script>
    CKEDITOR.replace('editor1', {
        toolbar: 'Full',
        filebrowserUploadUrl: "{{ route('admin.products.upload.media', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form',
        width: '100%', // Set the width of the editor
        height: '300px', // Set the height of the editor
    });
    CKEDITOR.replace('editor2', {
        toolbar: 'Full',
        filebrowserUploadUrl: "{{ route('admin.products.upload.media', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form',
        width: '100%', // Set the width of the editor
        height: '300px', // Set the height of the editor
    });
</script>
