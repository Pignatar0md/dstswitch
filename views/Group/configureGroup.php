<script>
    $(function () {
        var name = $("#GroupName").html();
        var datos = {
            op: "getGroupId",
            name: name
        };
        $.ajax({
            url: 'controllers/Ctl_Group.php',
            type: 'GET',
            contentType: "application/json",
            data: {json: JSON.stringify(datos)},
            success: function (msg) {
                debugger;
                var json = JSON.parse(msg);
                $("#GroupId").val(json.id);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
</script>
<form><br>
    <div class="row">
        <div class="col-sm-2 col-md-offset-4">
            <input type="hidden" id="GroupId"/>
            <em><label id="GroupName" style="color: #48722c; font-size: 16px"><?php echo $_GET['name'] ?></label></em>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-2 col-md-offset-2">
            <label>Extensiones</label>
        </div>
        <div class="col-sm-2 col-md-offset-2">
            <label>Destinos</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-offset-2">
            <select id="dual1" name="extselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirExt" class="btn btn-sm btn-warning" type="button" value="->"/>
            <input id="quitarExt" class="btn btn-sm btn-warning" type="button" value="<-"/>
            <select id="dual2" multiple="multiple" name="extselected[]" class="fieldLoader" size='8'>
            </select>
        </div>
        <div class="col-sm-4">
            <select id="dual5" name="destselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirDst" class="btn btn-sm btn-warning" type="button" value="->"/>
            <input id="quitarDst" class="btn btn-sm btn-warning" type="button" value="<-"/>
            <select id="dual6" multiple="multiple" name="destselected[]" class="fieldLoader" size='8'>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-2 col-md-offset-2">
            <label>Pines</label>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-4 col-md-offset-2">
            <select id="dual3" name="pinselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirPin" class="btn btn-sm btn-warning" type="button" value="->"/>
            <input id="quitarPin" class="btn btn-sm btn-warning" type="button" value="<-"/>
            <select id="dual4" multiple="multiple" name="pinselected[]" class="fieldLoader" size='8'>
            </select>
        </div><br><br><br><br><br><br>
        <div class="col-md-3">
            <button id="confGroup" type="button" class="btn btn-sm btn-success">Guardar</button>
        </div>
    </div>
</form>