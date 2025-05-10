<div class="row">
@php 
    $i = 1;
    $total_media = is_array($medias) ? count($medias) : $medias->count();
@endphp

{{-- Loop through existing media records --}}
@if (!empty($medias))
    @foreach($medias as $val)
        <div class="col-md-6">  
            <div class="form-group">
                <label class="control-label" for="logo">
                    Product Image{{ $i }} &nbsp;
                    <i class="fa fa-info-circle" data-toggle="tooltip"
                        title="Only png jpg jpeg webp svg type images are allowed. Max image size 0.5 MB."></i>
                </label>
                <input type="file" class="form-control dropify" data-allowed-file-extensions="png jpg jpeg webp svg"
                    data-max-file-size="500K" data-height="76" id="product_images_{{ $i }}" name="product_images_{{ $i }}" 
                    data-default-file="{{ $val->media != null ? asset('assets/images/products/'.$val->media) : null }}" />
                <input type="hidden" name="existing_media_{{ $i }}" value="{{ $val->id }}">
                <p style="padding-top:2px; color: red;"><label><input type="checkbox" name="delete_check_{{ $i }}" id="delete_check{{ $i }}" value="yes"> Delete Image</label></p> 
                [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 620X408) ]
            </div>  
        </div>  
        @php $i++; @endphp
    @endforeach
@endif

@for($j = $i; $j <= $image_counter; $j++)
    <div class="col-md-6">  
        <div class="form-group">
            <label class="control-label" for="logo">
                Product Image{{ $j }} &nbsp;
                <i class="fa fa-info-circle" data-toggle="tooltip"
                    title="Only png jpg jpeg webp svg type images are allowed. Max image size 0.5 MB."></i>
            </label>
            <input type="file" class="form-control dropify" data-allowed-file-extensions="png jpg jpeg webp svg"
                data-max-file-size="500K" data-height="76" id="product_images_{{ $j }}" name="product_images_{{ $j }}" data-default-file="" />
                [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 620X408) ]
        </div>  
    </div> 
@endfor

    {{-- Size Chart Image --}}
   <?php
   /* <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="logo">
                Size Chart Image &nbsp;
                <i class="fa fa-info-circle" data-toggle="tooltip"
                    title="Only png jpg jpeg webp svg type images are allowed. Max image size 0.5 MB."></i>
            </label>
            <input type="file" class="form-control dropify" data-allowed-file-extensions="png jpg jpeg webp svg"
                data-max-file-size="500K" data-height="76" id="product_sizechart_image" name="product_sizechart_image" 
                data-default-file="{{ $product->product_sizechart_image != null ? asset('public/assets/images/products/'.$product->product_sizechart_image) : null }}" />
        </div>
    </div>
    */
    ?>

    {{-- Product Alt --}}
    <div class="col-md-6">
        <div class="form-group">       
            <label class="control-label" for="alt">Product Alt <span class="optional">(optional)</span></label>
            <input type="text" class="form-control" id="product_alt" name="product_alt" value="{{ $product->product_alt != null ? $product->product_alt : null }}">
        </div>
    </div>
</div>