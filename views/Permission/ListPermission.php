        <script>
            $(document).ready(function () {
                $.ajax({
                    url: 'controllers/Ctl_Permission.php',
                    type: 'POST',
                    dataType: "html",
                    data: 'op=getPermissionList',
                    success: function (msg) {
                        console.log(msg);
                        $("#tablaPermission").html(msg);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        debugger;
                        console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                    }
                });
                $("#tablaPermission").on('click', '.eliminar', function (e) {
                    $("#modalConfirm").modal('show');
                    var id = this.id;
                    $("#delOk").click(function () {
                        debugger;
                        $.ajax({
                            url: 'controllers/Ctl_Permission.php',
                            type: 'POST',
                            dataType: "html",
                            data: 'op=deletePermission&id=' + id,
                            success: function (msg) {
                                window.location.href = "index.php?page=ListPermission";
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
                            <h4 class="modal-title">Eliminar Permiso</h4>
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
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-striped">
                        <thead><th>Permiso</th><th>Perfil</th><th>Grupo</th><th>Extensiones</th><th>Pines</th><th>Acciones</th></thead>
                        <tbody id="tablaPermission"></tbody>
                    </table>
                </div>
            </div>