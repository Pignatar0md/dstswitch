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
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'controllers/Ctl_Profile.php',
            type: 'POST',
            dataType: "html",
            data: 'op=getProfileList',
            success: function (msg) {
                $("#tablaProfile").html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
        $("#tablaProfile").on('click', '.eliminar', function (e) {
            $("#modalConfirm").modal('show');
            var pdid = this.id;
            $("#delOk").click(function () {
                $.ajax({
                    url: 'controllers/Ctl_Profile.php',
                    type: 'POST',
                    dataType: "html",
                    data: 'op=deleteProfile&pdid=' + pdid,
                    success: function (msg) {
                        window.location.href = "index.php?page=ListProfile";
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        debugger;
                        console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                    }
                });
            });
        });
    });
</script>
<div class="modal fade" id="modalConfirm" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminar Perfil</h4>
            </div>
            <div class="modal-body">
                <p>Confirma operacion?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="delOk" class="btn btn-default btn-sm" data-dismiss="modal">Si</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<div class="row"><br>
    <div class="col-md-6 col-md-offset-3">
        <table class="table table-striped">
            <thead><th>Pefil</th><th>Destinos</th><th>Acciones</th></thead>
            <tbody id="tablaProfile"></tbody>
        </table>
    </div>
</div>