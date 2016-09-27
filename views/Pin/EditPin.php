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
        <div class="col-md-3 col-md-offset-4">
            <input id="idPin" type="hidden"/>
            <input type="text" class="form-control" id="namePin" placeholder="Nombre de Pin"/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <input type="text" class="form-control" id="pin" placeholder="Pin"/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <button id="updatePin" type="button" class="btn btn-sm btn-success">Guardar</button>
        </div>
    </div>
</form>

<script>
    $(function () {
        debugger;
        var id = <?php echo $_GET['id'] ?>;
        $.ajax({
            url: 'controllers/Ctl_Pin.php',
            type: 'GET',
            dataType: "html",
            data: 'id=' + id,
            success: function (msg) {
                debugger;console.log(msg);
                var json = JSON.parse(msg);
                $("#idPin").val(json.id);
                $("#namePin").val(json.name);
                $("#pin").val(json.pin);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
        $("#updatePin").click(function () {
            if ($("#namePin").val() && $("#pin").val()) {
                var val1 = validar($("#pin").val(), "num");
                var val2 = validar($("#namePin").val(), "text");
                if (val1 && val2) {
                    $.ajax({
                        url: 'controllers/Ctl_Pin.php',
                        type: 'POST',
                        dataType: "html",
                        data: 'op=updatePin&id=' + $("#idPin").val() + "&name=" + $("#namePin").val() + "&pin=" + $("#pin").val(),
                        success: function (ms) {
                            console.log(ms);
                            window.location.href = "index.php?page=ListPin";
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            debugger;
                            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                        }
                    });
                } else {
                    alert('Formato de pin o nombre incorrecto');
                }
            } else {
                alert("Por favor ingrese 'Nombre' y 'Pin'");
            }
        });
    });
</script>
</html>