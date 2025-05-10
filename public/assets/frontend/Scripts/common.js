function scrollNav() {
    $(".nav00 a").click(function() {
        $(".active").removeClass("active"), $(this).closest("li").addClass("active");
        var e = $(this).attr("class");
        return $("." + e).parent("li").addClass("active"), $("html, body").stop().animate({
            scrollTop: $($(this).attr("href")).offset().top - 20
        }, 1200), !1
    }), $(".scrollTop a").scrollTop()
}

function readURL(e) {
    if (e.files && e.files[0]) {
        var t = new FileReader;
        t.onload = function(e) {
            $("#imagePreview").css("background-image", "url(" + e.target.result + ")"), $(".usrImg").hide(), $("#imagePreview").hide(), $("#imagePreview").fadeIn(650);
            var t = document.getElementById("imageUpload").files[0].name,
                i = new FormData,
                a = t.split(".").pop().toLowerCase(); - 1 == jQuery.inArray(a, ["gif", "png", "jpg", "jpeg"]) && alert("Invalid Image File"), new FileReader().readAsDataURL(document.getElementById("imageUpload").files[0]);
            var n = document.getElementById("imageUpload").files[0];
            (n.size || n.fileSize) > 909394 ? alert("Image File Size is very big") : (i.append("file", document.getElementById("imageUpload").files[0]), $.ajax({
                url: site_url + "change_photo.html",
                method: "POST",
                data: i,
                contentType: !1,
                cache: !1,
                processData: !1,
                beforeSend: function() {
                    $("#imagePreview").html("<label class='text-success'>Image Uploading...</label>")
                },
                success: function(e) {
                    alert("Profile photo updated successfully"), location.reload()
                }
            }))
        }, t.readAsDataURL(e.files[0])
    }
}
$(".rotate").click(function() {
    $(this).toggleClass("right")
}), scrollNav(), $(document).ready(function() {
    $(".comment_hide").hide(), $(".comment_hide").each(function(e, t) {
        e < 1 && $(this).show()
    }), $(".comment_hide:hidden").length && $("#more").show(), $(".comment_hide:hidden").length || $("#more").hide()
}), $("#more").on("click", function() {
    $(".comment_hide:hidden").each(function(e, t) {
        e < 1 && $(this).show()
    }), $(".comment_hide:hidden").length || $("#more").hide()
}), $(function() {
    $(".section").hide(), $(".secList").on("click", function() {
        $(".section").not($("." + $(this).attr("id"))).hide(), $("." + $(this).attr("id")).show(1e3)
    })
}), $(".accordion__title.active").next().slideDown(), $(".accordion__title").on("click", function() {
    $(this).hasClass("active") ? $(this).removeClass("active").next().slideUp() : ($(".accordion__title.active").removeClass("active").next(".accordion__body").slideUp(), $(this).addClass("active").next(".accordion__body").slideDown())
}), jQuery(document).ready(function() {
    $(".targetDiv").hide()
}), jQuery(function() {
    jQuery("#showall").click(function() {
        jQuery(".targetDiv").show(".cnt")
    }), jQuery("#hideall").click(function() {
        jQuery(".targetDiv").hide(".cnt")
    }), jQuery(".showSingle").click(function() {
        jQuery(".targetDiv").hide(".cnt"), jQuery("#div" + $(this).attr("target")).slideToggle()
    })
}), $(document).ready(function() {
    $(".tabs a").click(function() {
        $(".panel").hide(), $(".tabs a.active").removeClass("active"), $(this).addClass("active");
        var e = $(this).attr("href");
        return $(e).fadeIn(2e3), !1
    }), $(".tabs li:first a").click()
}), $("#imageUpload").change(function() {
    readURL(this)
}), $(document).on("click", ".toggle", function(e) {
    e.preventDefault();
    var t = $(this).data("target");
    $("#" + t).toggleClass("hide")
}), $(document).ready(function() {
    $(".scroll-top").click(function() {
        return $("html, body").animate({
            scrollTop: 0
        }, "fast"), !1
    })
}), $(document).ready(function() {
    var e;
    $(".slideshow div:gt(0)").hide(), setInterval(function() {
        $(".slideshow > :first-child").fadeOut().next("div").fadeIn().end().appendTo(".slideshow")
    }, 3500), $(".slideshow2 > div:gt(0)").hide(), $(".slideshow2").mouseenter(function() {
        e && clearInterval(e)
    }).mouseleave(function() {
        e = setInterval(function() {
            $(".slideshow2 > div:first").fadeOut(300).next().fadeIn(200).end().appendTo(".slideshow2")
        }, 3300)
    }).mouseleave()
}), $(document).ready(function() {
    var e, t, i, a, n = 1,
        s = $("fieldset").length;

    function o(e) {
        var t = parseFloat(100 / s) * e;
        t = t.toFixed(), $(".progress-bar").css("width", t + "%")
    }
    o(n), $(".next").click(function() {
        e = $(this).parent(), t = $(this).parent().next(), $("#progressbar li").eq($("fieldset").index(t)).addClass("active"), t.show(), e.animate({
            opacity: 0
        }, {
            step: function(i) {
                a = 1 - i, e.css({
                    display: "none",
                    position: "relative"
                }), t.css({
                    opacity: a
                })
            },
            duration: 500
        }), o(++n)
    }), $(".previous").click(function() {
        e = $(this).parent(), i = $(this).parent().prev(), $("#progressbar li").eq($("fieldset").index(e)).removeClass("active"), i.show(), e.animate({
            opacity: 0
        }, {
            step: function(t) {
                a = 1 - t, e.css({
                    display: "none",
                    position: "relative"
                }), i.css({
                    opacity: a
                })
            },
            duration: 500
        }), o(--n)
    }), $(".submit").click(function() {
        return !1
    })
}), $(document).ready(function() {
    $(".text-field-input").on("focus", function() {
        $(this).closest(".field-wrapper").addClass("focused")
    }), $(".text-field-input").on("blur", function() {
        "" === $(this).val() && $(this).closest(".field-wrapper").removeClass("focused")
    })
});
let Buttons = document.querySelectorAll(".selectSection button");
for (let button of Buttons) button.addEventListener("click", e => {
    let t = e.target,
        i = document.querySelector(".active");
    i && i.classList.remove("active"), t.classList.add("active");
    let a = document.querySelectorAll(".content");
    for (let n of a) n.getAttribute("data-number") === button.getAttribute("data-number") ? n.style.display = "block" : n.style.display = "none"
});

function iformat(e, t) {
    var i = e.element,
        a = $(i).data("badge");
    return $('<span><i class="fa ' + $(i).data("icon") + '"></i> ' + e.text + '<span class="badge">' + a + "</span></span>")
}

function executeAutomaticVisibility(e) {
    $("[name=" + e + "]:checked").each(function() {
        $("[showIfIdChecked=" + this.id + "]").show()
    }), $("[name=" + e + "]:not(:checked)").each(function() {
        $("[showIfIdChecked=" + this.id + "]").hide()
    })
}

function autocomplete1(e, t) {
    var i;

    function a(e) {
        if (!e) return !1;
        (function e(t) {
            for (var i = 0; i < t.length; i++) t[i].classList.remove("autocomplete-active1")
        })(e), i >= e.length && (i = 0), i < 0 && (i = e.length - 1), e[i].classList.add("autocomplete-active1")
    }

    function n(t) {
        for (var i = document.getElementsByClassName("autocomplete-items1"), a = 0; a < i.length; a++) t != i[a] && t != e && i[a].parentNode.removeChild(i[a])
    }
    e.addEventListener("input", function(a) {
        var s, o, l, c = this.value;
        if (n(), !c) return !1;
        for (i = -1, (s = document.createElement("DIV")).setAttribute("id", this.id + "autocomplete-list1"), s.setAttribute("class", "autocomplete-items1"), this.parentNode.appendChild(s), l = 0; l < t.length; l++) t[l].substr(0, c.length).toUpperCase() == c.toUpperCase() && ((o = document.createElement("DIV")).innerHTML = "<span>" + t[l].substr(0, c.length) + "</strong>", o.innerHTML += t[l].substr(c.length), o.innerHTML += "<input type='hidden' value='" + t[l] + "'>", o.addEventListener("click", function(t) {
            e.value = this.getElementsByTagName("input")[0].value, n()
        }), s.appendChild(o))
    }), e.addEventListener("keydown", function(e) {
        var t = document.getElementById(this.id + "autocomplete-list1");
        t && (t = t.getElementsByTagName("div")), 40 == e.keyCode ? (i++, a(t)) : 38 == e.keyCode ? (i--, a(t)) : 13 == e.keyCode && (e.preventDefault(), i > -1 && t && t[i].click())
    }), document.addEventListener("click", function(e) {
        n(e.target)
    })
}

function autocomplete2(e, t) {
    var i;

    function a(e) {
        if (!e) return !1;
        (function e(t) {
            for (var i = 0; i < t.length; i++) t[i].classList.remove("autocomplete-active2")
        })(e), i >= e.length && (i = 0), i < 0 && (i = e.length - 1), e[i].classList.add("autocomplete-active2")
    }

    function n(t) {
        for (var i = document.getElementsByClassName("autocomplete-items2"), a = 0; a < i.length; a++) t != i[a] && t != e && i[a].parentNode.removeChild(i[a])
    }
    e.addEventListener("input", function(a) {
        var s, o, l, c = this.value;
        if (n(), !c) return !1;
        for (i = -1, (s = document.createElement("DIV")).setAttribute("id", this.id + "autocomplete-list2"), s.setAttribute("class", "autocomplete-items2"), this.parentNode.appendChild(s), l = 0; l < t.length; l++) t[l].substr(0, c.length).toUpperCase() == c.toUpperCase() && ((o = document.createElement("DIV")).innerHTML = "<span>" + t[l].substr(0, c.length) + "</strong>", o.innerHTML += t[l].substr(c.length), o.innerHTML += "<input type='hidden' value='" + t[l] + "'>", o.addEventListener("click", function(t) {
            e.value = this.getElementsByTagName("input")[0].value, n()
        }), s.appendChild(o))
    }), e.addEventListener("keydown", function(e) {
        var t = document.getElementById(this.id + "autocomplete-list2");
        t && (t = t.getElementsByTagName("div")), 40 == e.keyCode ? (i++, a(t)) : 38 == e.keyCode ? (i--, a(t)) : 13 == e.keyCode && (e.preventDefault(), i > -1 && t && t[i].click())
    }), document.addEventListener("click", function(e) {
        n(e.target)
    })
}
$(".btn00").click(function() {
        "Hide" == $(".btn00").text().trim() && ($(".btn"), $(".myText").hide())
    }), $(document).ready(function() {
        $("ul.tabs_articles li").click(function() {
            var e = $(this).attr("data-tab");
            $("ul.tabs_articles li").removeClass("current"), $(".tab_content_article").removeClass("current"), $(this).addClass("current"), $("#" + e).addClass("current")
        })
    }), $(document).ready(function() {
        triggers = $("[showIfIdChecked]").map(function() {
            return $("#" + $(this).attr("showIfIdChecked")).get()
        }), $.unique(triggers), triggers.each(function() {
            executeAutomaticVisibility(this.name), $(this).change(function() {
                executeAutomaticVisibility(this.name)
            })
        })
    }), dataArr1.length > 0 && autocomplete1(document.getElementById("keyword_imput"), dataArr1), dataArr2.length > 0 && autocomplete2(document.getElementById("locations"), dataArr2), $(document).ready(function() {
        var e = $("#yes").prop("checked");
        e && $("#first").addClass("activeTab"), $("#yes").on("click", function() {
            e = $(this).prop("checked"), $("#second").removeClass("activeTab"), $("#first").addClass("activeTab")
        }), $("#no").on("click", function() {
            e = $(this).prop("checked"), $("#first").removeClass("activeTab"), $("#second").addClass("activeTab"), console.log(e)
        })
    }),
    function(e) {
        "use strict";
        e(".custom-link").click(function() {
            var t, i, a, n = e(this).attr("href"),
                s = e(n),
                o = e(".navbar").height() + 10;
            return t = s, i = o, a = t.offset().top, e("body,html").animate({
                scrollTop: a - i
            }, 300), !1
        })
    }(window.jQuery);
const slides = document.querySelectorAll(".slider-container .slide"),
    eraser = document.querySelector(".eraser"),
    prev = document.getElementById("previous"),
    next = document.getElementById("next"),
    intervalTime = 6e3,
    eraserActiveTime = 500;
let sliderInterval;

function checkemail() {
    var e = $("#emails").val();
    if ($(".demo").hide(), !e) return $("#email_status").html(""), !1;
    $.ajax({
        type: "get",
        url: "<?php echo base_url(); ?>user/check_emailid",
        data: {
            user_email: e
        },
        success: function(e) {
            return ($("#email_status").html(e), "OK" == e) ? ($("#email_status").css({
                color: "green"
            }), $(".hide").removeClass("hide").addClass("show"), $(".demo").show(), $(".sb").show(), !0) : ($(".show").removeClass("show").addClass("hide"), $(".demo").hide(), $(".sb").hide(), !1)
        }
    })
}

function readURL(e) {
    if (e.files && e.files[0]) {
        var t = new FileReader;
        t.onload = function(t) {
            $(".image-upload-wrap").hide(), $(".file-upload-image").attr("src", t.target.result), $(".file-upload-content").show(), $(".image-title").html(e.files[0].name)
        }, t.readAsDataURL(e.files[0])
    } else removeUpload()
}

function removeUpload() {
    $(".file-upload-input").replaceWith($(".file-upload-input").clone()), $(".file-upload-content").hide(), $(".image-upload-wrap").show()
}


function DownloadFile(fileName) {
    //Set the File URL.
    var url = fileName;
    $.ajax({
        url: url,
        cache: false,
        xhr: function () {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 2) {
                    if (xhr.status == 200) {
                        xhr.responseType = "blob";
                    } else {
                        xhr.responseType = "text";
                    }
                }
            };
            return xhr;
        },
        success: function (data) {
            //Convert the Byte Data to BLOB object.
            var blob = new Blob([data], { type: "application/octetstream" });
            //Check the Browser type and download the File.
            var isIE = false || !!document.documentMode;
            if (isIE) {
                window.navigator.msSaveBlob(blob, fileName);
            } else {
                var url = window.URL || window.webkitURL;
                link = url.createObjectURL(blob);
                var a = $("<a />");
                a.attr("download", fileName);
                a.attr("href", link);
                $("body").append(a);
                a[0].click();
                $("body").remove(a);
            }
        }
    });
}

    (jQuery), $(document).ready(function() {
        $(".radioshow").on("change", function() {
            var e = $(this).attr("data-class");
            $(".allshow").hide(), $("." + e).show()
        })
    }), $(document).ready(function() {
        $(".tabs_second li a").click(function() {
            $(".tabs_second li a").removeClass("active"), $(this).addClass("active"), $(".tab_content_container_second > .tab_content_second_active").removeClass("tab_content_active").fadeOut(200), $(this.rel).fadeIn(500).addClass("tab_content_second_active")
        })
    }), $(document).ready(function() {
        $(".tabs li a").click(function() {
            $(".tabs li a").removeClass("active"), $(this).addClass("active"), $(".tab_content_container > .tab_content_active").removeClass("tab_content_active").fadeOut(200), $(this.rel).fadeIn(500).addClass("tab_content_active")
        })
    }), $(document).ready(function() {
        $('[name="graduate"]').change(function() {
            $('[name="graduate"]:checked').is(":checked") ? ($(".ug").hide(), $(".phd").show()) : ($(".ug").show(), $(".phd").hide())
        })
    }), $(document).ready(function() {
        $imgSrc = $("#imgProfile").attr("src"), $("#btnChangePicture").on("click", function() {
            $("#btnChangePicture").hasClass("changing") || $("#profilePicture").click()
        }), $("#profilePicture").on("change", function() {
            (function e(t) {
                if (t.files && t.files[0]) {
                    var i = new FileReader;
                    i.onload = function(e) {
                        $("#imgProfile").attr("src", e.target.result)
                    }, i.readAsDataURL(t.files[0])
                }
            })(this), $("#btnChangePicture").addClass("changing"), $("#btnChangePicture").attr("value", "Confirm"), $("#btnDiscard").removeClass("d-none")
        }), $("#btnDiscard").on("click", function() {
            $("#btnChangePicture").removeClass("changing"), $("#btnChangePicture").attr("value", "Change"), $("#btnDiscard").addClass("d-none"), $("#imgProfile").attr("src", $imgSrc), $("#profilePicture").val("")
        })
    }), $(".image-upload-wrap").bind("dragover", function() {
        $(".image-upload-wrap").addClass("image-dropping")
    }), $(".image-upload-wrap").bind("dragleave", function() {
        $(".image-upload-wrap").removeClass("image-dropping")
    }), $(function() {
        $("#invisible002").click(function() {
            $("#invisible003").toggleClass("show")
        })
    }), $(function() {
        $("#invisible003").click(function() {
            $("#Invisible_boox").toggleClass("show")
        })
    }), $(function() {
        $("#visible").click(function() {
            $("#invisible002").toggleClass("show")
        })
    }), $(function() {
        $("#invisible002").click(function() {
            $("#Invisible_box").toggleClass("show")
        })
    }), $(function() {
        $("#visible").click(function() {
            $("#invisible").toggleClass("show")
        })
    });