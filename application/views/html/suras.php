<hr />
<p dir="rtl">
<?php
foreach ($Suras as $key => $Sura) {
    var_dump($SurasInfo[$key]);
    foreach ($Sura as $key => $Aya) {
        echo $Aya['text']." ( {$Aya['aya']} ) ";
    }
    echo '<hr />';
    //echo $Aya['text']." ( {$Aya['aya']} ) ";
}
?>
</p>
<hr />