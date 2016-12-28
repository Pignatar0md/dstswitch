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
<form class="form-inline">
    <br>
    <div class="row">
        <div class="col-sm-3 col-md-offset-1">
            <input type="hidden" id="BillingId" value="<?php echo $_GET['id'] ?>"/>
            <label>Tarifa:&nbsp;</label><input type="text" class="form-control" id="billingName"/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-offset-1 col-sm-1">
            <label>Destinos</label>
        </div>
        <div class="col-md-offset-3 col-sm-2">
            <label>Precio Por Minuto</label>
        </div>
        <div class="col-sm-2">
            <label>Precio Minimo (ej: 1.2)</label>
        </div>
        <div class="col-sm-2">
            <label>Tiempo Minimo (segs)</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-push-1">
            <select id="dual5" name="destselect" multiple="multiple" class="fieldLoader" size='10'>
            </select>
            <input id="anadirDst" class="btn btn-sm btn-warning" type="button" value="->"/>
            <input id="quitarDst" class="btn btn-sm btn-warning" type="button" value="<-"/>
            <select id="dual6" multiple="multiple" name="destselected[]" class="fieldLoader" size='10'>
            </select>
        </div>
        <div class="col-md-2 col-md-push-1" id="prices">
        </div>
        <div class="col-md-2 col-md-push-1" id="minPrices">
        </div>
        <div class="col-md-2 col-md-push-1" id="timeMinPrices">
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-2 col-md-offset-6">
            <button id="updateBill" type="button" class="btn btn-sm btn-success">Actualizar</button>
        </div>
    </div>
</form>
<script>

    var dual6 = document.getElementById('dual6');

    dual6.addEventListener("DOMNodeInserted", generarInput, true);
    dual6.addEventListener("DOMNodeRemoved", quitarInput, true);
    var count = 0;

    function generarInput(evt) {

        var priceinput = crearInput();
        priceinput.id = evt.currentTarget[count].value;
        priceinput.placeholder = evt.currentTarget[count].innerHTML;
        var prices = document.getElementById('prices');
        prices.appendChild(priceinput);
        var pricemininput = crearInput();
        pricemininput.id = 'min' + evt.currentTarget[count].value;
        pricemininput.placeholder = evt.currentTarget[count].innerHTML;
        var minprices = document.getElementById('minPrices');
        minprices.appendChild(pricemininput);
        var minpricetimeinput = crearInput();
        minpricetimeinput.id = 'timemin' + evt.currentTarget[count].value;
        minpricetimeinput.placeholder = evt.currentTarget[count].innerHTML;
        var minpricestime = document.getElementById('timeMinPrices');
        minpricestime.appendChild(minpricetimeinput);

        count++;
    }

    function quitarInput(evt) {
        var priceToQuit = document.getElementById(evt.target.value);
        var minPriceToQuit = document.getElementById('min'+evt.target.value);
        var timeMinPriceToQuit = document.getElementById('timemin'+evt.target.value);
        priceToQuit.parentNode.removeChild(priceToQuit);
        minPriceToQuit.parentNode.removeChild(minPriceToQuit);
        timeMinPriceToQuit.parentNode.removeChild(timeMinPriceToQuit);
    }

    function crearInput() {
        var input = document.createElement('input');
        input.type = "text";
        input.className = "form-control input-sm";
        return input;
    }
</script>