$(document).ready(function() {
  
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

    $(document).on("click", ".btn_close, .close", function(e) {
        $('#authcode').val('');
        $('#requestId').val('');
    });
});
