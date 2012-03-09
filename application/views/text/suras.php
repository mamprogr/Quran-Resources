<?php
    header('Content-type: text');
    foreach ($Suras as $key => $Sura) {
        //var_dump($SurasInfo[$key]);
        $Type = $SurasInfo[$key]['type'] == 'Medinan'? 'مدنية':'مكية';
        echo "سورة {$SurasInfo[$key]['name']} - آياتها: {$SurasInfo[$key]['ayas']} - $Type\n\n";
        foreach ($Sura as $key => $Aya) {
            echo "{$Aya['aya']}. {$Aya['text']}\n";
        }
    }
?>