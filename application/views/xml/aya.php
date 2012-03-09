<?php

header('Content-type: text/xml');

$xml_Ayas = new SimpleXMLElement('<Ayas/>');
//$Ayas->addAttribute('type', 'documentary');

$xml_Aya = $xml_Ayas->addChild('Aya',$Aya['text']);
$xml_Aya->addAttribute('index', $Aya['index']);
$xml_Aya->addAttribute('sura', $Aya['sura']);
$xml_Aya->addAttribute('aya', $Aya['aya']);

echo $xml_Ayas->asXML();

?>