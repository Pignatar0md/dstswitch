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
            <input id="idDest" type="hidden"/>
            <input type="text" class="form-control" id="nameDest" placeholder="Destino"/>
        </div>
    </div><br>         
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <button type="button" id="updateDest" class="btn btn-sm btn-success">Guardar</button>
        </div>
    </div>
</form>
<script>
    $(function () {
        var id = <?php echo $_GET['id'] ?>;
        $.ajax({
            url: 'controllers/Ctl_Destiny.php',
            type: 'GET',
            dataType: "html",
            data: 'id=' + id,
            success: function (msg) {
                var json = JSON.parse(msg);
                $("#idDest").val(json.id);
                $("#nameDest").val(json.name);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
        $("#updateDest").click(function () {
            if ($("#nameDest").val()) {
                var val1 = validar($("#nameDest").val(), "text");
                if (val1) {
                    $.ajax({
                        url: 'controllers/Ctl_Destiny.php',
                        type: 'POST',
                        dataType: "html",
                        data: 'op=updateDest&id=' + $("#idDest").val() + "&name=" + $("#nameDest").val(),
                        success: function (ms) {
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
                alert("Por favor ingrese valor en 'Destino'");
            }
        });
    });
</script>