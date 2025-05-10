<script src="<?php echo e(asset('public/assets/backend/js/color-picker/jscolor.js')); ?>"></script>
<script>

$(".parent_categories_select").select2({
    placeholder: "Select a Parent Category"
});

$("#enable_bg").click(function(){
    if($('#enable_bg').is(':checked')){
        $(".enable_bg_area").removeClass('display-hidden');
        $(".enable_bg_area").addClass('display-block');
    }else{
        $(".enable_bg_area").removeClass('display-block'); 
        $(".enable_bg_area").addClass('display-hidden');
    }
});
</script><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/categories/partials/scripts.blade.php ENDPATH**/ ?>