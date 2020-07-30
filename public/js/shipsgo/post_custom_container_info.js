$(document).ready(function() {
    
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

    $(document).on("click", ".btn_close, .close", function(e) {
        $('#authcode').val('');
        $('#containerNumber').val('');
        $('#shippingLine').val('');
        $('#emailAddress').val('');
        $('#referenceNo').val('');
    });
});
