
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
            var id = <?php echo $_GET['id'] ?>;
            $.ajax({
                url: 'controllers/Ctl_Pin.php',
                type: 'GET',
                dataType: "html",
                data: 'id=' + id,
                success: function (msg) {
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
                    alert("Por favor ingrese 'Nombre' y 'Pin'");
                }
            });
        });
    </script>
</html>