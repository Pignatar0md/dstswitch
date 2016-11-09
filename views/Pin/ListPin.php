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
            url: 'controllers/Ctl_Pin.php',
            type: 'POST',
            dataType: "html",
            data: 'op=getPinList',
            success: function (msg) {
                $("#tablaPin").html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
        $("#tablaPin").on('click', '.eliminar', function (e) {
            $("#modalConfirm").modal('show');
            var id = this.id;
            $("#delOk").click(function () {
                debugger;
                $.ajax({
                    url: 'controllers/Ctl_Pin.php',
                    type: 'POST',
                    dataType: "html",
                    data: 'op=deletePin&id=' + id,
                    success: function (msg) {
                        window.location.href = "index.php?page=ListPin";
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
                <h4 class="modal-title">Eliminar Pin</h4>
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
    <div class="col-md-4 col-md-offset-4">
        <table class="table table-striped">
            <thead><th>#</th><th>Pin</th><th>Nombre</th><th style="text-align: center">Acciones</th></thead>
            <tbody id="tablaPin"></tbody>
        </table>
    </div>
</div>

