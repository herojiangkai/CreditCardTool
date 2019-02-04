<?php session_start();

$csvWriteResult="fault";

$receiptNo=$_POST["receiptNo"] ;
$usedDate= str_replace("-","",$_POST["usedDate"]) ;
$usedTime= $_POST["usedTime"] ;
$user= $_POST["user"] ;
$storeName= $_POST["storeName"] ;
$paymentSplitTimes= $_POST["paymentSplitTimes"] ;
$amount= $_POST["amount"] ;
$paymentMethod= $_POST["paymentMethod"] ;
$comment= $_POST["comment"] ;

$csvText=array($receiptNo,$usedDate,$usedTime,$user,$storeName,$paymentSplitTimes,$amount,$paymentMethod,$comment);
$csvText=addDoubleQuotationForElements($csvText);

if (strpos($user, "現金")!==false) {
    $csvOutDir="csvCash/";
    $csvFileName=substr($usedDate, 0, 6)."_cash";
}else if(strpos($user, "aeon")!==false){
    $csvOutDir="csvAeon/";
    $csvFileName=datePeriodAdjuestedByClosingDay($usedDate,10)."_aeon";
}else if(strpos($user, "epos_姜")!==false){
    $csvOutDir="csvEposJiang/";
    $csvFileName=datePeriodAdjuestedByClosingDay($usedDate,27)."_epos_jiang";
}else if(strpos($user, "epos_王")!==false){
    $csvOutDir="csvEposWang/";
    $csvFileName=datePeriodAdjuestedByClosingDay($usedDate,27)."_epos_wang";
}else if(strpos($user, "bic")!==false){
    $csvOutDir="csvBic/";
    $csvFileName=substr($usedDate, 0, 6)."_bic";
}else if(strpos($user, "lumine")!==false){
    $csvOutDir="csvLumine/";
    $csvFileName=substr($usedDate, 0, 6)."_lumine";
}else if(strpos($user, "ft")!==false){
    $csvOutDir="csvFt/";
    $csvFileName=substr($usedDate, 0, 6)."_ft";
}else{
    $csvOutDir="csv/";
    $csvFileName=substr($usedDate, 0, 6);
}



$csvFile = fopen($csvOutDir.$csvFileName.".csv", "a");
fwrite($csvFile, implode(",", $csvText)."\r\n");
fclose($csvFile);

$csvWriteResult="登録成功!";
$_SESSION['csvWriteResult']=$csvWriteResult;
header("Location: index.php");


function addDoubleQuotationForElements($array){
    for ($i=0; $i<count($array); $i++) {
        $array[$i]='"'.$array[$i].'"';
    }
    return $array;
}

function datePeriodAdjuestedByClosingDay($usedDate,$closingDay){
    //20190104  ⇒　20181211-20190110
    //20181215  ⇒　20181211-20190110
    $year=(int)(substr($usedDate, 0, 4));
    $month=(int)(substr($usedDate, 4, 2));
    $day=(int)(substr($usedDate, 6, 2));
    
    if($day>$closingDay){
        $startYear=$year;
        $startMonth=$month;
        $endMonth=$month+1;
        if($endMonth>12){
            $endMonth=$endMonth-12;
            $endYear=$year+1;
        }else{
            $endYear=$year;
        }
    }else{
        $endYear=$year;
        $endMonth=$month;
        $startMonth=$month-1;
        if($startMonth<1){
            $startMonth=$startMonth+12;
            $startYear=$year-1;
        }else{
            $startYear=$year;
        }
    }
    return $startYear.sprintf("%02d", $startMonth).sprintf("%02d", $closingDay+1).
            "-".$endYear.sprintf("%02d", $endMonth).sprintf("%02d", $closingDay);
}