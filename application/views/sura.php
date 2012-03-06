<hr />Ô
<?php var_dump($SuraInfo);?>
<hr />
<p dir="rtl">
<?php
foreach ($Sura as $key => $Aya) {
    echo $Aya['text']." ( {$Aya['aya']} ) ";
}
?>
</p>
<hr />