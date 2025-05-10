function getStates(e) {
    
    var s = $("#country").val();
    "" != s
        ? $.ajax({
              url: site_url + "fetch_state.html",
              method: "POST",
              data: { country_id: s },
              success: function (e) {
               
                  $("#state").html(e), 
                  $("#city").html('<option value="">Select City</option>');
              },
          })
        : ($("#state").html('<option value="">Select State</option>'), $("#city").html('<option value="">Select City</option>'));
}
function getCity(e) {
    var s = $("#state").val();
    "" != s
        ? $.ajax({
              url: site_url + "fetch_city.html",
              method: "POST",
              data: { state_id: s, job_location_id: "" },
              success: function (e) {
                
                 $("#city").html(e);
              },
          })
        : $("city").html('<option value="">Select City</option>');
}
$(document).ready(function () {
    $("#user_total_year_exp").on("change", function () {
        $(".view").hide(), $("#collapseTwo").show(), $("#user_total_year_exp").val() > 0 && ($("#experience_messg").text(""), $(".view").show(), $("#collapseTwo").show());
    }),
        $("#formData1").show(),
        $("#formData2").hide(),
        $("#next1").click(function (e) {
            var s = $("#username").val(),
                t = $("#useremail").val(),
                a = $("#userpassword").val(),
                o = $("#usermobile").val(),
                r = $("#country").val(),
                i = $("#state").val(),
                c = $("#city").val(),
                l = $("#userbirthDate").val(),
                n = $("#usergender").val(),
                u = $("#keywords").val(),
                m = $("#userprofileheadline").val(),
                g = $("#userfunctionalarea").val(),
                d = $("#user_total_year_exp").val();
            return "" == s
                ? ($("#user_messg").show(), $("#user_messg").text("Please Enter Name"), $("#user_messg").css("color", "red"), $("#username").focus(), !1)
                : ("" != s && ($("#user_messg").hide(), $("#user_messg").text("")), "" == t)
                ? ($("#user_email").show(), $("#email_messg").text("Please Enter Email"), $("#email_messg").css("color", "red"), !1)
                : ("" != t && ($("#email_messg").hide(), $("#email_messg").text("")), "" == a)
                ? ($("#password_messg").show(), $("#password_messg").text("Please Enter Password"), $("#password_messg").css("color", "red"), $("#userpassword").focus(), !1)
                : ("" != a && ($("#password_messg").hide(), $("#password_messg").text("")), "" == o)
                ? ($("#mobile_messg").show(), $("#mobile_messg").text("Please Enter Mobile"), $("#mobile_messg").css("color", "red"), $("#usermobile").focus(), !1)
                : ("" != o && ($("#mobile_messg").hide(), $("#mobile_messg").text("")), "" == l)
                ? ($("#dob_messg").show(), $("#dob_messg").text("Please Enter Date of birth"), $("#dob_messg").css("color", "red"), $("#userbirthDate").focus(), !1)
                : ("" != l && ($("#dob_messg").hide(), $("#dob_messg").text("")), "" == n)
                ? ($("#gender_messg").show(), $("#gender_messg").text("Please Select Gender"), $("#gender_messg").css("color", "red"), $("#usergender").focus(), !1)
                : ("" != n && ($("#gender_messg").hide(), $("#gender_messg").text("")), "" == r)
                ? ($("#country_messg").show(), $("#country_messg").text("Please Select Country"), $("#country_messg").css("color", "red"), $("#country").focus(), !1)
                : "" == i
                ? ($("#statep_messg").show(), $("#statep_messg").text("Please Select State"), $("#statep_messg").css("color", "red"), $("#state").focus(), !1)
                : ("" != i && ($("#statep_messg").hide(), $("#statep_messg").text("")), "" == c)
                ? ($("#cityp_messg").show(), $("#cityp_messg").text("Please Select City"), $("#cityp_messg").css("color", "red"), $("#city").focus(), !1)
                : ("" != c && ($("#cityp_messg").hide(), $("#cityp_messg").text("")), "" == u)
                ? ($("#keywordsP_messg").show(), $("#keywordsP_messg").text("Please Enter Skill"), $("#keywordsP_messg").css("color", "red"), $("#keywords").focus(), !1)
                : ("" != u && ($("#keywordsP_messg").hide(), $("#keywordsP_messg").text("")), "" == m)
                ? ($("#headline_messg").show(), $("#headline_messg").text("Please Enter Headline"), $("#headline_messg").css("color", "red"), $("#headline_messg").focus(), !1)
                : ("" != m && ($("#headline_messg").hide(), $("#headline_messg").text("")), "" == g)
                ? ($("#function_messg").show(), $("#function_messg").text("Please Enter Headline"), $("#function_messg").css("color", "red"), $("#userfunctionalarea").focus(), !1)
                : ("" != g && ($("#function_messg").hide(), $("#function_messg").text("")), "" == d)
                ? ($("#experience_messg").show(), $("#experience_messg").text("Please Select Experience"), $("#experience_messg").css("color", "red"), $("#user_total_year_exp").focus(), !1)
                : void ("" != d && ($("#experience_messg").hide(), $("#experience_messg").text("")), 0 == d ? ($("#formData1").hide(), $("#formData3").show()) : ($("#formData1").hide(), $("#formData2").show()));
        }),
        $("#next2").click(function (e) {
            if ($("#user_total_year_exp").val() > 0) {
                var s = $("#current_degination").val(),
                    t = $("#current_company_name").val(),
                    a = $("#current_annual_salary").val(),
                    o = $("#current_work_time").val(),
                    r = $("#current_notice_p").val();
                if ("" == s) return $("#current_function_messg").show(), $("#current_function_messg").text("Please Enter Designation"), $("#current_function_messg").css("color", "red"), $("#current_degination").focus(), !1;
                if ("" == t) return $("#companyname_messg").show(), $("#companyname_messg").text("Please Enter Company"), $("#companyname_messg").css("color", "red"), $("#current_company_name").focus(), !1;
                if ("" == a) return $("#lacks_messg").show(), $("#lacks_messg").text("Please Enter Annual Salary in Lakh"), $("#lacks_messg").css("color", "red"), $("#current_annual_salary").focus(), !1;
                if ("" == o) return $("#working_messg").show(), $("#working_messg").text("Please Enter Annual Salary in Lakh"), $("#working_messg").css("color", "red"), $("#current_work_time").focus(), !1;
                if ("" == r) return $("#notice_messg").show(), $("#notice_messg").text("Please Enter Notice Period"), $("#notice_messg").css("color", "red"), $("#current_notice_p").focus(), !1;
            }
            $("#formData1").hide(), $("#formData2").hide(), $("#formData3").show();
        }),
        $("#next3").click(function (e) {
            var s = $("#ugQual").val();
            $("#ug_specialisation").val();
            var t = $("#ug_university").val(),
                a = $("#ug_course_type").val(),
                o = $("#ug_pass_year").val();
            return ($("#user_total_year_exp").val(), 0 == s)
                ? ($("#ug_messg").show(), $("#ug_messg").text("Please Select UG Qualification"), $("#ug_messg").css("color", "red"), $("#ugQual").focus(), !1)
                : "" == t
                ? ($("#ug_university_messg").show(), $("#ug_university_messg").text("Please Select UG University"), $("#ug_university_messg").css("color", "red"), $("#ug_university").focus(), !1)
                : "" == a
                ? ($("#ug_course_type_messg").show(), $("#ug_course_type_messg").text("Please Select Course Type"), $("#ug_course_type_messg").css("color", "red"), $("#ug_course_type").focus(), !1)
                : "" == o
                ? ($("#ug_pass_year_messg").show(), $("#ug_pass_year_messg").text("Please Select Course Type"), $("#ug_pass_year_messg").css("color", "red"), $("#ug_pass_year").focus(), !1)
                : void $("#registration_apply").submit();
        }),
        $("#previous1").click(function (e) {
            $("#formData1").show(), $("#formData2").hide();
        }),
        $("#previous2").click(function (e) {
            0 == $("#user_total_year_exp").val() ? ($("#formData1").show(), $("#formData3").hide(), $("#formData2").hide()) : ($("#formData2").show(), $("#formData3").hide(), $("#formData1").hide());
        }),
        $("#user_total_year_exp").on("change", function () {
            $(".view").hide(), $("#collapseTwo").show(), $("#user_total_year_exp").val() > 0 && ($("#experience_messg").text(""), $(".view").show(), $("#collapseTwo").show());
        }),
        $("#ugQual").change(function () {
            var e = $("#ugQual").val();
            "" != e
                ? $.ajax({
                      url: site_url + "job_ug_specialisation.html",
                      method: "POST",
                      data: { ug_id: e },
                      success: function (e) {
						  					  
						  $("#ug_specialisation2").hide();
						  $("#ug_specialisation").show();
                          $("#ug_specialisation").html(e);
                      },
                  })
                : $("#ug_specialisation").html('<option value="">Any Specialization</option>');
        }),
        $("#docQual").change(function () {
            var e = $("#docQual").val();
            "" != e
                ? $.ajax({
                      url: site_url + "job_doctorate_specialisation.html",
                      method: "POST",
                      data: { doc_id: e },
                      success: function (e) {
                        $("#docPhdSpec2").hide();
                        $("#docPhdSpec").show();
                       $("#docPhdSpec").html(e);
                      },
                  })
                : $("#docPhdSpec").html('<option value="">Select Doctorate/Ph.D specialisation</option>');
        }),
        $("#pgQual").change(function () {
            var e = $("#pgQual").val();
            "" != e
                ? $.ajax({
                      url: site_url + "job_pg_specialisation.html",
                      method: "POST",
                      data: { pg_id: e },
                      success: function (e) {
                        $("#pg_specialisation2").hide();
                        $("#pg_specialisation").show();
                        $("#pg_specialisation").html(e);
                      },
                  })
                : $("#pg_specialisation").html('<option value="">Select Pg specialisation</option>');
        }),
        $("#useremail").keyup(function () {
            $.ajax({
                type: "POST",
                url: site_url + "email_validation.html",
                data: { useremail: $("#useremail").val() },
                success: function (e) {
                    return "alreadyExist" == e ? ($("#email_messg").show(), $("#email_messg").text("Email already exist"), $("#email_messg").css("color", "red"), !1) : ($("#email_messg").text(""), $("#email_messg").css("color", ""), !0);
                },
            });
        });
}),
    $(function () {
        getStates($("#country").val()), $("select#country").change(getStates);
        
    }),
    $(function () {
        getCity($("#state").val()), $("select#state").change(getCity);
    });
