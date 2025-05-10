!window.jQuery && document.write(unescape('%3Cscript src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.10.2.min.js"%3E%3C/script%3E'));
/*$('meta[name="viewport"]').prop('content', 'width=1280'); */

!function(e,t,r){function n(){for(;d[0]&&"loaded"==d[0][f];)c=d.shift(),c[o]=!i.parentNode.insertBefore(c,i)}for(var s,a,c,d=[],i=e.scripts[0],o="onreadystatechange",f="readyState";s=r.shift();)a=e.createElement(t),"async"in i?(a.async=!1,e.body.appendChild(a)):i[f]?(d.push(a),a[o]=n):e.write("<"+t+' src="'+s+'" defer></'+t+">"),a.src=s}(document,"script",[script_url+'Scripts/helpers.min.js'])

if(Page=='home'){
!function(e,t,r){function n(){for(;d[0]&&"loaded"==d[0][f];)c=d.shift(),c[o]=!i.parentNode.insertBefore(c,i)}for(var s,a,c,d=[],i=e.scripts[0],o="onreadystatechange",f="readyState";s=r.shift();)a=e.createElement(t),"async"in i?(a.async=!1,e.body.appendChild(a)):i[f]?(d.push(a),a[o]=n):e.write("<"+t+' src="'+s+'" defer></'+t+">"),a.src=s}(document,"script",[script_url+'Scripts/fluid_dg.min.js'])
}

else{
}

if(Page=='details'){
!function(e,t,r){function n(){for(;d[0]&&"loaded"==d[0][f];)c=d.shift(),c[o]=!i.parentNode.insertBefore(c,i)}for(var s,a,c,d=[],i=e.scripts[0],o="onreadystatechange",f="readyState";s=r.shift();)a=e.createElement(t),"async"in i?(a.async=!1,e.body.appendChild(a)):i[f]?(d.push(a),a[o]=n):e.write("<"+t+' src="'+s+'" defer></'+t+">"),a.src=s}(document,"script",[script_url+'zoom/magiczoomplus.js',script_url+'zoom/magicscroll.js'])
}

$(window).load(function(e) {		
$('.pop1').fancybox({iframe:{css:{width:'450'}}});
$('.pop2').fancybox({iframe:{css:{width:'600'}}});
$('.pop3').fancybox({iframe:{css:{width:'900'}}});

$('.showhide').click(function(){$(this).next().slideToggle();});

$('.shownext').click(function(e){var DG=$(this).data('closed');$(DG).hide();$('.subdd').hide('fast');$(this).next().slideToggle('fast');
$('.dropdown-menu.show').removeClass('show');e.stopPropagation();})
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) 
if($(window).width() < 854 ){$('body').click(function(){$('.toplink, .call_dis2').hide()})}
$('.toplink*','.call_dis2*').click(function(e){e.stopPropagation()})

$('.dd_next').click(function(){$(this).next().slideToggle('fast');$(this).toggleClass('dd_next_act');})

$(window).scroll(function(){
if($(this).scrollTop()>0){$('.sticky_header').addClass('h_fixer');}
else{$('.sticky_header').removeClass('h_fixer');}})

$('.vw_more').click(function(){$(this).prev().toggleClass('tm_txt_auto');$(this).toggleClass('course_link_x');var DG = $('a',this).text();
if(DG=='Read Less...'){$('a',this).text('Read More...')}else{$('a',this).text('Read Less...')}return false;})


$('.tabs').click(function(){var dg=$(this).attr('href'); $('.form_box').css({'display':'none'});$(dg).css({'display':'block'}); $('.tabs').removeClass('active'); $(this).addClass('active'); return false}) 

$(".scroll").click(function(event){
event.preventDefault();
$('html,body').animate({scrollTop:$(this.hash).offset().top-85}, 5000);});

$("#back-top").hide();	
$(function () {$(window).scroll(function () {if ($(this).scrollTop() > 100) {$('#back-top').fadeIn();} else {$('#back-top').fadeOut();}});
$('#back-top a').click(function () {$('body,html').animate({scrollTop: 0}, 800);return false;});});

$("#blog_img_scroll").owlCarousel({autoplay:true,dots:true,nav:false,navText:['', '' ],items:1,responsive:{0:{items:1},479:{items:1},767:{items:1},991:{items:1},1200:{items:1}}})


if(Page=='details'){
$("#owl-details").owlCarousel({autoplay:true,dots:false,nav:true,navText: [ '', '' ],items:4,loop:false,rewind:1,rtl:false,autoplayHoverPause:1,responsive:{0:{items:3},400:{items:3},600:{items:5},991:{items:4},1200:{items:5}}});

jQuery(".zoom-gallery .dtl_thmb a").on("click touchend",function(e){var a=jQuery('.active iframe[src*="youtube"]');a.length&&a.attr("src",a.attr("src")),jQuery(".zoom-gallery .zoom-gallery-slide").removeClass("active"),jQuery(".zoom-gallery .dtl_thmb a").removeClass("active"),jQuery('.zoom-gallery .zoom-gallery-slide[data-slide-id="'+jQuery(this).attr("data-slide-id")+'"]').addClass("active"),jQuery(this).addClass("active"),e.preventDefault()});

}

if(Page=='home'){
$(function(){$('#fluid_dg_wrap_1').fluid_dg({thumbnails: false,height:"45.7%",minHeight:'180',fx:'simpleFade,curtainTopLeft,curtainTopRight,curtainBottomLeft',navigationHover:'false',playPause:'false',navigation:'false',loader:'none',hover:'false',time:3000,onLoaded:function(){$('#Page_loader').fadeOut()}});})

$("#pro_scroll").owlCarousel({autoplay:true,dots:false,nav:true,navText:['', '' ],items:3,responsive:{0:{items:1},479:{items:1},767:{items:2},991:{items:2},1200:{items:2}}})

$("#appli_scroll").owlCarousel({autoplay:true,dots:true,nav:false,navText:['', '' ],items:3,responsive:{0:{items:1},479:{items:1},767:{items:2},991:{items:3},1200:{items:3}}})

$("#gal_scroll,#gal_scroll2").owlCarousel({autoplay:false,dots:false,nav:true,navText: [ '', '' ],items:4,responsive:{0:{items:1},600:{items:2},767:{items:2},991:{items:3},1151:{items:2},1279:{items:2}}});



}




});


function lookup(inputString) {
if(inputString.length == 0) {
// Hide the suggestion box.
$('#States_sugg').hide();
$('#suggestions').hide();
} else {
// post data to our php processing page and if there is a return greater than zero
// show the suggestions box
$.post("string_search.php", {mysearchString: ""+inputString+""}, function(data){
if(data.length >0) {
$('#States_sugg').hide();
$('#suggestions').show();
$('#autoSuggestionsList').html(data);
}
});
}
} //end

// if user clicks a suggestion, fill the text box.
function fill(thisValue) {
$('#inputString').val(thisValue);
setTimeout("$('#suggestions').hide();", 200);
}

function lookup_state(inputString) {
if(inputString.length == 0) {
// Hide the suggestion box.
$('#suggestions').hide();
$('#States_sugg').hide();
} else {
// post data to our php processing page and if there is a return greater than zero
// show the suggestions box
$.post("string_search.php", {mysearchString: ""+inputString+""}, function(data){
if(data.length >0) {
$('#suggestions').hide();
$('#States_sugg').show();
$('#autoSuggestionsList_State').html(data);
}
});
}
} //end