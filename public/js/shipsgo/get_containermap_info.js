$(document).ready(function() {
    // API 7 : GetContainerMapInfo
    $(document).on("submit", "#getcontainerinfomap_form", function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST", // Default GET
            url: APP_URL + "/api/shipsgo/containerinfomap",
            data: {
                authCode: $("#authcode").val(),
                requestId: $("#requestId").val(),
                mapPoint: $("input[name='mapPoint']:checked").val()
            },
            dataType: "json", // text , XML, HTML
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + common.getCookie("jwt_token")
                );
                $(".response_content").html("");
                $("#loader").show();
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
                    var latitude = null;
                    var longitude = null;
                    $.each(data_resp.data[0], function(key, value) {
                        $(".response_content").append(
                            "<p> " + key + " : " + value + "</p>"
                        );
                        if (key == "VesselLatitude") latitude = value;

                        if (key == "VesselLongitude") longitude = value;
                    });
                    $(".error_modal").trigger("click");
                    
                    if (latitude !== null && latitude !== null) {
                        $(".shipsgo_map").removeClass("d-none");
                        $(".shipsgo_map").append(
                            '<iframe src="https://maps.google.com/maps?q=-26.947375, 47.466742&z=3&output=embed" width="100%" height="500" frameborder="0" style="border:1"></iframe>'
                        );
                    }
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
                $("#loader").hide();
            }
        });
    });

    $(document).on("click", ".btn_close, .close", function(e) {
        $("#authcode").val("");
        $("#requestId").val("");
    });

    // Radio button Gender Starts
    $(document).on("change", "input:radio[name=mapPoint]", function() {
        $("input:radio[name=mapPoint]").removeAttr("checked");
        $(this).prop("checked", true);
        $(this).attr("checked", "checked");
    });
    // Radio button Gender Ends
});
