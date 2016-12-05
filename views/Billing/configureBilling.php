<script>
    $(function () {
        var name = $("#billingName").html();
        var datos = {
            op: "getBillingId",
            name: name
        };
        $.ajax({
            url: 'controllers/Ctl_Billing.php',
            type: 'GET',
            contentType: "application/json",
            data: {json: JSON.stringify(datos)},
            success: function (msg) {
                var json = JSON.parse(msg);
                $("#BillingId").val(json.id);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
</script>
<form><br>
    <div class="row">
        <div class="col-sm-2 col-md-offset-4">
            <input type="hidden" id="BillingId"/>
            <label style="font-size: 16px">Tarifa: <label id="billingName" style="color: #48722c;"><?php echo $_GET['name'] ?></label></label>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-offset-3 col-sm-1">
            <label>Precios</label>
        </div>
        <div class="col-sm-offset-1 col-sm-1">
            <label>Destinos</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-offset-2">
            <div class="col-md-2">
                <button id="confBill" type="button" class="btn btn-sm btn-success">Guardar</button>
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
    var count = 0;
    var dual6 = document.getElementById('dual6');
    dual6.addEventListener("DOMNodeInserted", crearInputPrecio, true);
    dual6.addEventListener("DOMNodeRemoved", quitarInputPrecio, true);
    function crearInputPrecio(evt) {
        var priceinput = document.createElement('input');
        priceinput.type = "text";
        priceinput.className = "form-control input-sm";
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
