<?php
$url = 'http://gfix.gq/index.php';
 
// POST送信するデータ
$data = array(
    'timestampOfCall' => '['.date("Y-m-d H:i:s").']'//このデータはダミー、なしでOK
);
 
// URL エンコード
$data = http_build_query($data, "", "&");

// ヘッダーで認証情報及び戻り値データ形式を指定
$headers = array(
    'Authorization: Basic '.base64_encode('jiangkai:i12340262'),//サーバ認証
    'Content-type: application/x-www-form-urlencoded ',
 ); 

// 送信時のオプション
$options = array('http' => array(
    'method' => 'POST',//GETもOK
    'header' => implode("\r\n", $headers),
    'content' => $data,
));
 
// ストリームコンテキストを作成
$options = stream_context_create($options);
 
// file_get_contents
$contents = file_get_contents($url, false, $options);
 
// 出力
echo $contents;
?>