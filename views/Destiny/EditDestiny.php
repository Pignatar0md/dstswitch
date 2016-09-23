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
                        alert("Por favor ingrese valor en 'Destino'");
                    }
                });
            });
        </script>