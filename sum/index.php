<ons-page>
    <ons-toolbar>
        <div class="right">
            <ons-toolbar-button onclick="fn.open()">
                <ons-icon icon="md-menu"></ons-icon>
            </ons-toolbar-button>
        </div>
        <div class="center">
        直近月間集計
        </div>
    </ons-toolbar>
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

   $targetDirArray=array("../csvCash/","../csvAeon/","../csvEposJiang/",
                        "../csvEposWang/","../csvBic/","../csv/",
                        "../csvLumine/","../csvFt/","../csvAeon/done_except_sum/",
                        "../csvToho/","../csvToho/done_except_sum/");

   $sql=makeInsertSqlForAllCsv($targetDirArray);
   
   $db->exec('PRAGMA synchronous = OFF;');//性能向上
   $db->exec('begin');//性能向上
   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }
   $db->exec('commit');//性能向上


   $sql="SELECT substr(date_of_use,0,7) as yearMonth
               ,sum(usage_amount)      as totalAmount
               ,count(1) as numberOfEntries
         FROM t_credit_card_user_input_details
         group by yearMonth
         order by yearMonth;";
   $ret = $db->query($sql);
   ?>

<html>
<head>
   <title>直近月間集計</title>
   <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="theme-color" content="#FF66CC">

</head>
<body>
   <br>
   <div align="right">
         <button class="toolbar-button toolbar-button--outline" onclick="window.location.href='/'" style="height:27px;width:100px">
            <a style="font-size:13px; vertical-align:2px;">入力画面</a>
         </button>
   </div>
   <br><br>

   <div align="center">
      <table border="1">
         <tr><th>年月</th><th>総額</th><th><a>明細数</a></th></tr>

<?php
while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
   echo "<tr>";
   echo "<td><a href='/sum/showMonthDetails.php?yearMonth=".$row['yearMonth']."'>".$row['yearMonth']."</a></td>";
   echo "<td align='right'>".$row['totalAmount']."</td>";
   echo "<td align='right'>".$row['numberOfEntries']."</td>";
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
             $sql.="'".rtrim(rtrim(rtrim($currentColums[sizeof($currentColums)-1],"\n"),"\r"),'"')."',null,null,null,null,null);";
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
</ons-page>