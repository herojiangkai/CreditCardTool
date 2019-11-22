<?php
$cardTypeName=$_POST["cardTypeName"];
$folderPath=$_POST["folderPath"];
$csvFileName=$_POST["csvFileName"];

if(rename($folderPath.$csvFileName,$folderPath."bk/".$csvFileName."_".date("YmdHis").".csv") or die("something went wrong while backing up the existing file")){
    $csvFile = fopen($folderPath.$csvFileName, "a");
    $lineNumber=1;
    while(isset($_POST["usedDate_$lineNumber"])){

        $receiptNo=$_POST["receiptNo_$lineNumber"] ;
        $usedDate= str_replace("-","",$_POST["usedDate_$lineNumber"]) ;
        $usedTime= $_POST["usedTime_$lineNumber"] ;
        $user= $_POST["user_$lineNumber"] ;
        $storeName= $_POST["storeName_$lineNumber"] ;
        $paymentSplitTimes= $_POST["paymentSplitTimes_$lineNumber"] ;
        $amount= $_POST["amount_$lineNumber"] ;
        $paymentMethod= $_POST["paymentMethod_$lineNumber"] ;
        $comment= $_POST["comment_$lineNumber"] ;

        $csvText=array($receiptNo,$usedDate,$usedTime,$user,$storeName,$paymentSplitTimes,$amount,$paymentMethod,$comment);
        $csvText=addDoubleQuotationForElements($csvText);
        fwrite($csvFile, implode(",", $csvText)."\r\n");
        $lineNumber+=1;
    }

fclose($csvFile);

header("Location: showCsvDetails.php?cardTypeName=$cardTypeName&folderPath=$folderPath&csvFileName=$csvFileName");

}else{
    echo "something went wrong while backing up the existing file";
}




function addDoubleQuotationForElements($array){
    for ($i=0; $i<count($array); $i++) {
        $array[$i]='"'.$array[$i].'"';
    }
    return $array;
}

?>