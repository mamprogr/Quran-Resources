<?php
    header('Content-type: text');
    foreach ($Ayas as $key => $Aya) {
        echo "{$Aya['aya']}. {$Aya['text']}\n";
    }
?>