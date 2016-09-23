<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>dstswitch</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../../static/css/abm.css"/>
    </head>
    <body>
        <div class="container-fluid">
            <form>
                <br>
                <div class="row">
                    <div class="col-md-3 col-md-offset-4">
                        <input type="hidden" id="idProfile" value="<?php echo $_GET['pid'] ?>"/>
                        <input type="hidden" id="idProfileDestiny" value="<?php echo $_GET['pdid'] ?>"/>
                        <input type="text" class="form-control" id="nameProfile" placeholder="Nombre del Perfil" value="<?php echo $name; ?>"/>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-5 col-md-offset-4">
                        <label>Destinos</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-md-offset-4">
                        <select id="dual5" name="dstselect" multiple="multiple" class="fieldLoader" size='10'>
                        </select>
                        <input id="anadirDst" class="btn btn-success btn-sm" type="button" value="->"/>
                        <input id="quitarDst" class="btn btn-success btn-sm" type="button" value="<-"/>
                        <select id="dual6" multiple="multiple" name="agtselected[]" class="fieldLoader" size='10'>
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-3 col-md-offset-4">
                        <button type="button" id="updateProfile" class="btn btn-sm btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../../static/js/abm.js"></script>
        <script>
            $(function () {
                var pid = document.getElementById("idProfile");
                var pdid = document.getElementById("idProfileDestiny");
                $.ajax({
                    url: '../../controllers/Ctl_Profile.php',
                    type: 'GET',
                    dataType: "html",
                    data: 'pid=' + pid.value,
                    success: function (msg) {
                        var json = JSON.parse(msg);
                        $("#nameProfile").val(json.pdescr);
                        for(i = 0;i < json.destiny.length;i++) {
                          var opt = document.createElement("option");
                          var textOpt = document.createTextNode(json.destiny[i].name);
                          opt.value = json.destiny[i].id;
                          opt.selected = true;
                          opt.appendChild(textOpt);
                          $("#dual6").append(opt);
                        }
                        quitSelectedFromSelect($("#dual5"), $("#dual6"));
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        debugger;
                        console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                    }
                });
                /*$("#updateProfile").click(function () {
                    if($("#nameProfile").val() && $("#dual6").val()) {
                        var datos = {op:updateProfile, 
                                     idp: $("#idProfile").val(),
                                     name:$("#nameProfile").val()};
                        var idpd = [];
                        for(i = 0; i < $("#dual6")[0].length; i++) {
                            idpd[i] = $("#dual6").children()[i].value;
                        }
                        datos.dst = idpd;
                        $.ajax({
                            url: '../../controllers/Ctl_Profile.php',
                            type: 'POST',
                            dataType: "json",
                            data: datos,
                            success: function (ms) {
                                
                                //window.location.href = "/DstSwitch/views/Destiny/ListProfile.php";
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                debugger;
                                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                            }
                        });
                    } else {
                            alert("Por favor ingrese valores");
                    }
                });*/
            });
        </script>
        <script src="../../static/js/boxes.js"></script>
    </body>
</html>