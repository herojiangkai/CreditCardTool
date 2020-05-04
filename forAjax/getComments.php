<?php
$queryFilter=$_GET["term"];
$contentsArray = array();

class MyDB extends SQLite3
{
   function __construct($path)
   {
      $this->open($path);
   }
}

$db = new MyDB('../sum/totalAmountTransaction.db');
if(!$db){
   echo $db->lastErrorMsg();
} 
$sql="SELECT replace(trim(LOWER(comment)),'　',' ') as comment_edited
,max(date_of_use) as date_of_use
FROM t_credit_card_user_input_details
where comment like '%$queryFilter%'
and comment <>''
group by comment_edited
order by date_of_use desc
limit 50;";
$ret = $db->query($sql); 
while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
    $storeName=$row['comment_edited'];
    array_push($contentsArray,$storeName);
}
$db->close();


$db2 = new MyDB('../sumOld/totalAmountTransaction.db');
if(!$db2){
   echo $db2->lastErrorMsg();
} 
$sql2="SELECT replace(trim(LOWER(comment)),'　',' ') as comment_edited
,max(date_of_use) as date_of_use
FROM t_credit_card_user_input_details
where comment like '%$queryFilter%'
and comment <>''
group by comment_edited
order by date_of_use desc
limit 50;";
$ret2 = $db2->query($sql2); 
while($row = $ret2->fetchArray(SQLITE3_ASSOC) ){
    $storeName=$row['comment_edited'];
    if(!in_array($storeName,$contentsArray)){
        array_push($contentsArray,$storeName);
    }
}
$db2->close();

header('Content-Type:application/json');
echo json_encode($contentsArray);
//echo implode(',',$contentsArray);
// echo count($contentsArray);
?>