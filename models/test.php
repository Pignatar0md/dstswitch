<?php
for($i = 1; $i < 401; $i++) {// FIJOS URBANOS

    $link = mysqli_connect('localhost', 'dstswitch', 'fr33t3chs0lu710ns', 'Dstswitch');
    $sql = "insert into mycdr (calldate,src,dst,billsec,accountcode,userfield,amount,uniqueid) " .
        "values('2016-12-" . rand(1, 31) . " " . rand(10,19) .":". rand(10,59) .":". rand(10,59) ."','".
        rand(1001,1004)."','".
        rand(4250000,4250399)."',".
        rand(10,420).",'".
        rand(10,11)."',".
        rand(222,224).",".
        rand(0.9,45.4).",'".
        rand(312312323423.324328,847272727857.985726)."')";

    if($link) {
        $res = mysqli_query($link, $sql);
    } else {
        echo $link;
    }
}

for($i = 1; $i < 401; $i++) {// CEL URBANOS

    $link = mysqli_connect('localhost', 'dstswitch', 'fr33t3chs0lu710ns', 'Dstswitch');
    $sql = "insert into mycdr (calldate,src,dst,billsec,accountcode,userfield,amount,uniqueid) " .
        "values('2016-12-" . rand(1, 31) . " " . rand(10,19) .":". rand(10,59) .":". rand(10,59) ."','".
        rand(1001,1004)."','".
        rand(156215000,156215399)."',".
        rand(10,420).",'".
        rand(10,11)."',".
        rand(222,224).",".
        rand(0.9,45.4).",'".
        rand(312312323423.324328,847272727857.985726)."')";

    if($link) {
        $res = mysqli_query($link, $sql);
    } else {
        echo $link;
    }
}

for($i = 1; $i < 401; $i++) {// FIJOS INTERURBANOS

    $link = mysqli_connect('localhost', 'dstswitch', 'fr33t3chs0lu710ns', 'Dstswitch');
    $sql = "insert into mycdr (calldate,src,dst,billsec,accountcode,userfield,amount,uniqueid) " .
        "values('2016-12-" . rand(1, 31) . " " . rand(10,19) .":". rand(10,59) .":". rand(10,59) ."','".
        rand(1001,1004)."','".
        rand(0341425000,0341425399)."',".
        rand(10,420).",'".
        rand(10,11)."',".
        rand(222,224).",".
        rand(0.9,45.4).",'".
        rand(312312323423.324328,847272727857.985726)."')";

    if($link) {
        $res = mysqli_query($link, $sql);
    } else {
        echo $link;
    }
}

for($i = 1; $i < 401; $i++) {// CEL INTERURBANOS

    $link = mysqli_connect('localhost', 'dstswitch', 'fr33t3chs0lu710ns', 'Dstswitch');
    $sql = "insert into mycdr (calldate,src,dst,billsec,accountcode,userfield,amount,uniqueid) " .
        "values('2016-12-" . rand(1, 31) . " " . rand(10,19) .":". rand(10,59) .":". rand(10,59) ."','".
        rand(1001,1004)."','".
        rand(0341156215000,0341156215399)."',".
        rand(10,420).",'".
        rand(10,11)."',".
        rand(222,224).",".
        rand(0.9,45.4).",'".
        rand(312312323423.324328,847272727857.985726)."')";

    if($link) {
        $res = mysqli_query($link, $sql);
    } else {
        echo $link;
    }
}

for($i = 1; $i < 401; $i++) {// INTERNACIONALES

    $link = mysqli_connect('localhost', 'dstswitch', 'fr33t3chs0lu710ns', 'Dstswitch');
    $sql = "insert into mycdr (calldate,src,dst,billsec,accountcode,userfield,amount,uniqueid) " .
        "values('2016-12-" . rand(1, 31) . " " . rand(10,19) .":". rand(10,59) .":". rand(10,59) ."','".
        rand(1001,1004)."','".
        rand(540941556918000,540941556918399)."',".
        rand(10,420).",'".
        rand(10,11)."',".
        rand(222,224).",".
        rand(0.9,45.4).",'".
        rand(312312323423.324328,847272727857.985726)."')";

    if($link) {
        $res = mysqli_query($link, $sql);
    } else {
        echo $link;
    }
}
mysqli_close($link);