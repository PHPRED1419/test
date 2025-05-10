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
                    data-max-file-size="500K" data-height="76" id="application_images_{{ $i }}" name="application_images_{{ $i }}" 
                    data-default-file="{{ $val->media != null ? asset('assets/images/applications/'.$val->media) : null }}" />
                <input type="hidden" name="existing_media_{{ $i }}" value="{{ $val->id }}">
                <p style="padding-top:2px; color: red;"><label><input type="checkbox" name="delete_check_{{ $i }}" id="delete_check{{ $i }}" value="yes"> Delete Image</label></p> 
            </div>  
            [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 410X470) ]
        </div>  
        @php $i++; @endphp
    @endforeach
@endif

{{-- Fill the remaining media inputs up to  the total counter --}}
@for($j = $i; $j <= $image_counter; $j++)
    <div class="col-md-6">  
        <div class="form-group">
            <label class="control-label" for="logo">
                Product Image{{ $j }} &nbsp;
                <i class="fa fa-info-circle" data-toggle="tooltip"
                    title="Only png jpg jpeg webp svg type images are allowed. Max image size 0.5 MB."></i>
            </label>
            <input type="file" class="form-control dropify" data-allowed-file-extensions="png jpg jpeg webp svg"
                data-max-file-size="500K" data-height="76" id="application_images_{{ $j }}" name="application_images_{{ $j }}" data-default-file="" />
        </div>  
        [ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 410X470) ]
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
                data-max-file-size="500K" data-height="76" id="application_sizechart_image" name="application_sizechart_image" 
                data-default-file="{{ $application->application_sizechart_image != null ? asset('public/assets/images/applications/'.$application->application_sizechart_image) : null }}" />
        </div>
    </div>
    */
    ?>

    {{-- Product Alt --}}
    <div class="col-md-6">
        <div class="form-group">       
            <label class="control-label" for="alt">Product Alt <span class="optional">(optional)</span></label>
            <input type="text" class="form-control" id="application_alt" name="application_alt" value="{{ $application->application_alt != null ? $application->application_alt : null }}">
        </div>
    </div>
</div>