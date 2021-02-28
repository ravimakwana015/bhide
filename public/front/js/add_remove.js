function addRemoveGate(route) {
    $.ajax({
        type: "get",
        url: route,
        dataType: "json",
        success: function(res) {
            $("#gates").html("");
            var gates = "";
            $.each(res.gates, function(index, value) {
                gates = "<tr><td>" + value.name + "</td></tr>";
                $("#gates").append(gates);
            });
            $("#addRemoveGate").modal("show");
        }
    });
}
function addGate(route) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: route,
        type: "post",
        data: $("#add_gate_form").serialize(),
        dataType: "json",
        success: function(res) {
            var gate = "<tr><td>" + res.gate.name + "</td></tr>";
            $("#new_gate").append(
                '<input type="radio" name="gate_id" value="' +
                    res.gate.id +
                    '" /> ' +
                    res.gate.name +
                    ""
            );
            $("#gates").append(gate);
            $("#add_gate_form").reset();
        }
    });
}
function addRemoveReason(route) {
    $.ajax({
        type: "get",
        url: route,
        dataType: "json",
        success: function(res) {
            $("#reasons").html("");
            var reasons = "";
            $.each(res.reasons, function(index, value) {
                reasons = "<tr><td>" + value.reason + "</td></tr>";
                $("#reasons").append(reasons);
            });
            $("#addRemoveReason").modal("show");
        }
    });
}
function addReason(route) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: route,
        type: "post",
        data: $("#add_reason_form").serialize(),
        dataType: "json",
        success: function(res) {
            var reason = "<tr><td>" + res.reason.reason + "</td></tr>";
            $("#reason_select").append(
                '<option value="' +
                    res.reason.id +
                    '">' +
                    res.reason.reason +
                    "</option>"
            );
            $("#reasons").append(reason);
            $("#add_reason_form").reset();
        }
    });
}

function visitorCheckOutModal(visitor_id, route) {
    $("#loading").show();
    $("#checkout_form").trigger("reset");
    $(".error_msg").remove();
    $("#checkout_btn").attr("onclick", "visitorCheck(" + visitor_id + ")");
    $("#visitorCheckoutReason").modal("show");
    var options = {
        title: "Check In Time",
        twentyFour: true
    };
    $(".timepicker").wickedpicker(options);
    $(".datetimepicker").datepicker({
        format: "DD/MM/YYYY",
        autoHide: true,
        endDate: new Date()
    });
    $(".wickedpicker").css("z-index", "1151");
    setTimeout(function() {
        $(".datepicker-container").css("z-index", "1151 !important");
    }, 300);
    $("#loading").hide();
}

function visitorCheck(visitor_id) {
    $("#loading").show();
    var route = $("#visitorCheckBtn").data("url");
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: route,
        type: "post",
        data: $("#checkout_form").serialize() + "&" + "id=" + visitor_id,
        dataType: "json",
        success: function(res) {
            $("#loading").hide();
            $(".msg").html(
                '<div class="alert alert-success">' + res.msg + "</div>"
            );
            $("#visitors")
                .DataTable()
                .draw();
            $("#checkout_form").trigger("reset");
            setTimeout(() => {
                $("#visitorCheckoutReason").modal("hide");
            }, 1000);
        },
        error: function(err) {
            $("#loading").hide();
            if (err.status == 422) {
                $.each(err.responseJSON.errors, function(i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    $(".error_msg").remove();
                    el.after(
                        $(
                            '<span style="color: red;" class="error_msg">' +
                                error[0] +
                                "</span>"
                        )
                    );
                });
            }
        }
    });
}
function addService(route, form_id, table_id, modal_id) {
    $("#loading").show();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: route,
        type: "post",
        data: $("#" + form_id).serialize(),
        dataType: "json",
        success: function(res) {
            $("#loading").hide();
            $(".msg").html(
                '<div class="alert alert-success">' + res.msg + "</div>"
            );
            $("#" + table_id)
                .DataTable()
                .draw();
            $("#" + form_id).trigger("reset");
            setTimeout(() => {
                $("#" + modal_id).modal("hide");
            }, 1000);
        },
        error: function(err) {
            $("#loading").hide();
            if (err.status == 422) {
                $(".validation_msg").remove();
                $.each(err.responseJSON.errors, function(i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    if (i == "status") {
                        $(".error_msg").html(
                            '<span style="color: red;">' + error[0] + "</span>"
                        );
                    } else {
                        el.after(
                            $(
                                '<span style="color: red;" class="validation_msg">' +
                                    error[0] +
                                    "</span>"
                            )
                        );
                    }
                });
            }
        }
    });
}
function addWithImage(route, form_id, table_id, modal_id, form) {
    $("#loading").show();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: route,
        type: "post",
        data: form,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(res) {
            $("#loading").hide();
            $(".msg").html(
                '<div class="alert alert-success">' + res.msg + "</div>"
            );
            $("#" + table_id)
                .DataTable()
                .draw();
            $("#" + form_id).trigger("reset");
            setTimeout(() => {
                $("#" + modal_id).modal("hide");
            }, 1000);
        },
        error: function(err) {
            $("#loading").hide();
            if (err.status == 422) {
                $(".validation_msg").remove();
                $.each(err.responseJSON.errors, function(i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    if (i == "status") {
                        $(".error_msg").html(
                            '<span style="color: red;">' + error[0] + "</span>"
                        );
                    } else {
                        el.after(
                            $(
                                '<span style="color: red;" class="validation_msg">' +
                                    error[0] +
                                    "</span>"
                            )
                        );
                    }
                });
            }
        }
    });
}

function editPopup(id) {
    $("#loading").show();
    $.ajax({
        url: $("#edit_" + id).data("url"),
        type: "get",
        dataType: "json",
        success: function(res) {
            $("#loading").hide();
            $("#edit_modal_content").html(res.html);
            $("#editService").modal("show");
        }
    });
}
