<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
include 'controllers/Ctl_Report.php';
include 'controllers/Ctl_Group.php';
//creo objetos de controlador
$ctlGroup = new Ctl_Group();
$ctlRep = new Ctl_Report();
$nomGrupo = $nomTarifa = '';
//recibo params por POST
$arrDatos[0] = isset($_POST['group']) ? $_POST['group'] : '';
$arrDatos[1] = isset($_POST['dateSince']) ? ReverseAndReplace($_POST['dateSince']) : '';
$arrDatos[2] = isset($_POST['dateTo']) ? ReverseAndReplace($_POST['dateTo']) : '';
$arrDatos[3] = isset($_POST['timeSince']) ? $_POST['timeSince'] : '';
$arrDatos[4] = isset($_POST['timeTo']) ? $_POST['timeTo'] : '';
//traigo precios para cada tipo de llam. y tarifa a grupo
$precioFijosUrb = $ctlRep->traerPrecioId($arrDatos[0], '1');
$precioFijosInter = $ctlRep->traerPrecioId($arrDatos[0], '4');
$precioCelUrb = $ctlRep->traerPrecioId($arrDatos[0], '2');
$precioCelInter = $ctlRep->traerPrecioId($arrDatos[0], '3');
$precioInternac = $ctlRep->traerPrecioId($arrDatos[0], '5');
//extraigo los valores de las tarifas
foreach ($precioFijosUrb as $clave => $valor) {
    $pfu = $valor['precio'];
}
foreach ($precioFijosInter as $clave => $valor) {
    $pfi = $valor['precio'];
}
foreach ($precioCelUrb as $clave => $valor) {
    $pcu = $valor['precio'];
}
foreach ($precioCelInter as $clave => $valor) {
    $pci = $valor['precio'];
}
foreach ($precioInternac as $clave => $valor) {
    $pi = $valor['precio'];
}
// fila 1
$preciosPorMin = "<tr><td style='font-size: 16px;color: darkgreen'>Precio Por Minuto ($)</td><td>$pfu</td><td>$pfi</td><td>$pcu</td><td>$pci</td><td>$pi</td><td style='color:darkred'>---</td>";
//traigo total de llamadas de cada tipo
$arrDatos[5] = "fijosurb";
$cdadLlmFijosUrb = $ctlRep->cdadTotalLlam($arrDatos);
$arrDatos[5] = "fijosinter";
$cdadLlmFijosInter = $ctlRep->cdadTotalLlam($arrDatos);
$arrDatos[5] = "celurb";
$cdadLlmCelurb = $ctlRep->cdadTotalLlam($arrDatos);
$arrDatos[5] = "celinter";
$cdadLlmCelinter = $ctlRep->cdadTotalLlam($arrDatos);
$arrDatos[5] = "internac";
$cdadLlmInternac = $ctlRep->cdadTotalLlam($arrDatos);
// calculo cdad total de llam
$totalLlamadas = ($cdadLlmFijosUrb + $cdadLlmFijosInter + $cdadLlmCelurb + $cdadLlmCelinter + $cdadLlmInternac);
//fila 2
$llamsTotalesPorTipo = "<tr><td style='font-size: 16px;color: darkgreen'>Cdad. de Llamadas</td>"
        . "<td>$cdadLlmFijosUrb</label></td>"
        . "<td>$cdadLlmFijosInter</label></td>"
        . "<td>$cdadLlmCelurb</label></td>"
        . "<td>$cdadLlmCelinter</label></td>"
        . "<td>$cdadLlmInternac</label></td>"
        . "<td style='color:darkred;text-decoration: underline' class='detailedReport'>$totalLlamadas</td>";
//traigo segundos totales para cada tipo de llamadas
$arrDatos[5] = "fijosurb";
$segsFijosUrb = $ctlRep->segundosTotales($arrDatos);
$arrDatos[5] = "fijosinter";
$segsFijosInter = $ctlRep->segundosTotales($arrDatos);
$arrDatos[5] = "celurb";
$segsCelurb = $ctlRep->segundosTotales($arrDatos);
$arrDatos[5] = "celinter";
$segsCelinter = $ctlRep->segundosTotales($arrDatos);
$arrDatos[5] = "internac";
$segsInternac = $ctlRep->segundosTotales($arrDatos);
// calculo segundos totales
$segsTotales = ($segsFijosUrb + $segsFijosInter + $segsCelurb + $segsCelinter + $segsInternac);
// calculo minutos totales
$minsTotales = date("H:i:s", mktime(0, 0, $segsTotales, 1, 1, 1970));
//minutos totales por tipo
$minsTotalesFU = date("H:i:s", mktime(0, 0, $segsFijosUrb, 1, 1, 1970));
$minsTotalesFI = date("H:i:s", mktime(0, 0, $segsFijosInter, 1, 1, 1970));
$minsTotalesCU = date("H:i:s", mktime(0, 0, $segsCelurb, 1, 1, 1970));
$minsTotalesCI = date("H:i:s", mktime(0, 0, $segsCelinter, 1, 1, 1970));
$minsTotalesI = date("H:i:s", mktime(0, 0, $segsInternac, 1, 1, 1970));
// precios totales por tipo de llam
$costoTotalFU = round(($pfu * ceil(($segsFijosUrb / 60))), 2);
$costoTotalFI = round(($pfi * ceil(($segsFijosInter / 60))), 2);
$costoTotalCU = round(($pcu * ceil(($segsCelurb / 60))), 2);
$costoTotalCI = round(($pci * ceil(($segsCelinter / 60))), 2);
$costoTotalI = round(($pi * ceil(($segsInternac / 60))), 2);
//calculo costo total
$costoTotal = ($costoTotalCU + $costoTotalCI + $costoTotalFU + $costoTotalFI + $costoTotalI);
//fila 3
$minsTotalesPorTipo = "<tr><td style='font-size: 16px;color: darkgreen'>Tiempo Consumido (hh:mm:ss)</td><td>$minsTotalesFU</td><td>$minsTotalesFI</td><td>$minsTotalesCU</td><td>$minsTotalesCI</td><td>$minsTotalesI</td><td style='color:darkred'>$minsTotales</td></tr>";
//fila 4
$costosTotalesPorTipo = "<tr>"
        . "<td style='font-size: 16px;color: darkgreen'>Costo Total ($)</td>"
        . "<td>$costoTotalFU</td>"
        . "<td>$costoTotalFI</td>"
        . "<td>$costoTotalCU</td>"
        . "<td>$costoTotalCI</td>"
        . "<td>$costoTotalI</td>"
        . "<td style='color:darkred'>$costoTotal</td>"
        . "</tr>";
//traigo grupo para titulo
$grupo = $ctlGroup->traerPorId($arrDatos);
foreach ($grupo as $clave => $valor) {
    foreach ($valor as $cla => $val) {
        foreach ($val as $c => $v) {
            if ($c == 'groupName') {
                $nomGrupo = $v;
            }
        }
    }
}
$tarifa = $ctlRep->traerNomTarifa($arrDatos[0]);
foreach ($tarifa as $clave => $valor) {
    $nomTarifa = $valor;
}
$filasFU = $ctlRep->llamsFijosUrb($arrDatos, 1);
$filasFI = $ctlRep->llamsFijosInterurb($arrDatos, 1);
$filasCU = $ctlRep->llamsCelsUrb($arrDatos, 1);
$filasCI = $ctlRep->llamsCelsInterurb($arrDatos, 1);
$filasI = $ctlRep->llamsInternac($arrDatos, 1);
//creo el archivo csv para exportacion de reporte de llamadas
$datosFU = $ctlRep->llamsFijosUrb($arrDatos, false);
$datosFI = $ctlRep->llamsFijosInterurb($arrDatos, false);
$datosCU = $ctlRep->llamsCelsUrb($arrDatos, false);
$datosCI = $ctlRep->llamsCelsInterurb($arrDatos, false);
$datosI = $ctlRep->llamsInternac($arrDatos, false);
$nombre_fichero = '/tmp/callsPlainReport.csv';
$Columnas = $ctlRep->traerColumnas();
$fileHandler = fopen($nombre_fichero, 'w');
fwrite($fileHandler, $Columnas);
foreach ($datosFU as $clave => $valor) {
    $cad = '';
    foreach ($valor as $cla => $val) {
        if ($cla == 'tipollm') {
            $cad .= PHP_EOL . "$val,";
        } else if ($cla == 'fecha') {
            $cad .="$val,";
        } else if ($cla == 'hora') {
            $cad .="$val,";
        } else if ($cla == 'src') {
            $cad .="$val,";
        } else if ($cla == 'userfield') {
            $cad .="$val,";
        } else if ($cla == 'dst') {
            $cad .="$val,";
        } else if ($cla == 'duration') {
            $cad .="$val,";
        } else if ($cla == 'billsec') {
            $cad .="$val,";
        }
    }
    fwrite($fileHandler, $cad);
}
foreach ($datosFI as $clave => $valor) {
    $cad = '';
    foreach ($valor as $cla => $val) {
        if ($cla == 'tipollm') {
            $cad .= PHP_EOL . "$val,";
        } else if ($cla == 'fecha') {
            $cad .="$val,";
        } else if ($cla == 'hora') {
            $cad .="$val,";
        } else if ($cla == 'src') {
            $cad .="$val,";
        } else if ($cla == 'dst') {
            $cad .="$val,";
        } else if ($cla == 'duration') {
            $cad .="$val,";
        } else if ($cla == 'billsec') {
            $cad .="$val,";
        }
    }
    fwrite($fileHandler, $cad);
}
foreach ($datosCU as $clave => $valor) {
    $cad = '';
    foreach ($valor as $cla => $val) {
        if ($cla == 'tipollm') {
            $cad .= PHP_EOL . "$val,";
        } else if ($cla == 'fecha') {
            $cad .="$val,";
        } else if ($cla == 'hora') {
            $cad .="$val,";
        } else if ($cla == 'src') {
            $cad .="$val,";
        } else if ($cla == 'dst') {
            $cad .="$val,";
        } else if ($cla == 'duration') {
            $cad .="$val,";
        } else if ($cla == 'billsec') {
            $cad .="$val,";
        }
    }
    fwrite($fileHandler, $cad);
}
foreach ($datosCI as $clave => $valor) {
    $cad = '';
    foreach ($valor as $cla => $val) {
        if ($cla == 'tipollm') {
            $cad .= PHP_EOL . "$val,";
        } else if ($cla == 'fecha') {
            $cad .="$val,";
        } else if ($cla == 'hora') {
            $cad .="$val,";
        } else if ($cla == 'src') {
            $cad .="$val,";
        } else if ($cla == 'dst') {
            $cad .="$val,";
        } else if ($cla == 'duration') {
            $cad .="$val,";
        } else if ($cla == 'billsec') {
            $cad .="$val,";
        }
    }
    fwrite($fileHandler, $cad);
}
foreach ($datosI as $clave => $valor) {
    $cad = '';
    foreach ($valor as $cla => $val) {
        if ($cla == 'tipollm') {
            $cad .= PHP_EOL . "$val,";
        } else if ($cla == 'fecha') {
            $cad .="$val,";
        } else if ($cla == 'hora') {
            $cad .="$val,";
        } else if ($cla == 'src') {
            $cad .="$val,";
        } else if ($cla == 'dst') {
            $cad .="$val,";
        } else if ($cla == 'duration') {
            $cad .="$val,";
        } else if ($cla == 'billsec') {
            $cad .="$val,";
        }
    }
    fwrite($fileHandler, $cad);
}

function ReverseAndReplace($fecha) {
    $fecha2 = explode('/', $fecha);
    $fecha = array_reverse($fecha2);
    $fecha2 = implode('-', $fecha);
    return $fecha2;
}
?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
<script src="static/js/abm.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#detailedTable').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por pag.",
                "zeroRecords": "No Encontrado",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "infoEmpty": "Sin registros disponibles",
                "info": "_START_ a _END_ de _TOTAL_ filas",
            }

        });
    });
</script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalDetailedRep">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reporte detallado</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <a href="controllers/download.php?file=callsPlainReport.csv&task=export" class="btn btn-xs btn-warning">Exportar como Csv</a>
                    <div class="col-md-8 col-md-offset-1">
                        <table class="table table-striped table-bordered" id="detailedTable">
                            <thead>
                            <th>
                                Tipo Llam.
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Hora
                            </th>
                            <th>
                                Interno
                            </th>
                            <th>
                                Pin
                            </th>
                            <th>
                                Destino
                            </th>
                            <!--<th>
                                Duracion
                            </th>-->
                            <th>
                                Segundos Tarifados
                            </th>
                            </thead>
                            <tbody>
                                <?php
                                echo $filasFU;
                                echo $filasFI;
                                echo $filasCU;
                                echo $filasCI;
                                echo $filasI;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form>
    <div class="row">
        <div class="col-md-4 col-lg-offset-6">
            <input type='hidden' id="groupid" value="<?php echo $_POST['group'] ?>"/>
            <?php 
            if($arrDatos[1] != $arrDatos[2]){
                echo 'De la fecha <label id="fechaDe">'.$arrDatos[1].'</label> al <label id="fechaHasta">'.$arrDatos[2].'</label>';
            } else {
                echo 'En la fecha <label id="fechaDe">'.$arrDatos[1].'</label>';
            }
             if($arrDatos[3] != $arrDatos[4]){
                echo ', entre las <label id="horaDe">'.$arrDatos[3].'</label> y <label id="horaHasta">'.$arrDatos[4].'</label> hs.';
            } else {
                echo ', a las <label id="horaDe">'.$arrDatos[3].'</label> hs.';
            } 
            ?>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-6 col-lg-offset-2">
            <label style="font-size: 22px">Reporte del grupo:<em style="color: #be5c0d;"> <?php echo $nomGrupo ?></em></label><br>
            <label style="font-size: 14px">tarifa aplicada:<em style="color: #be5c0d;"> <?php echo $nomTarifa ?></em></label>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-striped table-bordered">
                <thead>
                <th>
                </th>
                <th>
                    Fijos Urbanos
                </th>
                <th>
                    Fijos Interurbanos
                </th>
                <th>
                    Moviles Urbanos
                </th>
                <th>
                    Moviles Interurbanos
                </th>
                <th>
                    Internacionales
                </th>
                <th>
                    Total
                </th>
                </thead>
                <tbody id='tblReport'>
                    <?php
                    echo $preciosPorMin;
                    echo $llamsTotalesPorTipo;
                    echo $minsTotalesPorTipo;
                    echo $costosTotalesPorTipo;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</form>