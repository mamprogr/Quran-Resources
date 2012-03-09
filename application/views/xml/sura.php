<?php

header('Content-type: text/xml');

$xml_Suras = new SimpleXMLElement('<Suras/>');

$xml_Sura = $xml_Suras->addChild('Sura');
$xml_Sura->addAttribute('index', $SuraInfo['index']);
$xml_Sura->addAttribute('ayas' , $SuraInfo['ayas'] );
$xml_Sura->addAttribute('start', $SuraInfo['start']);
$xml_Sura->addAttribute('name' , $SuraInfo['name'] );
$xml_Sura->addAttribute('tname', $SuraInfo['tname']);
$xml_Sura->addAttribute('ename', $SuraInfo['ename']);
$xml_Sura->addAttribute('type' , $SuraInfo['type'] );
$xml_Sura->addAttribute('order', $SuraInfo['order']);
$xml_Sura->addAttribute('rukus', $SuraInfo['rukus']);

foreach ($Sura as $Aya) {
    $xml_Aya = $xml_Sura->addChild('Aya',$Aya['text']);
    $xml_Aya->addAttribute('index', $Aya['index']);
    $xml_Aya->addAttribute('sura', $Aya['sura']);
    $xml_Aya->addAttribute('aya', $Aya['aya']);
}

echo $xml_Suras->asXML();

?>