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
                    swal("error", {
                        title: "Logout Fails!",
                        text: "Logout Failed, Please try again..!",
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

    // API 1 : GetShippingLineList
    $(document).on("submit", "#getshippinglinelist_form", function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/shipsgo/shippinglinelist",
            data: { authCode: $("#authcode").val() },
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
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> ShipsGo Response, Success..!';
                    success_body += "Shipping Line List get successfully.";
                    $(".modal-header h4").html(success_head);
                    $(".modal-body p").html(data_resp.data.join("</p><p>"));
                    $(".error_modal").trigger("click");
                    // setTimeout(function() { $('.close').trigger('click'); }, 5000);
                } else {
                    var auth_code = jqXHR.responseJSON.message.authCode;
                    var message = "";
                    if (typeof auth_code != "undefined" && auth_code !== null) {
                        message = jqXHR.responseJSON.message.authCode.join(
                            "</p><p>"
                        );
                    } else {
                        message = jqXHR.responseJSON.message;
                    }
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Shipping Line List not get... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                if (jqXHR.responseJSON.status == false) {
                    var auth_code = jqXHR.responseJSON.message.authCode;
                    var message = "";
                    if (typeof auth_code != "undefined" && auth_code !== null) {
                        message = jqXHR.responseJSON.message.authCode.join(
                            "</p><p>"
                        );
                    } else {
                        message = jqXHR.responseJSON.message;
                    }

                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Shipping Line List not get... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            complete: function() {
                // On ajax complete operation
                // console.log('Complete ajax send');
            }
        });
    });

    // API 2 : GetContainerInfo
    $(document).on("submit", "#getcontainerinfo_form", function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/shipsgo/containerinfo",
            data: {
                authCode: $("#authcode").val(),
                requestId: $("#requestId").val()
            },
            dataType: "json", // text , XML, HTML
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
                $(".response_content").html("");
            },
            success: function(data_resp, textStatus, jqXHR) {
                // On ajax success operation

                if (data_resp.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> ShipsGo Response, Success..!';
                    success_body +=
                        "Container Information List get successfully.";
                    $(".modal-header h4").html(success_head);
                    $.each(data_resp.data[0], function(key, value) {
                        $(".response_content").append(
                            "<p> " + key + " : " + value + "</p>"
                        );
                    });
                    $(".error_modal").trigger("click");
                    // setTimeout(function() { $('.close').trigger('click'); }, 3000);
                } else {
                    var auth_code = jqXHR.responseJSON.message.authCode;
                    var message = "";
                    if (typeof auth_code != "undefined" && auth_code !== null) {
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                    } else {
                        message = jqXHR.responseJSON.message;
                    }

                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Container Information List not get... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                var auth_code = jqXHR.responseJSON.message.authCode;
                var message = "";
                if (typeof auth_code != "undefined" && auth_code !== null) {
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                } else {
                    message = jqXHR.responseJSON.message;
                }
                if (jqXHR.responseJSON.status == false) {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Container Information List not get... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            complete: function() {
                // On ajax complete operation
                // console.log('Complete ajax send');
            }
        });
    });

    // API 3 : PostContainerInfo
    $(document).on("submit", "#postcontainerinfo_form", function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/shipsgo/postcontainerinfo",
            data: {
                authCode: $("#authcode").val(),
                containerNumber: $("#containerNumber").val(),
                shippingLine: $("#shippingLine").val()
            },
            dataType: "json", // text , XML, HTML
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
                $(".response_content").html("");
            },
            success: function(data_resp, textStatus, jqXHR) {
                // On ajax success operation
                if (data_resp.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> ShipsGo Response, Success..!';
                    success_body +=
                        "Container Information Post Inserted successfully.";
                    $(".modal-header h4").html(success_head);
                    $.each(data_resp.data, function(key, value) {
                        $(".response_content").append(
                            "<p> " + key + " : " + value + "</p>"
                        );
                    });
                    $(".error_modal").trigger("click");
                    // setTimeout(function() { $('.close').trigger('click'); }, 5000);
                } else {
                    var auth_code = jqXHR.responseJSON.message.authCode;
                    var container_number =
                        jqXHR.responseJSON.message.containerNumber;
                    var message = "";
                    if (
                        typeof auth_code != "undefined" &&
                        auth_code !== null &&
                        typeof container_number != "undefined" &&
                        container_number !== null
                    ) {
                        // Auth Code and Container Number are error
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                        message += jqXHR.responseJSON.message.containerNumber.join(
                            "<p></p>"
                        );
                    } else if (
                        typeof auth_code != "undefined" &&
                        auth_code !== null &&
                        typeof container_number == "undefined" &&
                        container_number == null
                    ) {
                        // auth_code is error
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                    } else if (
                        typeof auth_code == "undefined" &&
                        auth_code == null &&
                        typeof container_number != "undefined" &&
                        container_number !== null
                    ) {
                        // Container Number is error
                        message = jqXHR.responseJSON.message.containerNumber.join(
                            "<p></p>"
                        );
                    } else {
                        message = jqXHR.responseJSON.message;
                    }

                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Container Information not Inserted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                var auth_code = jqXHR.responseJSON.message.authCode;
                var container_number =
                    jqXHR.responseJSON.message.containerNumber;
                var message = "";
                if (
                    typeof auth_code != "undefined" &&
                    auth_code !== null &&
                    typeof container_number != "undefined" &&
                    container_number !== null
                ) {
                    // Auth Code and Container Number are error
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                    message += jqXHR.responseJSON.message.containerNumber.join(
                        "<p></p>"
                    );
                } else if (
                    typeof auth_code != "undefined" &&
                    auth_code !== null &&
                    typeof container_number == "undefined" &&
                    container_number == null
                ) {
                    // auth_code is error
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                } else if (
                    typeof auth_code == "undefined" &&
                    auth_code == null &&
                    typeof container_number != "undefined" &&
                    container_number !== null
                ) {
                    // Container Number is error
                    message = jqXHR.responseJSON.message.containerNumber.join(
                        "<p></p>"
                    );
                } else {
                    message = jqXHR.responseJSON.message;
                }

                if (jqXHR.responseJSON.status == false) {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Container Information not Inserted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            complete: function() {
                // On ajax complete operation
                // console.log('Complete ajax send');
            }
        });
    });

    // API 4 : PostCustomContainerForm
    $(document).on("submit", "#postcustomcontainerinfo_form", function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/shipsgo/postcustomcontainerinfo",
            data: {
                authCode: $("#authcode").val(),
                containerNumber: $("#containerNumber").val(),
                emailAddress: $("#emailAddress").val(),
                referenceNo: $("#referenceNo").val(),
                shippingLine: $("#shippingLine").val()
            },
            dataType: "json", // text , XML, HTML
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
                $(".response_content").html("");
            },
            success: function(data_resp, textStatus, jqXHR) {
                // On ajax success operation
                if (data_resp.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> ShipsGo Response, Success..!';
                    success_body +=
                        "Custom Container Information Post Inserted successfully.";
                    $(".modal-header h4").html(success_head);
                    $.each(data_resp.data, function(key, value) {
                        $(".response_content").append(
                            "<p> " + key + " : " + value + "</p>"
                        );
                    });
                    $(".error_modal").trigger("click");
                    // setTimeout(function() { $('.close').trigger('click'); }, 5000);
                } else {
                    var auth_code = jqXHR.responseJSON.message.authCode;
                    var container_number =
                        jqXHR.responseJSON.message.containerNumber;
                    var message = "";
                    if (
                        typeof auth_code != "undefined" &&
                        auth_code !== null &&
                        typeof container_number != "undefined" &&
                        container_number !== null
                    ) {
                        // Auth Code and Container Number are error
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                        message += jqXHR.responseJSON.message.containerNumber.join(
                            "<p></p>"
                        );
                    } else if (
                        typeof auth_code != "undefined" &&
                        auth_code !== null &&
                        typeof container_number == "undefined" &&
                        container_number == null
                    ) {
                        // auth_code is error
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                    } else if (
                        typeof auth_code == "undefined" &&
                        auth_code == null &&
                        typeof container_number != "undefined" &&
                        container_number !== null
                    ) {
                        // Container Number is error
                        message = jqXHR.responseJSON.message.containerNumber.join(
                            "<p></p>"
                        );
                    } else {
                        message = jqXHR.responseJSON.message;
                    }

                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Custom Container Information not Inserted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // On ajax error operation

                var auth_code = jqXHR.responseJSON.message.authCode;
                var container_number =
                    jqXHR.responseJSON.message.containerNumber;
                var message = "";
                if (
                    typeof auth_code != "undefined" &&
                    auth_code !== null &&
                    typeof container_number != "undefined" &&
                    container_number !== null
                ) {
                    // Auth Code and Container Number are error
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                    message += jqXHR.responseJSON.message.containerNumber.join(
                        "<p></p>"
                    );
                } else if (
                    typeof auth_code != "undefined" &&
                    auth_code !== null &&
                    typeof container_number == "undefined" &&
                    container_number == null
                ) {
                    // auth_code is error
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                } else if (
                    typeof auth_code == "undefined" &&
                    auth_code == null &&
                    typeof container_number != "undefined" &&
                    container_number !== null
                ) {
                    // Container Number is error
                    message = jqXHR.responseJSON.message.containerNumber.join(
                        "<p></p>"
                    );
                } else {
                    message = jqXHR.responseJSON.message;
                }

                if (jqXHR.responseJSON.status == false) {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Custom Container Information not Inserted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            complete: function() {
                // On ajax complete operation
                // console.log('Complete ajax send');
            }
        });
    });

    // API 5 : PostContainerInfoWithBl
    $(document).on("submit", "#postcontainerinfobi_form", function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/shipsgo/postcontainerinfobi",
            data: {
                authCode: $("#authcode").val(),
                containerNumber: $("#containerNumber").val(),
                containersCount: $("#containersCount").val(),
                blContainersRef: $("#blContainersRef").val(),
                shippingLine: $("#shippingLine").val()
            },
            dataType: "json", // text , XML, HTML
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
                $(".response_content").html("");
            },
            success: function(data_resp, textStatus, jqXHR) {
                // On ajax success operation
                if (data_resp.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> ShipsGo Response, Success..!';
                    success_body +=
                        "Container Information Post With BI Inserted successfully.";
                    $(".modal-header h4").html(success_head);
                    $.each(data_resp.data, function(key, value) {
                        $(".response_content").append(
                            "<p> " + key + " : " + value + "</p>"
                        );
                    });
                    $(".error_modal").trigger("click");
                    // setTimeout(function() { $('.close').trigger('click'); }, 5000);
                } else {
                    var auth_code = jqXHR.responseJSON.message.authCode;
                    var container_number =
                        jqXHR.responseJSON.message.containerNumber;
                    var message = "";
                    if (
                        typeof auth_code != "undefined" &&
                        auth_code !== null &&
                        typeof container_number != "undefined" &&
                        container_number !== null
                    ) {
                        // Auth Code and Container Number are error
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                        message += jqXHR.responseJSON.message.containerNumber.join(
                            "<p></p>"
                        );
                    } else if (
                        typeof auth_code != "undefined" &&
                        auth_code !== null &&
                        typeof container_number == "undefined" &&
                        container_number == null
                    ) {
                        // auth_code is error
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                    } else if (
                        typeof auth_code == "undefined" &&
                        auth_code == null &&
                        typeof container_number != "undefined" &&
                        container_number !== null
                    ) {
                        // Container Number is error
                        message = jqXHR.responseJSON.message.containerNumber.join(
                            "<p></p>"
                        );
                    } else {
                        message = jqXHR.responseJSON.message;
                    }

                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Container Information With BI Post not Inserted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                var auth_code = jqXHR.responseJSON.message.authCode;
                var container_number =
                    jqXHR.responseJSON.message.containerNumber;
                var message = "";
                if (
                    typeof auth_code != "undefined" &&
                    auth_code !== null &&
                    typeof container_number != "undefined" &&
                    container_number !== null
                ) {
                    // Auth Code and Container Number are error
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                    message += jqXHR.responseJSON.message.containerNumber.join(
                        "<p></p>"
                    );
                } else if (
                    typeof auth_code != "undefined" &&
                    auth_code !== null &&
                    typeof container_number == "undefined" &&
                    container_number == null
                ) {
                    // auth_code is error
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                } else if (
                    typeof auth_code == "undefined" &&
                    auth_code == null &&
                    typeof container_number != "undefined" &&
                    container_number !== null
                ) {
                    // Container Number is error
                    message = jqXHR.responseJSON.message.containerNumber.join(
                        "<p></p>"
                    );
                } else {
                    message = jqXHR.responseJSON.message;
                }

                if (jqXHR.responseJSON.status == false) {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Container Information With BI Post not Inserted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            complete: function() {
                // On ajax complete operation
                // console.log('Complete ajax send');
            }
        });
    });

    // API 6 : PostContainerInfoWithBl
    $(document).on("submit", "#postcustomcontainerinfobi_form", function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/shipsgo/postcustomcontainerinfobi",
            data: {
                authCode: $("#authcode").val(),
                containerNumber: $("#containerNumber").val(),
                containersCount: $("#containersCount").val(),
                emailAddress: $("#emailAddress").val(),
                referenceNo: $("#referenceNo").val(),
                blContainersRef: $("#blContainersRef").val(),
                shippingLine: $("#shippingLine").val()
            },
            dataType: "json", // text , XML, HTML
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
                $(".response_content").html("");
            },
            success: function(data_resp, textStatus, jqXHR) {
                // On ajax success operation
                if (data_resp.status) {
                    var success_head = "";
                    var success_body = "";
                    success_head +=
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> ShipsGo Response, Success..!';
                    success_body +=
                        "Custom Container Information Post With BI Inserted successfully.";
                    $(".modal-header h4").html(success_head);
                    $.each(data_resp.data, function(key, value) {
                        $(".response_content").append(
                            "<p> " + key + " : " + value + "</p>"
                        );
                    });
                    $(".error_modal").trigger("click");
                    // setTimeout(function() { $('.close').trigger('click'); }, 5000);
                } else {
                    var auth_code = jqXHR.responseJSON.message.authCode;
                    var container_number =
                        jqXHR.responseJSON.message.containerNumber;
                    var message = "";
                    if (
                        typeof auth_code != "undefined" &&
                        auth_code !== null &&
                        typeof container_number != "undefined" &&
                        container_number !== null
                    ) {
                        // Auth Code and Container Number are error
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                        message += jqXHR.responseJSON.message.containerNumber.join(
                            "<p></p>"
                        );
                    } else if (
                        typeof auth_code != "undefined" &&
                        auth_code !== null &&
                        typeof container_number == "undefined" &&
                        container_number == null
                    ) {
                        // auth_code is error
                        message = jqXHR.responseJSON.message.authCode.join(
                            "<p></p>"
                        );
                    } else if (
                        typeof auth_code == "undefined" &&
                        auth_code == null &&
                        typeof container_number != "undefined" &&
                        container_number !== null
                    ) {
                        // Container Number is error
                        message = jqXHR.responseJSON.message.containerNumber.join(
                            "<p></p>"
                        );
                    } else {
                        message = jqXHR.responseJSON.message;
                    }

                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Custom Container Information With BI Post not Inserted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // On ajax error operation
                var auth_code = jqXHR.responseJSON.message.authCode;
                var container_number =
                    jqXHR.responseJSON.message.containerNumber;
                var message = "";
                if (
                    typeof auth_code != "undefined" &&
                    auth_code !== null &&
                    typeof container_number != "undefined" &&
                    container_number !== null
                ) {
                    // Auth Code and Container Number are error
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                    message += jqXHR.responseJSON.message.containerNumber.join(
                        "<p></p>"
                    );
                } else if (
                    typeof auth_code != "undefined" &&
                    auth_code !== null &&
                    typeof container_number == "undefined" &&
                    container_number == null
                ) {
                    // auth_code is error
                    message = jqXHR.responseJSON.message.authCode.join(
                        "<p></p>"
                    );
                } else if (
                    typeof auth_code == "undefined" &&
                    auth_code == null &&
                    typeof container_number != "undefined" &&
                    container_number !== null
                ) {
                    // Container Number is error
                    message = jqXHR.responseJSON.message.containerNumber.join(
                        "<p></p>"
                    );
                } else {
                    message = jqXHR.responseJSON.message;
                }

                if (jqXHR.responseJSON.status == false) {
                    var warning_head = "";
                    var warning_body = "";
                    warning_head +=
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ShipsGo Response, Fail...!';
                    warning_body +=
                        "Custom Container Information With BI Post not Inserted... Please try after sometime. ";
                    $(".modal-header h4").html(warning_head);
                    $(".modal-body p").html(message);
                    $(".error_modal").trigger("click");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            complete: function() {
                // On ajax complete operation
                // console.log('Complete ajax send');
            }
        });
    });
});
