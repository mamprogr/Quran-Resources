<style>
    .suraName {text-align: center; font-size: 20px; padding: 10px 0px;
        border: 1px solid #D4DDCC; background-color: #E4EEDC; margin-top: 7px;}
    .aya {font-family: traditional arabic; direction: rtl; font-size: 28px;
        padding: 10px; background-color: #EEF8E5; border: 1px solid #D4DDCC; border-top: 0px;}
    .aya:hover {background-color: #F7FCE3;}
    .ayaNum {color: green; font-size: smaller;}
    .sign {font-family: times new roman; font-size: 0.9em; color: #FB7600;}
    .footer {text-align: center; margin: 20px 0px; color: #222; font-family: Arial;
        background-color: #f4f4ff; border: 1px solid #ccd; padding: 3px; font: 12px Verdana;}
</style>
<p dir="rtl">
    
<?php
foreach ($Suras as $key => $Sura) {
    //var_dump($SurasInfo[$key]);
    $Type = $SurasInfo[$key]['type'] == 'Medinan'? 'مدنية':'مكية';
    echo "<div class=suraName>سورة {$SurasInfo[$key]['name']} &nbsp&nbsp&nbsp<span style='font-size: 15px;'>آياتها: {$SurasInfo[$key]['ayas']} / $Type</span></div>";
    if ($SurasInfo[$key]['index'] != 1) {
        echo "<div class=aya>بِسمِ اللَّهِ الرَّحمٰنِ الرَّحيمِ</div>";
    }
    foreach ($Sura as $key => $Aya) {
        $Aya['text'] = preg_replace('/ ([ۖ-۩])/u', '<span class="sign">&nbsp;$1</span>', $Aya['text']);
        echo "<div class=aya><span class=ayaNum>{$Aya['aya']}. </span>{$Aya['text']}</div>";
    }
    //echo $Aya['text']." ( {$Aya['aya']} ) ";
}
?>
</p>