            <form><br>
                <div class="row">
                    <div class="col-md-3 col-md-offset-4">
                        <input type="hidden" id="idGroup"  value="<?php echo $_GET['id'] ?>"/>
                        <input type="text" class="form-control" id="groupName" placeholder="Nombre grupo"/>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-5 col-md-offset-4">
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
                    <div class="col-sm-5 col-md-offset-4">
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
                        <button id="updateGroup" type="button" class="btn btn-sm btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        <script>
            $(function () {
                var id = <?php echo $_GET['id'] ?>;
                $.ajax({
                    url: 'controllers/Ctl_Group.php',
                    type: 'GET',
                    dataType: "html",
                    data: 'id=' + id,
                    success: function (msg) {
                        var json = JSON.parse(msg);
                        $("#groupName").val(json.name);
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
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        debugger;
                        console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                    }
                });
                $("#updateGroup").click(function () {
                    var datos = {op: 'updateGroup',
                        id: $("#idGroup").val(),
                        name: $("#groupName").val()};
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
                    $.ajax({
                        url: 'controllers/Ctl_Group.php',
                        type: 'GET',
                        contentType: "application/json",
                        data: {json: JSON.stringify(datos)},
                        success: function (ms) {
                            window.location.href = "/DstSwitch/views/Group/ListGroup.php";
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            debugger;
                            console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                        }
                    });
                });
            });
        </script>
