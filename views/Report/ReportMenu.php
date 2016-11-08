<link rel="stylesheet" type="text/css" href="static/datetimepicker/build/css/bootstrap-datetimepicker.css">
<script type="text/javascript" src="static/moment/min/moment.min.js"></script>
<script type="text/javascript" src="static/datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="static/js/funcionesValidate.js"></script>
<script type="text/javascript">
    $(function () {
        $.ajax({
            url: 'controllers/Ctl_Destiny.php',
            type: 'POST',
            dataType: "html",
            data: "op=getAllDest",
            success: function (msg) {
                $("#comboDst").append(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });

        $('#fecha1').datetimepicker({
            pickTime: false
        });
        $('#fecha2').datetimepicker({
            pickTime: false
        });
        $('#hora1').datetimepicker({
            pickDate: false,
            format: 'HH:mm'
        });
        $('#hora2').datetimepicker({
            pickDate: false,
            format: 'HH:mm'
        });
        $('#hora2').change(function () {
            var x = $('#hora1').val();
            var y = $('#hora2').val();
            var msg = validate_hour(x, y);
            if (msg) {
                alert(msg);
                $('#hora1').val('');
                $('#hora2').val('');
            }
        });
        $('#ctlfecha2').change(function () {
            var x = $('#ctlfecha1').val();
            var y = $('#ctlfecha2').val();
            var msg = validate_fechaMayorQue(x, y);
            if (msg) {
                alert(msg);
                $('#ctlfecha1').val('');
                $('#ctlfecha2').val('');
            }
        });
    });
</script>
<form method="POST" action="index.php?page=dataReport"><br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="col-md-4">
                <label>Fecha Desde</label>
                <div class="controls">
                    <div class='input-group date' id='fecha1' data-date-format="DD/MM/YYYY">
                        <input type='text' class="form-control" id="ctlfecha1" required="required" name="dateSince"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label>Hasta</label>
                <div class="controls">
                    <div class=' input-group date' id='fecha2' data-date-format="DD/MM/YYYY">
                        <input type='text' class="form-control" id="ctlfecha2" required="required" name="dateTo"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label>Grupo</label>
                <select id="comboGroup" class="form-control" name="group">
                </select>
            </div>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="col-md-4">
                <label>Hora Desde</label>
                <div class="controls">
                    <div class='input-group date'>
                        <input type='text' id='hora1' class="form-control" name="timeSince"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label>Hasta</label>
                <div class="controls">
                    <div class='input-group date'>
                        <input type='text' id='hora2' class="form-control" name="timeTo"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
            </div><br>
            <div class="col-md-4">
                <input type="submit" id="getReport" class="btn btn-sm btn-success" value="Ver Reporte"/>
            </div>
        </div>
    </div><br>
</form>