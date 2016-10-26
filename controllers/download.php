<?php

if (isset($_GET['file'])) {
    $enlace = $_GET['file'] ? $_GET['file'] : '';
    $content_type = '';
    if ($_GET['task'] == 'Ej') {
        $content_type = 'text/csv';
        download_file($_SERVER['DOCUMENT_ROOT'] . '/dstswitch/' . $enlace, 'csvEj.csv', $content_type);
    } elseif ($_GET['task'] == 'export') {
        $content_type = 'text/csv';
        download_file('/tmp/' . $enlace, $enlace, $content_type);
    }
}

function download_file($archivo, $downloadfilename = null, $ctype) {
    if (file_exists($archivo)) {
        $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
        header('Content-Description: File Transfer');
        header("Content-Type: $ctype");
        header('Content-Disposition: attachment; filename=' . $downloadfilename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($archivo));
        ob_clean();
        flush();
        readfile($archivo);
        exit;
    } else {
        echo $archivo;
    }
}

?>
