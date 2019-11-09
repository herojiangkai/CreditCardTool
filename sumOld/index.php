<?php
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('totalAmountTransaction.db');
      }
   }

   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   }

   $sql="delete from t_credit_card_user_input_details";
   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }

   $targetDirArray=array("../csvCash/done/","../csvAeon/done_except_sum/","../csvEposJiang/done/",
                        "../csvEposWang/done/","../csvBic/done/","../csv/done/",
                        "../csvLumine/done/","../csvFt/done/","../csvAeon/done_except_sum/done_all/",
                        "../csvToho/done_except_sum/","../csvToho/done_except_sum/done_all/");

   $sql=makeInsertSqlForAllCsv($targetDirArray);

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }

   $sql="SELECT substr(date_of_use,0,7) as yearMonth
               ,sum(usage_amount)      as totalAmount
         FROM t_credit_card_user_input_details
         group by yearMonth
         order by yearMonth desc;";
   $ret = $db->query($sql);
   ?>

<html>
<head>
   <title>過去月間集計</title>
   <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="theme-color" content="#DCDCDC">

</head>
<body>
   <h3 align="center">過去月間集計</h3>
   <div align="right"><a href="../index.php">入力画面</a></div>
   <br><br>

   <div align="center">
      <table border="1">
         <tr><th>年月</th><th>総額</th></tr>

<?php
while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
   echo "<tr>";
   echo "<td><a href='showMonthDetails.php?yearMonth=".$row['yearMonth']."'>".$row['yearMonth']."</a></td>";
   echo "<td align='right'>".$row['totalAmount']."</td>";
   echo "</tr>";
}
?>
      </table>
   </div>
</body>
</html>

   <?php

   $db->close();
   
   function makeInsertSqlForOneCsv($csvFilePath){
      $sql="";
      $csvFile = fopen($csvFilePath, "r") or die("Unable to open csv file-> ".$csvFilePath);
      while(!feof($csvFile)) {
          $currentLine=str_replace("'","''",fgets($csvFile));
          $currentColums=explode('","',$currentLine);
          if(sizeof($currentColums)>1){
             $sql.="insert into t_credit_card_user_input_details values(";
             $sql.="'".substr($currentColums[0],1)."',";
              for($i=1;$i<sizeof($currentColums)-1;$i++){
                $sql.="'$currentColums[$i]',";                  
             }
             $sql.="'".substr($currentColums[sizeof($currentColums)-1],0,-3)."',null,null,null,null,null);";
          }
      }
      fclose($csvFile);
      return $sql;
   }
   function getAllCsvFilePath($targetDirArray){
      $csvFilePathArray=array();
      foreach($targetDirArray as $targetDir){
         $file=scandir($targetDir);
         foreach($file as $csvFileName){
          if(strpos($csvFileName, ".csv")!==false){
            array_push($csvFilePathArray,$targetDir.$csvFileName);
          }
         }
      }
      return $csvFilePathArray;
   }
   function makeInsertSqlForAllCsv($targetDirArray){
      $csvFilePathArray=getAllCsvFilePath($targetDirArray);
      $sql="";
      foreach($csvFilePathArray as $csvFilePath){
         $sql.=makeInsertSqlForOneCsv($csvFilePath);
      }
      return $sql;
   }
?>