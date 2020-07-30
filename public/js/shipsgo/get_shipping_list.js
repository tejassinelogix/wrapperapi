$(document).ready(function() {    
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
                console.log('Test :: 1 ::');
                console.log();
                
                $('#loader').show();
                // return false;
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
                $('#loader').hide();
            }
        });
    });
    
    $(document).on("click", ".btn_close, .close", function(e) {
        $('#authcode').val('');
    });

});
