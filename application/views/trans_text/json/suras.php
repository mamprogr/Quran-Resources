<?php
    header('Content-type: text/json');
    header('Content-type: application/json');
    $OutPut = array('Suras' => $Suras, 'SurasInfo' => $SurasInfo);
    echo json_encode($OutPut);
?>