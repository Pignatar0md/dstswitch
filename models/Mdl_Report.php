<?php

include_once 'Connection.php';

/**
 * Description of Mdl_Report
 *
 * @author marcelo
 */
class Mdl_Report {

//put your code here
    function countCallsReport($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT count(*) as cdadLlam FROM mycdr where accountcode = $arrData[0] ";
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }
        switch ($arrData[5]) {
            case "internac":
                $sql .= "and length(dst) > 13 ";
                break;
            case "fijosurb":
                $sql .= "and length(dst) = 7 ";
                break;
            case "fijosinter":
                $sql .= "and length(dst) = 11 and dst like '0%' ";
                break;
            case "celurb":
                $sql .= "and length(dst) = 9 and dst like '15%' "; // cambiar a 9
                break;
            case "celinter":
                $sql .= "and length(dst) = 13 and dst like '0%' ";
                break;
            case "ceroochos":
                $sql .= "and length(dst) = 11 and dst like '08%' ";
                break;
        }
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
    return $result->fetch_assoc();
        //return $sql;
    }

    function sumTotalPrice($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT SUM(amount) as montoTotal from mycdr where accountcode = $arrData[0] ";
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }
        switch ($arrData[5]) {
            case "internac":
                $sql .= "and length(dst) > 13 ";
                break;
            case "fijosurb":
                $sql .= "and length(dst) = 7 ";
                break;
            case "fijosinter":
                $sql .= "and length(dst) = 11 and dst like '0%' ";
                break;
            case "celurb":
                $sql .= "and length(dst) = 9 and dst like '15%' "; // cambiar a 9
                break;
            case "celinter":
                $sql .= "and length(dst) = 13 and dst like '0%' ";
                break;
            case "ceroochos":
                $sql .= "and length(dst) = 11 and dst like '08%' ";
                break;
        }
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
                return $result->fetch_assoc();
    }

    function sumBillsecDuration($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT SUM(billsec) as segundosTarifados from mycdr where accountcode = $arrData[0] ";
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }
        switch ($arrData[5]) {
            case "internac":
                $sql .= "and length(dst) > 13 ";
                break;
            case "fijosurb":
                $sql .= "and length(dst) = 7 ";
                break;
            case "fijosinter":
                $sql .= "and length(dst) = 11 and dst like '0%' ";
                break;
            case "celurb":
                $sql .= "and length(dst) = 9 and dst like '15%' "; // cambiar a 9
                break;
            case "celinter":
                $sql .= "and length(dst) = 13 and dst like '0%' ";
                break;
            case "ceroochos":
                $sql .= "and length(dst) = 11 and dst like '08%' ";
                break;
        }
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
        return $result->fetch_assoc();
    }

    function InternacCallsReport($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT 'Internacionales' as tipollm,date_format(calldate,'%d/%m/%Y') as fecha,date_format(calldate,'%H:%i') as hora,
                src,accountcode,userfield,dst,amount,billsec FROM mycdr where accountcode = $arrData[0] ";
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }
        $sql .= "and length(dst) > 13 "; //internac
        $sql .= " order by fecha";
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
        while ($row = $result->fetch_assoc()) {
            $arregloRes[] = $row;
        }
        return $arregloRes;
    }

    function UrbanCelCallsReport($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT 'Cel.Urbanos' as tipollm,date_format(calldate,'%d/%m/%Y') as fecha,date_format(calldate,'%H:%i') as hora,
                src,accountcode,userfield,dst,amount,billsec FROM mycdr where accountcode = $arrData[0] ";
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }
        $sql .= "and length(dst) = 9 and dst like '15%' "; //cel urb (cambiar a 9)
        $sql .= " order by fecha";
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
        while ($row = $result->fetch_assoc()) {
            $arregloRes[] = $row;
        }
        return $arregloRes;
    }

    function InterurbanCelCallsReport($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT 'Cel.Interurbanos' as tipollm,date_format(calldate,'%d/%m/%Y') as fecha,date_format(calldate,'%H:%i') as hora,
              src,accountcode,userfield,dst,amount,billsec FROM mycdr where accountcode = $arrData[0] ";
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }
        $sql .= "and length(dst) = 13 and dst like '0%' "; //cel inter
        $sql .= " order by fecha";
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
        while ($row = $result->fetch_assoc()) {
            $arregloRes[] = $row;
        }
        return $arregloRes;
    }

    function InterurbanPhoneCallsReport($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT 'Fijos Interurbanos' as tipollm,date_format(calldate,'%d/%m/%Y') as fecha,date_format(calldate,'%H:%i') as hora,
                src,accountcode,userfield,dst,amount,billsec FROM mycdr where accountcode = $arrData[0] ";
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }
        $sql .= "and length(dst) = 11 and dst like '0%' "; // fijo inter
        $sql .= " order by fecha";
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
        while ($row = $result->fetch_assoc()) {
            $arregloRes[] = $row;
        }
        return $arregloRes;
    }

    function UrbanPhoneCallsReport($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT 'Fijos Urbanos' as tipollm,date_format(calldate,'%d/%m/%Y') as fecha,date_format(calldate,'%H:%i') as hora
                 ,src,accountcode,userfield,dst,amount,billsec FROM mycdr where accountcode = $arrData[0] "; //groupid = $arrData[0]
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }//fijo urb
        $sql .= "and length(dst) = 7 order by fecha";
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
        while ($row = $result->fetch_assoc()) {
            $arregloRes[] = $row;
        }
        return $arregloRes;
    }

    function getColumns() {
        $sql = "SELECT 'tipoLlam' as 'tipoLlam','fecha' as 'fecha','hora' as 'hora','extension' as 'extension',
		'pin' as 'pin','destino' as 'destino','segundosTarifados' as 'segundosTarifados' 
                FROM mycdr group by tipoLlam";
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
        while ($row = $result->fetch_assoc()) {
            $arregloRes[] = $row;
        }
        return $arregloRes;
    }

    function ZeroEightCallsReport($arrData) {
        $cnn = new Connection("Dstswitch");
        $cnn->Connect();
        $sql = "SELECT 'Fijos Urbanos' as tipollm,date_format(calldate,'%d/%m/%Y') as fecha,date_format(calldate,'%H:%i') as hora
                 ,src,accountcode,userfield,dst,amount,billsec FROM mycdr where accountcode = $arrData[0] "; //groupid = $arrData[0]
        if ($arrData[1] != $arrData[2]) {//fecha ini distinto de fecha fin
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[4]%' ";
            } else {
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[2] $arrData[3]%' ";
            }
        } else {
            if ($arrData[3] != $arrData[4]) {// hora ini distinto de hora fin
                $sql .= " and calldate between '$arrData[1] $arrData[3]%' and '$arrData[1] $arrData[4]%' ";
            } else {
                $sql .= " and calldate like '$arrData[1] $arrData[3]%' ";
            }
        }
        //cero ochocientos
        $sql .= "and length(dst) = 11 and dst like '08%' ";
        $lnk = $cnn->GetLink();
        $result = mysqli_query($lnk, $sql);
        $cnn->Connect_close($lnk);
        while ($row = $result->fetch_assoc()) {
            $arregloRes[] = $row;
        }
        return $arregloRes;
    }

}
