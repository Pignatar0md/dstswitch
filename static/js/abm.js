$(function () {
    $.ajax({
        url: 'controllers/Ctl_Extension.php',
        type: 'POST',
        dataType: "html",
        data: 'op=getAllExt',
        success: function (msg) {
            $("#dual1").html(msg);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            debugger;
            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
        }
    });
    $.ajax({
        url: 'controllers/Ctl_Pin.php',
        type: 'POST',
        dataType: "html",
        data: 'op=getAllPin',
        success: function (msg) {
            $("#dual3").html(msg);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            debugger;
            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
        }
    });
    $.ajax({
        url: 'controllers/Ctl_Destiny.php',
        type: 'POST',
        dataType: "html",
        data: 'op=getAllDest',
        success: function (msg) {
            $("#dual5").html(msg);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            debugger;
            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
        }
    });
    $.ajax({
        url: 'controllers/Ctl_Group.php',
        type: 'POST',
        dataType: "html",
        data: 'op=getAllGroup',
        success: function (msg) {
            $("#comboGroup").append(msg);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            debugger;
            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
        }
    });
    $.ajax({
        url: 'controllers/Ctl_Profile.php',
        type: 'POST',
        dataType: "html",
        data: 'op=getAllProfile',
        success: function (msg) {
            $("#comboProfile").append(msg);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            debugger;
            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
        }
    });
    $("#saveGroup").click(function () {
        var datos = {op: 'saveGroup',
            name: $("#groupName").val()};
        var pins = [];
        for (i = 0; i < $("#dual4")[0].length; i++) {
            pins[i] = $("#dual4").children()[i].innerHTML;
        }
        var exts = [];
        for (i = 0; i < $("#dual2")[0].length; i++) {
            exts[i] = $("#dual2").children()[i].innerHTML;
        }
        datos.pin = pins;
        datos.ext = exts;
        $.ajax({
            url: 'controllers/Ctl_Group.php',
            type: 'GET',
            contentType: "application/json",
            data: {json: JSON.stringify(datos)},
            success: function (msg) {
                    window.location.href = "index.php?page=ListGroup";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
    $("#savePin").click(function () {
        $.ajax({
            url: 'controllers/Ctl_Pin.php',
            type: 'POST',
            dataType: "html",
            data: 'op=savePin&name=' + $("#namePin").val() + "&pin=" + $("#pin").val(),
            success: function (msg) {
                    window.location.href = "index.php?page=ListPin";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
    $("#saveDest").click(function () {
        $.ajax({
            url: 'controllers/Ctl_Destiny.php',
            type: 'POST',
            dataType: "html",
            data: 'op=saveDestiny&name=' + $("#nameDest").val(),
            success: function (msg) {
                    window.location.href = "index.php?page=ListDestiny";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
    $("#saveProfile").click(function () {
        var arrdst = document.getElementById('dual6');
        var dsts = new Array();
        var datos = {
            op: 'saveProfile',
            name: $("#nameProfile").val(),
        };
        for (var i = 0; i < arrdst.length; i++) {
            dsts[i] = arrdst[i].value;
        }
        datos.dst = dsts;
        $.ajax({
            url: 'controllers/Ctl_Profile.php',
            type: 'GET',
            contentType: "application/json",
            data: {json: JSON.stringify(datos)},
            success: function (msg) {
                    window.location.href = "index.php?page=ListProfile";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
    $("#savePermission").click(function () {
        var arrExts = document.getElementById("dual2");
        var arrPins = document.getElementById("dual4");
        var exts = new Array();
        var pins = new Array();
        var datos = {
            op: 'savePermission',
            name: $("#namePermission").val(),
            group: $("#comboGroup").val(),
            profile: $("#comboProfile").val(),
        };
        for (var i = 0; i < arrExts.length; i++) {
            exts[i] = arrExts[i].innerHTML;
        }
        for (var i = 0; i < arrPins.length; i++) {
            pins[i] = arrPins[i].innerHTML;
        }
        datos.extensions = exts;
        datos.pins = pins;
        $.ajax({
            url: 'controllers/Ctl_Permission.php',
            type: 'GET',
            contentType: "application/json",
            data: {json: JSON.stringify(datos)},
            success: function (msg) {
                    window.location.href = "index.php?page=ListPermission";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
});