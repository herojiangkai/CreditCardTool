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
                        "../csvLumine/","../csvFt/","../csvToho/",                        
                        "../csvCash/done/","../csvAeon/done_except_sum/","../csvEposJiang/done/",
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

   $sql2="SELECT substr(date_of_use,0,5) as year
               ,sum(usage_amount)      as totalAmount
         FROM t_credit_card_user_input_details
         group by year
         order by year desc;";
   $ret2 = $db->query($sql2);

   $pastDate1y=date("Ymd",strtotime("-1 year"));
   $pastDate6m=date("Ymd",strtotime("-6 month"));
   $pastDate3m=date("Ymd",strtotime("-3 month"));
   $pastDate1m=date("Ymd",strtotime("-1 month"));

   $sql3="SELECT '4.直近1年' as prd
         ,sum(usage_amount)      as totalAmount
         FROM t_credit_card_user_input_details
         where date_of_use > $pastDate1y

         union

         SELECT '3.直近半年' as prd
         ,sum(usage_amount)      as totalAmount
         FROM t_credit_card_user_input_details
         where date_of_use > $pastDate6m
         
         union

         SELECT '2.直近3ヶ月' as prd
         ,sum(usage_amount)      as totalAmount
         FROM t_credit_card_user_input_details
         where date_of_use > $pastDate3m
         
         union

         SELECT '1.直近1ヶ月' as prd
         ,sum(usage_amount)      as totalAmount
         FROM t_credit_card_user_input_details
         where date_of_use > $pastDate1m;";
   $ret3 = $db->query($sql3);
   ?>

<html>
<head>
   <title>過去集計</title>
   <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="theme-color" content="#DCDCDC">

    <script type="text/javascript">
      function sortTime(title) {                   //title参数是所点击的表头所在的单元格对象
          var a = title.cellIndex;                //获取其单元格在本列中的位置
          var table = document.getElementById(title.parentNode.parentNode.parentNode.id).tBodies[0];  //获取到table的第一个tbody对象(当然这里只有一个)
          var rows = table.rows;
          var arr = new Array();                        //声明一个array对象来储存rows
          for (var i = 0; i < rows.length; i++) {
              arr.push(rows[i]);                              //将rows存储至array数组
          }
          if (table.sortFlag == a) {            //使用table对象的sortFlag属性作为排序的标记，如果这个标记等于当前列，则按此列倒序输出
              arr.reverse();
          }else if(a===1){                                       //内容是数字的两列
            arr.sort(function(r1, r2) {             //使用array对象的sort函数
                  var t1 = Number(r1.cells[a].innerHTML);　　　　　　//格式为：function(a,b){}比较a,b返回比较结果
                  var t2 = Number(r2.cells[a].innerHTML);                 //如果a>b，则返回正整数，a=b返回0，a<b返回负整数
                  return t1-t2;
              });
          }else{
            arr.sort(function(r1, r2) {            
                  var t1 = r1.cells[a].innerHTML;　
                  var t2 = r2.cells[a].innerHTML;  
                  return t1.localeCompare(t2);
              });
          }
          for (var i = 0; i < arr.length; i++) {
              table.appendChild(arr[i]);                      //将排序结果输出到table中。
          }
          table.sortFlag = a;
      }
  </script>

</head>
<body>
   <h3 align="center">過去集計</h3>
   <div align="right"><a href="../index.php">入力画面</a></div>
   <div align="center"">
      <a <?php echo $_GET["option"]=="1y"?"":'href="sumByStore.php?option=1y&startDate='.date("Ymd",strtotime("-1 year")).'&endDate='.date("Ymd").'"'?>>利用店別集計</a>
      <a <?php echo $_GET["option"]=="1y"?"":'href="sumByUser.php?option=1y&startDate='.date("Ymd",strtotime("-1 year")).'&endDate='.date("Ymd").'"'?>>利用区分別集計</a>
   </div>
   <br>

   <div align="center">
      <table><tr>
      
      <td valign="top">
      <table border="1"  id="tbSort3">
      <thead>
      <tr>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">期間</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">総額</a></th>
      </tr>
      </thead>
      <tbody>

<?php
while($row = $ret3->fetchArray(SQLITE3_ASSOC) ){
   echo "<tr>";
   echo "<td>".$row['prd']."</td>";
   echo "<td align='right'>".$row['totalAmount']."</td>";
   echo "</tr>";
}
?>
      </tbody>
      </table><br>
      <table border="1"  id="tbSort2">
      <thead>
      <tr>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">年</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">総額</a></th>
      </tr>
      </thead>
      <tbody>

<?php
while($row = $ret2->fetchArray(SQLITE3_ASSOC) ){
   echo "<tr>";
   echo "<td><a href='showMonthDetails.php?yearMonth=".$row['year']."'>".$row['year']."</a></td>";
   echo "<td align='right'>".$row['totalAmount']."</td>";
   echo "</tr>";
}
?>
      </tbody>
      </table></td>
      <td>
      <table border="1"  id="tbSort">
      <thead>
      <tr>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">年月</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">総額</a></th>
      </tr>
      </thead>
      <tbody>

<?php
while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
   echo "<tr>";
   echo "<td><a href='showMonthDetails.php?yearMonth=".$row['yearMonth']."'>".$row['yearMonth']."</a></td>";
   echo "<td align='right'>".$row['totalAmount']."</td>";
   echo "</tr>";
}
?>
      </tbody>
      </table></td>
      </tr>
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