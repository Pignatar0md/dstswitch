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
            <input type="hidden" id="idPerm" value="<?php echo $_GET['id'] ?>"/>
            <input type="text" class="form-control" id="namePermission" placeholder="Nombre de Permiso"/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <select id="comboGroup" class="form-control">
                <option>Selec. Grupo</option>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <select id="comboProfile" class="form-control">
                <option>Selec. Perfil</option>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            <label>Extensiones</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 col-md-offset-4">
            <select id="dual1" name="extselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirExt" class="btn btn-sm btn-success" type="button" value="->"/>
            <input id="quitarExt" class="btn btn-sm btn-success" type="button" value="<-"/>
            <select id="dual2" multiple="multiple" name="extselected[]" class="fieldLoader" size='8'>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            <label>Pines</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 col-md-offset-4">
            <select id="dual3" name="pinselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirPin" class="btn btn-sm btn-success" type="button" value="->"/>
            <input id="quitarPin" class="btn btn-sm btn-success" type="button" value="<-"/>
            <select id="dual4" multiple="multiple" name="pinselected[]" class="fieldLoader" size='8'>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <button type="button" class="btn btn-sm btn-success" id="updatePermission">Guardar</button>
        </div>
    </div>
</form>
<script>
    $(function () {
        var id = <?php echo $_GET['id'] ?>;
        $.ajax({
            url: 'controllers/Ctl_Permission.php',
            type: 'GET',
            dataType: "html",
            data: 'id=' + id,
            success: function (msg) {
                debugger;
                var json = JSON.parse(msg);
                $("#namePermission").val(json.name);
                var arrexts = json.extlist.split(',');
                var arrpins = json.pinlist.split(',');
                for (var a = 0; a < arrexts.length; a++) {
                    var opt = quitAndMake(arrexts[a], $("#dual1"));
                    $("#dual2").append(opt);
                }
                for (var a = 0; a < arrpins.length; a++) {
                    var opt = quitAndMake(arrpins[a], $("#dual3"));
                    $("#dual4").append(opt);
                }
                $("#comboProfile > option[value='" + json.idprofile + "']").attr('selected', 'selected');
                $("#comboGroup > option[value='" + json.idgroup + "']").attr('selected', 'selected');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
        $("#updatePermission").click(function () {
            if ($("#namePermission").val() && $("#comboProfile").val() && $("#comboGroup").val()) {
                var datos = {op: 'updatePermission',
                    id: $("#idPerm").val(),
                    idp: $("#comboProfile").val(),
                    idg: $("#comboGroup").val(),
                    name: $("#namePermission").val()};
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
                var val1 = validar($("#namePermission").val(), "text");
                if (val1) {
                    $.ajax({
                        url: 'controllers/Ctl_Permission.php',
                        type: 'GET',
                        contentType: "application/json",
                        data: {json: JSON.stringify(datos)},
                        success: function (ms) {
                            window.location.href = "index.php?page=ListPermission";
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            debugger;
                            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                        }
                    });
                } else {
                    alert("Nombre no valido");
                }
            } else {
                alert("Por favor ingrese valores");
            }
        });
    });
</script>