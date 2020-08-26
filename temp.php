<?php
    $json = file_get_contents("tempJson.json");

    $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(new RecursiveArrayIterator(json_decode($json, TRUE))),
                    RecursiveIteratorIterator::SELF_FIRST);
    $arr = [];

    foreach($jsonIterator as $key => $val) {
        foreach($val as $key1 => $val1){
            if(is_array($val)) {
                $arr[$key1]=$val1;
            }
        }
    }

    echo '<pre>';
    print_r($arr);
    echo '</pre>';
?>