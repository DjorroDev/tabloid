// SUBMIT FORM
$(document).ready(function () {
    $("#form-common").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var btn = $("#" + $(this).attr("data-button-submit"));
        var htmlBtn = btn.text();
        $.ajax({
            url: $(this).attr("url"),
            data: formData,
            type: "POST",
            processData: false,
            dataType: "json",
            cache: false,
            contentType: false,
            beforeSend: function () {
                btn.attr("type", "button");
                btn.html("Loading...");
                // btn.html(
                //     '<span style="padding-right:15px">Loading...</span> <img src="' +
                //         _BASE_ASSET +
                //         'images/loading-white.gif" style="width: 30px;position: absolute;right: 10px;" alt="">'
                // );
            },
            complete: function () {
                btn.attr("type", "submit");
                btn.html(htmlBtn);
            },
            success: function (response) {
                $(".form-group").removeClass("has-error");
                $(".text-danger").remove();
                if (response.error === true) {
                    if (response.validation === true) {
                        for (i in response.message) {
                            $("input[name='" + i + "']")
                                .closest(".form-group")
                                .addClass("has-error");
                            $("input[name='" + i + "']").after(
                                '<small class="text-danger"><i>' +
                                    response.message[i] +
                                    "</i></small>"
                            );
                            $("textarea[name='" + i + "']")
                                .closest(".form-group")
                                .addClass("has-error");
                            $("textarea[name='" + i + "']").after(
                                '<small class="text-danger"><i>' +
                                    response.message[i] +
                                    "</i></small>"
                            );
                            $("select[name='" + i + "']")
                                .closest(".form-group")
                                .addClass("has-error");
                            $("select[name='" + i + "']").after(
                                '<small class="text-danger"><i>' +
                                    response.message[i] +
                                    "</i></small>"
                            );
                        }
                    } else {
                        swal("Error", response.message, "error");
                    }
                } else {
                    swal("Berhasil", response.message, "success").then(
                        (x) => {
                            window.location.href = response.redirect;
                        }
                    );
                }
            },
            error: function (response) {
                btn.attr("type", "submit");
                btn.html(htmlBtn);
                swal("Error", "Terjadi kesalahan", "error");
            },
        });
    });
    $("#form-common-contain-array").on("submit", function (e) {
        e.preventDefault();
        const redirectAfterSubmit = $(this).attr("data-redirect-after-submit");
        var formData = new FormData(this);
        var btn = $("#" + $(this).attr("data-button-submit"));
        var htmlBtn = btn.text();
        $.ajax({
            url: $(this).attr("url"),
            data: formData,
            type: "POST",
            processData: false,
            dataType: "json",
            cache: false,
            contentType: false,
            beforeSend: function () {
                btn.attr("type", "button");
                btn.html("Loading...");
                // btn.html(
                //     '<span style="padding-right:15px">Loading...</span> <img src="' +
                //         _BASE_ASSET +
                //         'images/loading-white.gif" style="width: 30px;position: absolute;right: 10px;" alt="">'
                // );
            },
            complete: function () {
                btn.attr("type", "submit");
                btn.html(htmlBtn);
            },
            success: function (response) {
                $(".accordion-button").removeClass("accordion-header-error");
                $(".form-group").removeClass("has-error");
                $(".text-danger").remove();
                if (response.error === true) {
                    if (response.validation === true) {
                        for (i in response.message) {
                            var message = response.message[i];
                            var key = i.split(".");
                            var k = key[0] + "[" + key[1] + "]";
                            // console.log([message,key,k]);
                            if (typeof key[1] === "undefined") {
                                $("input[name='" + i + "']")
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $("input[name='" + i + "']").after(
                                    '<small class="text-danger"><i>' +
                                        response.message[i] +
                                        "</i></small>"
                                );
                                $("textarea[name='" + i + "']")
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $("textarea[name='" + i + "']").after(
                                    '<small class="text-danger"><i>' +
                                        response.message[i] +
                                        "</i></small>"
                                );
                                $("select[name='" + i + "']")
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $("select[name='" + i + "']").after(
                                    '<small class="text-danger"><i>' +
                                        response.message[i] +
                                        "</i></small>"
                                );
                            } else {
                                var y = [];
                                y.push(key[0]);
                                for (var x = 1; x < key.length; x++) {
                                    y.push("[" + key[x] + "]");
                                }
                                var k = y.join("");
                                var msg = message.join(",");
                                msg = msg.replaceAll(i, key[0]);
                                $("#accordion-header-error-" + key[1]).addClass(
                                    "accordion-header-error"
                                );
                                $(
                                    "span#warning-upload-" +
                                        key[0] +
                                        "-" +
                                        key[1]
                                )
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $(
                                    "span#warning-upload-" +
                                        key[0] +
                                        "-" +
                                        key[1]
                                ).after(
                                    '<small class="text-danger"><i>' +
                                        msg +
                                        "</i></small>"
                                );

                                $('input[type="text"][name=\'' + k + "']")
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $(
                                    'input[type="text"][name=\'' + k + "']"
                                ).after(
                                    '<small class="text-danger"><i>' +
                                        msg +
                                        "</i></small>"
                                );
                                $('input[type="email"][name=\'' + k + "']")
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $(
                                    'input[type="email"][name=\'' + k + "']"
                                ).after(
                                    '<small class="text-danger"><i>' +
                                        msg +
                                        "</i></small>"
                                );
                                $(
                                    'input[type="datetime-local"][name=\'' +
                                        k +
                                        "']"
                                )
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $(
                                    'input[type="datetime-local"][name=\'' +
                                        k +
                                        "']"
                                ).after(
                                    '<small class="text-danger"><i>' +
                                        msg +
                                        "</i></small>"
                                );
                                $("textarea[name='" + k + "']")
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $("textarea[name='" + k + "']").after(
                                    '<small class="text-danger"><i>' +
                                        msg +
                                        "</i></small>"
                                );
                                $("select[name='" + k + "']")
                                    .closest(".form-group")
                                    .addClass("has-error");
                                $("select[name='" + k + "']").after(
                                    '<small class="text-danger"><i>' +
                                        msg +
                                        "</i></small>"
                                );

                                $("#menu-" + key[1]).addClass(
                                    "has-error-custom"
                                );
                            }
                        }
                    } else {
                        swal("Error", response.message, "error");
                    }
                } else {
                    if (
                        typeof redirectAfterSubmit !== "undefined" &&
                        redirectAfterSubmit == "true"
                    ) {
                        return (window.location.href = response.redirect);
                    }

                    swal("Berhasil", response.message, "success").then(
                        (x) => {
                            window.location.href = response.redirect;
                        }
                    );
                }
            },
            error: function (response) {
                btn.attr("type", "submit");
                btn.html(htmlBtn);
                swal("Error", "Terjadi kesalahan", "error");
            },
        });
    });
    $("#form-common-has-texteditor").on("submit", function (e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var formData = new FormData(this);
        var btn = $("#" + $(this).attr("data-button-submit"));
        var htmlBtn = btn.text();
        $.ajax({
            url: $(this).attr("url"),
            data: formData,
            type: "POST",
            processData: false,
            dataType: "json",
            cache: false,
            contentType: false,
            beforeSend: function () {
                btn.attr("type", "button");
                btn.html("Loading...");
                // btn.html(
                //     '<span style="padding-right:15px">Loading...</span> <img src="' +
                //         _BASE_ASSET +
                //         'images/loading-white.gif" style="width: 30px;position: absolute;right: 10px;" alt="">'
                // );
            },
            complete: function () {
                btn.attr("type", "submit");
                btn.html(htmlBtn);
            },
            success: function (response) {
                $(".form-group").removeClass("has-error");
                $(".text-danger").remove();
                if (response.error === true) {
                    if (response.validation === true) {
                        for (i in response.message) {
                            $("input[name='" + i + "']").closest(".form-group").addClass("has-error");
                            $("input[name='" + i + "']").after('<small class="text-danger"><i>' +response.message[i] +"</i></small>");
                            $("textarea[name='" + i + "']").closest(".form-group").addClass("has-error");
                            $("textarea[name='" + i + "']").after('<small class="text-danger"><i>' +response.message[i] +"</i></small>");
                            $("select[name='" + i + "']").closest(".form-group").addClass("has-error");
                            $("select[name='" + i + "']").after('<small class="text-danger"><i>' +response.message[i] +"</i></small>");
                            $("div#" + i).closest(".form-group").addClass("has-error");
                            $("div#" + i).after('<small class="text-danger"><i>' +response.message[i] +"</i></small>");
                            console.log($("div#" + i));
                            console.log($("#" + i));
                            console.log(i);
                        }
                    } else {
                        swal("Error", response.message, "error");
                    }
                } else {
                    swal("Berhasil", response.message, "success").then(
                        (x) => {
                            window.location.href = response.redirect;
                        }
                    );
                }
            },
            error: function (response) {
                btn.attr("type", "submit");
                btn.html(htmlBtn);
                swal("Error", "Terjadi kesalahan", "error");
            },
        });
    });
});

var format_rp = function (num) {
    var str = num.toString().replace("", ""),
        parts = false,
        output = [],
        i = 1,
        formatted = null;
    if (str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for (var j = 0, len = str.length; j < len; j++) {
        if (str[j] != ",") {
            output.push(str[j]);
            if (i % 3 == 0 && j < len - 1) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return "" + formatted + (parts ? "." + parts[1].substr(0, 2) : "");
};

function input_number(e) {
    let val = $(e).val();
    var clean_format = function (val) {
        return val.replaceAll(",", "");
    };
    $(e).val(format_rp($(e).val()));
}

// MULTIPLE input terminal
function addTerminal() {
    const list = $(".list-terminal");
    const set_id = new Date().getTime() + "" + list.length;
    let actionDelete = "";
    if (list.length >= 0) {
        actionDelete +=
            `<div class="row mb-3 action-delete-terminal">
            <button class="btn btn-danger btn-sm col-sm-2" onclick="removeTerminal(` +
            set_id +
            `)" type="button">Hapus</button>
        </div>`;
    }
    const template =
        `<div class="list-terminal" id="` +
        set_id +
        `">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name[` +
        set_id +
        `]" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="address[` +
        set_id +
        `]"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Google Maps</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="maps[` +
        set_id +
        `]" value="" class="form-control">
                                    </div>
                                </div>
                            <div class="row mb-3" style="display:none">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Sebagai Loket Tiket</label>
                                <div class="col-sm-10">
                                    <select name="is_counter_booth[` +
        set_id +
        `]" class="form-control">
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status[` +
        set_id +
        `]" class="form-control">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>` +
        actionDelete +
        `
                                <hr>
                            </div>
                        </div>`;
    $("#render-terminal").append(template);
}
function addTerminal2() {
    const list = $(".list-titik-point");
    const set_id = new Date().getTime() + "" + list.length;
    let last_list = $(".list-titik-point").eq(0).clone();
    const addButtonDelete = last_list.find(".action-delete-terminal").show();
    addButtonDelete
        .find("button")
        .attr("onclick", "removeTerminal(" + set_id + ")");
    last_list.find("input").val("");
    list.eq(list.length - 1).after(last_list);
    last_list.attr("id", set_id);
}
function removeTerminal(target) {
    const list = $(".list-titik-point");
    if (list.length == 1) {
        return false;
    }
    $("#" + target).remove();
}

// select type armada
function armadaType() {
    const selected = $('input[name="armada_type"]:checked').val();
    $('select[name="seat_plan"]').val("");
    if (selected === "single-deck") {
        $(".set_single-deck").show();
        $(".set_double-deck").hide();
    } else {
        $(".set_single-deck").hide();
        $(".set_double-deck").show();
    }
}
