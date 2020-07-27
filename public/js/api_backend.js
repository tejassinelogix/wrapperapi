$(document).ready(function () {
    if (
        window.location.href.indexOf("/login") > -1 ||
        window.location.href.indexOf("/register") > -1
    ) {
        //alert("your url contains the name franky");
        $(".login_home").hide();
        $(".logout_home").hide();
    } else {
        $(".default_login").hide();
        $(".default_register").hide();
    }
    // Ajax CSRF Token Setup
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(document).on("submit", "#login_form", function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/auth/login",
            data: { email: $("#email").val(), password: $("#password").val() },
            dataType: "json", // text , XML, HTML
            beforeSend: function () {
                // Before ajax send operation
                // console.log('Before ajax send');
                // var parse_obj = JSON.parse();
            },
            success: function (data_resp, textStatus, jqXHR) {
                // On ajax success operation
                if (data_resp.status) {
                    swal("success", {
                        title: "Login Success!",
                        text: "Login successfully..!",
                        icon: "success",
                        button: false,
                        timer: 3000,
                    });
                    common.setCookie("jwt_token", data_resp.access_token, "2");
                    window.location.href = APP_URL + "/home";
                } else {
                    swal("error", {
                        title: "Login Fail!",
                        text: "Login Fail..!",
                        icon: "error",
                        button: false,
                        timer: 3000,
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                // console.log(textStatus, errorThrown);
            },
            complete: function () {
                // On ajax complete operation
                // console.log('Complete ajax send');
            },
        });
    });

    $(document).on("submit", "#getshippinglinelist_form", function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/shipsgo/shippinglinelist",
            data: { authCode: $("#authcode").val() },
            dataType: "json", // text , XML, HTML
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
            },
            success: function (data_resp, textStatus, jqXHR) {
                // On ajax success operation
                if (data_resp.status) {
                    // swal("success", {
                    //     title: "ShipsGo Response!",
                    //     text: data_resp.data.toString(),
                    //     content: "<h1>test</h1>",
                    //     icon: "success",
                    //     button: "OK",
                    // });
                    var success_head = "";
                    var success_body = "";
                    success_head += '<i class="fa fa-check-circle" aria-hidden="true"></i> Success..!';
                    success_body += 'Shipping Line List get successfully.';
                    $(".modal-header h4").html(success_head);
                    $(".modal-body p").html(data_resp.data);
                    $('.error_modal').trigger('click');
                    // setTimeout(function() { location.reload(); }, 2000);
                    setTimeout(function() { $('.close').trigger('click'); }, 5000);
                } else {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head += '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry, Shipping Line List not get...!';
                    warning_body += 'Shipping Line List not get... Please try after sometime. ';
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(data_resp.message.authCode);
                    $('.error_modal').trigger('click');
                    setTimeout(function() { location.reload(); }, 5000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                // console.log(textStatus, errorThrown);
            },
            complete: function () {
                // On ajax complete operation
                // console.log('Complete ajax send');
            },
        });
    });

    $(document).on("click", ".logout_home", function (e) {
        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/auth/logout",
            data: { authCode: 123 },
            dataType: "json", // text , XML, HTML
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
            },
            success: function (data_resp, textStatus, jqXHR) {
                // On ajax success operation

                if (data_resp.status) {
                    swal("success", {
                        title: "Logout Success!",
                        text: data_resp.message,
                        icon: "success",
                        button: false,
                        timer: 3000,
                    });
                    common.delCookie("jwt_token");
                    window.location.href = APP_URL;
                } else {
                    swal("error", {
                        title: "Logout Fails!",
                        text: "Logout Failed, Please try again..!",
                        icon: "error",
                        button: false,
                        timer: 3000,
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                // console.log(textStatus, errorThrown);
            },
            complete: function () {
                // On ajax complete operation
                // console.log('Complete ajax send');
            },
        });
    });
});
