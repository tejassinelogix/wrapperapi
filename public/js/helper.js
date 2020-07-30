$(document).ready(function() {
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
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

     // Login Ajax JWT
     $(document).on("submit", "#login_form", function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/auth/login",
            data: { email: $("#email").val(), password: $("#password").val() },
            dataType: "json", // text , XML, HTML
            beforeSend: function() {
                // Before ajax send operation
                // console.log('Before ajax send');
                // var parse_obj = JSON.parse();
            },
            success: function(data_resp, textStatus, jqXHR) {
                // On ajax success operation
                if (data_resp.status) {
                    swal("success", {
                        title: "Login Success!",
                        text: "Login successfully..!",
                        icon: "success",
                        button: false,
                        timer: 3000
                    });
                    common.setCookie("jwt_token", data_resp.access_token, "2");
                    window.location.href = APP_URL + "/home";
                } else {
                    swal("error", {
                        title: "Login Fail!",
                        text: "Login Fail..!",
                        icon: "error",
                        button: false,
                        timer: 3000
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                // console.log(textStatus, errorThrown);
            },
            complete: function() {
                // On ajax complete operation
                // console.log('Complete ajax send');
            }
        });
    });

     // Logout Ajax JWT
     $(document).on("click", ".logout_home", function(e) {
        logout();
    });

     // Refresh Ajax JWT
    $(document).on("click", ".refresh", function(e) {
        refresh_me();
    });

    function refresh_me(){
        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/auth/refresh",
            data: { authCode: 123 },
            dataType: "json", // text , XML, HTML
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
            },
            success: function(data_resp, textStatus, jqXHR) {
                // On ajax success operation
                if (data_resp.status) {
                    logout();
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {                
            },
            complete: function() {
            }
        });
    }

    function logout(){
        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/auth/logout",
            data: { authCode: 123 },
            dataType: "json", // text , XML, HTML
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
            },
            success: function(data_resp, textStatus, jqXHR) {
                // On ajax success operation

                if (data_resp.status) {
                    swal("success", {
                        title: "Logout Success!",
                        text: data_resp.message,
                        icon: "success",
                        button: false,
                        timer: 3000
                    });
                    common.delCookie("jwt_token");
                    window.location.href = APP_URL;
                } else {
                    refresh_me();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                refresh_me();
            },
            complete: function() {
            }
        });
    }
});
