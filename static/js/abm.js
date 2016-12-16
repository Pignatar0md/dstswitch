$(function () {
    $.ajax({
        url: 'controllers/Ctl_Billing.php',
        type: 'POST',
        dataType: "html",
        data: "op=getAllBilling",
        success: function (msg) {
            $("#billing").html(msg);
            if ($("#BillingId").val()) {
                fillBillingBoxes($("#BillingId").val());
            }
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
            if ($("#idGroup").val()) {
                fillBoxes($("#idGroup").val());
            }
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
            if ($("#idGroup").val()) {
                fillBoxes($("#idGroup").val());
            }
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
            if ($("#idGroup").val()) {
                fillBoxes($("#idGroup").val());
            }
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
        var min_precio = [];
        var tiempo_min_precio = [];
        for (i = 0; i < $("#dual6")[0].length; i++) {
            var dest = $("#dual6").children()[i].value;
            var a = $("#" + dest).val();
            var b = $("#min" + dest).val();
            var c = $("#timemin" + dest).val();
            dest_precio[dest] = a;
            min_precio[dest] = b;
            tiempo_min_precio[dest] = c;
        }
        datos.dest_prec = dest_precio;
        datos.min_prec = min_precio;
        datos.tiempo_min_prec = tiempo_min_precio;
//         if (datos.dest_prec.length) {
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
//        } else {
//            alert("Por favor ingrese pines y/o extensiones");
//        }
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
        //      if (datos.dst.length > 0 && (datos.pin.length > 0 || datos.ext.length > 0 ||datos.dst.length > 0)) {
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
//        } else {
//            alert("Por favor ingrese pines y/o extensiones");
//        }
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
    $("#updateGroup").click(function () {
        var datos = {op: 'updateGroup',
            id: $("#idGroup").val()};
        datos.name = $("#nameGroup").val();
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
//            if (datos.dsts.length > 0 && (datos.pin.length > 0 || datos.ext.length > 0)) {
        $.ajax({
            url: 'controllers/Ctl_Group.php',
            type: 'GET',
            contentType: "application/json",
            data: {json: JSON.stringify(datos)},
            success: function (msg) {
                //debugger;
                window.location.href = "index.php?page=ListGroup";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
        //          }
    });
    $("#updateBill").click(function () {
        var datos = {op: 'updateBilling',
            id: $("#BillingId").val()};

        datos.name = $("#billingName").val();

        var dests = [];
        var dest_precio = [];
        var min_precio = [];
        var tiempo_min_precio = [];
        for (i = 0; i < $("#dual6")[0].length; i++) {
            var dest = $("#dual6").children()[i].value;
            var a = $("#" + dest).val();
            var b = $("#min" + dest).val();
            var c = $("#timemin" + dest).val();
            dests[i] = dest;
            dest_precio[dest] = a;
            min_precio[dest] = b;
            tiempo_min_precio[dest] = c;
        }
        datos.dsts = dests;
        datos.dest_prec = dest_precio;
        datos.min_prec = min_precio;
        datos.tiempo_min_prec = tiempo_min_precio;

        //        if (datos.dsts.length > 0 && datos.dest_prec.length > 0) {
        $.ajax({
            url: 'controllers/Ctl_Billing.php',
            type: 'GET',
            contentType: "application/json",
            data: {json: JSON.stringify(datos)},
            success: function (msg) {
                console.log(datos);
                debugger;
                window.location.href = "index.php?page=ListBilling";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
        //    }
    });

    function fillBoxes(id) {
        $.ajax({
            url: 'controllers/Ctl_Group.php',
            type: 'GET',
            dataType: "html",
            data: 'id=' + id,
            success: function (msg) {
                var json = JSON.parse(msg);
                $("#nameGroup").val(json.nomgrupo);
                $("#billing option[value='" + json.tarifa + "']").prop('selected', true);
                var Jarrexts = json.extensiones[0];
                var Jarrpins = json.pines[0];
                var Jarrdsts = json.destinos[0];
                var arrexts = [];
                /*        for (var x in Jarrexts) {
                 arrexts.push(Jarrexts[x]);
                 }*/
                var arrpins = [];
                for (var x in Jarrpins) {
                    arrpins.push(Jarrpins[x]);
                }
                var arrdsts = [];
                for (var x in Jarrdsts) {
                    arrdsts.push(Jarrdsts[x]);
                }
                for (var a = 0; a < arrexts.length; a++) {
                    var opt = quitAndMake(arrexts[a], $("#dual1"));
                }
                var arrpins = [];
                for (var x in Jarrpins) {
                    arrpins.push(Jarrpins[x]);
                }
                var arrdsts = [];
                for (var x in Jarrdsts) {
                    arrdsts.push(Jarrdsts[x]);
                }

                if ($("#dual1").children().length > 0) {
                    for (var x in Jarrexts) {
                        arrexts.push(Jarrexts[x]);
                    }
                    for (var a = 0; a < arrexts.length; a++) {
                        var opt = quitAndMake(arrexts[a], $("#dual1"));
                        $("#dual2").append(opt);
                    }

                }

                if ($("#dual3").children().length > 0) {
                    for (var a = 0; a < arrpins.length; a++) {
                        var opt = quitAndMake(arrpins[a], $("#dual3"));
                        $("#dual4").append(opt);
                    }
                }

                if ($("#dual5").children().length > 0) {
                    for (var a = 0; a < arrdsts.length; a++) {
                        var opt = quitAndMake(arrdsts[a], $("#dual5"));
                        $("#dual6").append(opt);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }

    function fillBillingBoxes(id) {
        $.ajax({
            url: 'controllers/Ctl_Billing.php',
            type: 'GET',
            dataType: "html",
            data: 'id=' + id,
            success: function (msg) {
                var json = JSON.parse(msg);
                var Jarrdsts = json.destinos[0];
                var Jarrdst_prec = json.destinos_precios[0];
                var Jarrdst_prec_min = json.precios_min[0];
                var Jarrdst_tiempo_prec_min = json.tiempo_precios_min[0];

                var arrdsts = [];
                for (var x in Jarrdsts) {
                    arrdsts.push(Jarrdsts[x]);
                }
                for (var a = 0; a < arrdsts.length; a++) {
                    var opt = quitAndMake(arrdsts[a], $("#dual5"));
                    $("#dual6").append(opt);
                }
                $("#billingName").val(json.desc);
                for (var a in Jarrdst_prec) {
                    var priceText = document.getElementById(a);
                    if (priceText) {
                        priceText.value = Jarrdst_prec[a];
                    }
                }
                for (var f in Jarrdst_prec_min) {
                    var minPriceText = document.getElementById('min' + f);
                    if (minPriceText) {
                        minPriceText.value = Jarrdst_prec_min[f];
                    }
                }
                for (var h in Jarrdst_tiempo_prec_min) {
                    var minTimePriceText = document.getElementById('timemin' + h);
                    if (minTimePriceText) {
                        minTimePriceText.value = Jarrdst_tiempo_prec_min[h];
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
});
