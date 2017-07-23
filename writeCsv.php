<?php
$csvWriteResult="fault";

$receiptNo=$_POST["receiptNo"] ;
$usedDate= $_POST["usedDate"] ;
$usedTime= $_POST["usedTime"] ;
$user= $_POST["user"] ;
$storeName= $_POST["storeName"] ;
$paymentSplitTimes= $_POST["paymentSplitTimes"] ;
$amount= $_POST["amount"] ;
$paymentMethod= $_POST["paymentMethod"] ;
$comment= $_POST["comment"] ;

$csvText=array($receiptNo,$usedDate,$usedTime,$user,$storeName,$paymentSplitTimes,$amount,$paymentMethod,$comment);
$csvText=addDoubleQuotationForElements($csvText);


$csvFile = fopen(substr($usedDate, 0, 6).".csv", "a");
fputcsv($csvFile, $csvText, ',', ' ');
fwrite($csvFile, "\r\n");
fclose($csvFile);

$csvWriteResult="success";
$_SESSION['csvWriteResult']=$csvWriteResult;
header("Location: index.php");


function addDoubleQuotationForElements($array)
{
    for ($i=0; $i<count($array); $i++) {
        $array[$i]='"'.$array[$i].'"';
    }
    return $array;
}
