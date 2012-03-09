<?php

header('Content-type: text/xml');

$xml_Suras = new SimpleXMLElement('<Suras/>');

foreach ($Suras as $Index => $Sura) {
    $xml_Sura = $xml_Suras->addChild('Sura');
    $xml_Sura->addAttribute('index', $SurasInfo[$Index]['index']);
    $xml_Sura->addAttribute('ayas' , $SurasInfo[$Index]['ayas'] );
    $xml_Sura->addAttribute('start', $SurasInfo[$Index]['start']);
    $xml_Sura->addAttribute('name' , $SurasInfo[$Index]['name'] );
    $xml_Sura->addAttribute('tname', $SurasInfo[$Index]['tname']);
    $xml_Sura->addAttribute('ename', $SurasInfo[$Index]['ename']);
    $xml_Sura->addAttribute('type' , $SurasInfo[$Index]['type'] );
    $xml_Sura->addAttribute('order', $SurasInfo[$Index]['order']);
    $xml_Sura->addAttribute('rukus', $SurasInfo[$Index]['rukus']);
    
    foreach ($Sura as $Aya) {
        $xml_Aya = $xml_Sura->addChild('Aya',$Aya['text']);
        $xml_Aya->addAttribute('index', $Aya['index']);
        $xml_Aya->addAttribute('sura', $Aya['sura']);
        $xml_Aya->addAttribute('aya', $Aya['aya']);
    }
    
}



echo $xml_Suras->asXML();

?>