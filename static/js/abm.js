$(function () {
    $.ajax({
        url: 'controllers/Ctl_Billing.php',
        type: 'POST',
        dataType: "html",
        data: "op=getAllBilling",
        success: function (msg) {
            $("#billing").html(msg);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            debugger;
            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
        }
    });
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
    $("#confBill").click(function () {
        var datos = {op: 'confBilling',
            id: $("#BillingId").val()};
        var dest_precio = [];
        for (i = 0; i < $("#dual6")[0].length; i++) {
            var dest = $("#dual6").children()[i].value;
            var a = $("#"+dest).val();
            dest_precio[dest] = a;
            
        }
        datos.dest_prec = dest_precio;
         if (datos.dest_prec.length) {
            $.ajax({
                url: 'controllers/Ctl_Billing.php',
                type: 'GET',
                contentType: "application/json",
                data: {json: JSON.stringify(datos)},
                success: function (msg) {
                    window.location.href = "index.php?page=ListBilling";
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    debugger;
                    console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                }
            });
        } else {
            alert("Por favor ingrese pines y/o extensiones");
        }
    });
    $("#confGroup").click(function () {
        var datos = {op: 'confGroup',
            id: $("#GroupId").val()};
        datos.name = $("#GroupName").val();
        var dsts = [];
        for (i = 0; i < $("#dual6")[0].length; i++) {
            dsts[i] = $("#dual6").children()[i].value;
        }
        var pins = [];
        for (i = 0; i < $("#dual4")[0].length; i++) {
            pins[i] = $("#dual4").children()[i].value;
        }
        var exts = [];
        for (i = 0; i < $("#dual2")[0].length; i++) {
            exts[i] = $("#dual2").children()[i].value;
        }
        datos.dst = dsts;
        datos.pin = pins;
        datos.ext = exts;
        datos.billing = $("#billing").val();
        if (datos.dst.length > 0 && (datos.pin.length > 0 || datos.ext.length > 0 ||datos.dst.length > 0)) {
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
        } else {
            alert("Por favor ingrese pines y/o extensiones");
        }
    });

    $("#saveTarif").click(function () {
        var datos = {op: 'saveBilling',
            name: $("#billingName").val()};
        if (datos.name) {
            var val1 = validar($("#billingName").val(), "text");
            if (val1) {
                $.ajax({
                    url: 'controllers/Ctl_Billing.php',
                    type: 'GET',
                    contentType: "application/json",
                    data: {json: JSON.stringify(datos)},
                    success: function (msg) {
                        window.location.href = "index.php?page=configureBilling&name=" + $("#billingName").val();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        debugger;
                        console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                    }
                });
            } else {
                alert('Formato de nombre incorrecto');
            }
        } else {
            alert("Por favor ingrese Nombre");
        }
    });
    $("#saveGroup").click(function () {
        var datos = {op: 'saveGroup',
            name: $("#groupName").val()};
        if (datos.name) {
            var val1 = validar($("#groupName").val(), "text");
            if (val1) {
                $.ajax({
                    url: 'controllers/Ctl_Group.php',
                    type: 'GET',
                    contentType: "application/json",
                    data: {json: JSON.stringify(datos)},
                    success: function (msg) {
                        window.location.href = "index.php?page=configureGroup&name=" + $("#groupName").val();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        debugger;
                        console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                    }
                });
            } else {
                alert('Formato de nombre incorrecto');
            }
        } else {
            alert("Por favor ingrese Nombre");
        }
    });

    $("#savePin").click(function () {
        if ($("#pin").val() && $("#namePin").val()) {
            var val1 = validar($("#pin").val(), "num");
            var val2 = validar($("#namePin").val(), "text");
            if (val1 && val2) {
                $.ajax({
                    url: 'controllers/Ctl_Pin.php',
                    type: 'POST',
                    dataType: "html",
                    data: 'op=savePin&name=' + $("#namePin").val() + "&pin=" + $("#pin").val(),
                    success: function (msg) {
                        if (msg === '1') {
                            alert("Pin existente, por favor ingrese un nuevo y unico pin.");
                        } else {
                            window.location.href = "index.php?page=ListPin";
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                    }
                });
            } else {
                alert('Formato de pin o nombre incorrecto');
            }
        } else {
            alert('Ingrese pin y/o nombre');
        }
    });

    $("#saveDest").click(function () {
        if ($("#nameDest").val()) {
            var val1 = validar($("#nameDest").val(), "text");
            if (val1) {
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
            } else {
                alert('Formato de nombre incorrecto');
            }
        } else {
            alert("Por favor ingrese 'Nombre'");
        }
    });
    $("#tblReport").on('click', '.detailedReport', function () {
        $("#modalDetailedRep").modal('show');
    });
});