<?php

$tags = array("champagnes", "champagnes", "champane", "electrique", "éléctrique", "téléphone", "telephone", "voiture", "alcool", "alcol", "alcool", "champagne", "meuble");
var_dump($tags);
$tags_count = array_count_values($tags);
var_dump($tags_count);

foreach ($tags_count as $tag => $count) {
    if (substr($tag, -1) === "s") {
        echo (" S detected in " . $tag);
        $singular = substr($tag, 0, -1);
        var_dump("singular is :" . $singular);

        if (array_key_exists($singular, $tags_count)) {
            var_dump("singular detected in array :" . $singular);
            unset($tags_count[$singular]);
            var_dump($singular . " removed from array");
            var_dump($tags_count);
        }
    } else {
        echo (" no S  " . $tag);
        $plurial = $tag  . "s";
        var_dump($plurial);
    }
}
