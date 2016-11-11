<?php
session_start();
if (!$_SESSION['Usuario']) {
    header('Location: ../index.php');
}
if ($_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR'] ||
        $_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
    header('Location: ../index.php');
}
?>
<form><br>
    <div class="row">
        <div class="col-sm-2 col-md-offset-4">
            <input type="hidden" id="BillingId" value="<?php echo $_GET['id'] ?>"/>
            <input type="text" class="form-control" id="billingName"/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-2 col-md-offset-5">
            <label>Destinos</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-offset-2">
            <div class="col-md-2">
                <button id="updateBill" type="button" class="btn btn-sm btn-success">Guardar</button>
            </div>
            <select id="dual5" name="destselect" multiple="multiple" class="fieldLoader" size='10'>
            </select>
            <input id="anadirDst" class="btn btn-sm btn-warning" type="button" value="->"/>
            <input id="quitarDst" class="btn btn-sm btn-warning" type="button" value="<-"/>
            <select id="dual6" multiple="multiple" name="destselected[]" class="fieldLoader" size='10'>
            </select>
            <div class="col-md-3" id="prices">
            </div>
        </div>
    </div>
</form>
<script>
    $(function () {
        var id = <?php echo $_GET['id'] ?>;
        $.ajax({
            url: 'controllers/Ctl_Billing.php',
            type: 'GET',
            dataType: "html",
            data: 'id=' + id,
            success: function (msg) {
                var json = JSON.parse(msg);
                var Jarrdsts = json.destinos[0];
                var Jarrdst_prec = json.destinos_precios[0];
                var arrdsts = [];
                var arrdst_prec = [];
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
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
        $("#updateBill").click(function () {
            var datos = {op: 'updateBilling',
                id: $("#BillingId").val()};
            
            datos.name = $("#billingName").val();
            var dest_precio = [];var dests = [];
            for (i = 0; i < $("#dual6")[0].length; i++) {
                var dest = $("#dual6").children()[i].value;
                var a = $("#" + dest).val();
                dest_precio[dest] = a;
                dests[i] = dest;
            }
            datos.dest_prec = dest_precio;
            datos.dsts = dests;
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
        });
    });
</script>
<script>
    var count = 0;
    var dual6 = document.getElementById('dual6');
    dual6.addEventListener("DOMNodeInserted", crearInputPrecio, true);
    dual6.addEventListener("DOMNodeRemoved", quitarInputPrecio, true);
    function crearInputPrecio(evt) {
        var priceinput = document.createElement('input');
        priceinput.type = "text";
        priceinput.className = "form-control input-sm";
        //priceinput.value = 
        priceinput.id = evt.currentTarget[count].value;
        priceinput.placeholder = evt.currentTarget[count].innerHTML;
        var prices = document.getElementById('prices');
        prices.appendChild(priceinput);
        count++;
    }
    function quitarInputPrecio(evt) {
        var priceToQuit = document.getElementById(evt.target.value);
        priceToQuit.parentNode.removeChild(priceToQuit);
    }
</script>
