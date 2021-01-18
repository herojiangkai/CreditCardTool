<?php 

$link= $_POST["link"] ;
$comment= $_POST["comment"] ;



$csvText=array($comment,$link);
$csvText=addDoubleQuotationForElements($csvText);



f_add_first_row(implode(",", $csvText)."\r\n","links.txt");

header("Location: /l");


function addDoubleQuotationForElements($array){
    for ($i=0; $i<count($array); $i++) {
        $array[$i]='"'.$array[$i].'"';
    }
    return $array;
}

function f_add_first_row($str, $file_name) {

    // 事前にファイルの内容を取得
    $contents = file_get_contents($file_name);

    // 文字列を先頭に追加
    $contents = $str  . $contents;

    // 上書き 書き込み 
    $re = file_put_contents($file_name, $contents);

}

