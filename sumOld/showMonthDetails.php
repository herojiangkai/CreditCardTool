<?php 


$startDate="19000101";
$endDate="30001231";
$store="";
$startAmount="-999999999";
$endAmount="999999999";
$users="''";
$paymentMethod="";
$comment="";

if(isset($_GET["startDate"])&&strlen($_GET["startDate"])>0){
    $startDate=str_replace("-","",$_GET["startDate"]);
}
if(isset($_GET["endDate"])&&strlen($_GET["endDate"])>0){
    $endDate=str_replace("-","",$_GET["endDate"]);
}
if(isset($_GET["store"])){
    $store=str_replace("'","''",$_GET["store"]);
}
if(isset($_GET["startAmount"])&&strlen($_GET["startAmount"])>0){
    $startAmount=$_GET["startAmount"];
}
if(isset($_GET["endAmount"])&&strlen($_GET["endAmount"])>0){
    $endAmount=$_GET["endAmount"];
}
if(isset($_GET["users"])){
    $users="'".implode("','",$_GET["users"])."'";
}
if(isset($_GET["paymentMethod"])){
    $paymentMethod=str_replace("'","''",$_GET["paymentMethod"]);
}
if(isset($_GET["comment"])){
    $comment=str_replace("'","''",$_GET["comment"]);
}


?>
<html>
<head>
    <title>過去詳細　<?php echo isset($_GET["yearMonth"])?$_GET["yearMonth"]:(isset($_GET["store"])?$_GET["store"]:$_GET["user"])." $startDate~$endDate"?></title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#DCDCDC">
    
    <script type="text/javascript">
      function sortTime(title) {                   //title参数是所点击的表头所在的单元格对象
          var a = title.cellIndex;                //获取其单元格在本列中的位置
          var table = document.getElementById("tbSort").tBodies[0];  //获取到table的第一个tbody对象(当然这里只有一个)
          var rows = table.rows;
          var arr = new Array();                        //声明一个array对象来储存rows
          for (var i = 0; i < rows.length; i++) {
              arr.push(rows[i]);                              //将rows存储至array数组
          }
          if (table.sortFlag == a) {            //使用table对象的sortFlag属性作为排序的标记，如果这个标记等于当前列，则按此列倒序输出
              arr.reverse();
          }else if(a===5||a===6){                                       //内容是数字的两列
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
    <h3 align="center">過去詳細　<?php echo isset($_GET["yearMonth"])?$_GET["yearMonth"]:(isset($_GET["store"])?$_GET["store"]:$_GET["user"])." $startDate~$endDate"?></h3>
    <div align="right">
        <a href="../index.php">入力画面</a>
        <a href="javascript:history.go(-1)">戻る</a>
    </div>
    <div align="left">
        <a href="javascript:void(0)" onclick="location.reload()">表示順reset</a>
    </div>
    <div align="center">
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

        if(isset($_GET["action"])){
            $sql="select * from t_credit_card_user_input_details 
              where date_of_use between $startDate and $endDate
              and store_name_user_input like '%$store%'
              and usage_amount between $startAmount and $endAmount
              and card_user in ($users)
              and payment_method like '%$paymentMethod%'
              and comment like '%$comment%'
              order by date_of_use desc;";
        }else if(isset($_GET["store"])){
            $sql="select * from t_credit_card_user_input_details 
              where store_name_user_input ='".$_GET["store"]."'
              and date_of_use between $startDate and $endDate
              order by date_of_use desc;";
        }else if(isset($_GET["user"])){
            $sql="select * from t_credit_card_user_input_details 
              where card_user ='".$_GET["user"]."'
              and date_of_use between $startDate and $endDate
              order by date_of_use desc;";
        }else{
            $desc=strlen($_GET["yearMonth"])==4?"desc":"";
            $sql="select * from t_credit_card_user_input_details 
              where date_of_use like'".$_GET["yearMonth"]."%'
              order by date_of_use $desc;";
        }

        $ret = $db->query($sql);

        $rowCnt =0;
        while($ret->fetchArray(SQLITE3_ASSOC)){
            $rowCnt++;
        }
        echo "<font color='red'>$rowCnt</font>件の検索結果";
      ?>
    </div>
    <table border="1" id="tbSort">
    <thead>
        <tr>
        <th onclick="sortTime(this);"><a href="javascript:void(0)">レシート・注文番号</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">利用日</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">利用時刻</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">利用区分</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">利用店名</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">分割支払回数</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">利用金額</a></a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">支払方法</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">備考</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        $totalAmount=0;
        $lastDate="";
        $bgcolor="";
        $bgcolorChangeCount=0;
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            if($row['date_of_use']!=$lastDate){
                $bgcolor=changeBgcolor($bgcolorChangeCount++);
            }
            echo "<tr $bgcolor>";
            echo "<td>".$row['receipt_or_order_no']."</td>";
            echo "<td>".$row['date_of_use']."</td>";
            echo "<td>".$row['time_of_use']."</td>";
            echo "<td>".$row['card_user']."</td>";
            echo "<td>".$row['store_name_user_input']."</td>";
            echo "<td>".$row['payment_split_times']."</td>";
            echo "<td align='right'>".$row['usage_amount']."</td>";
            echo "<td>".$row['payment_method']."</td>";
            echo "<td>".$row['comment']."</td>";
            echo "</tr>";
            $totalAmount+=(int)$row['usage_amount'];
            
            $lastDate=$row['date_of_use'];
         }
        $db->close();
        echo "</tbody>";
        echo "<tr><th></th><th></th><th></th><th></th><th></th><th align='right'>総額⇒</th><th align='right'><font color='red'>$totalAmount</font></th><th></th><th></th></tr>";
        
        function changeBgcolor($bgcolorChangeCount){
            if($bgcolorChangeCount%2==0){
                return 'bgcolor="#CCFF99"';
            }else{
                return "";
            }
        }
        ?>
    </table>
</body>
</html>