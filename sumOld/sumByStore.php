<html>
<head>
    <title>取引先別集計</title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
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
          }else if(a>0){                                       //内容是数字的两列
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
    <h3 align="center">取引先別集計</h3>
    <div align="right">
        <a href="../index.php">入力画面</a>
        <a href="javascript:history.go(-1)">戻る</a>
    </div>
    <div align="left">
        <a href="javascript:void(0)" onclick="location.reload()">表示順reset</a>
    </div>
    <div align="center">
    <a <?php echo !isset($_GET["option"])?"":'href="sumByStore.php"'?>>すべて</a>
    <a <?php echo $_GET["option"]=="1y"?"":'href="sumByStore.php?option=1y&startDate='.date("Ymd",strtotime("-1 year")).'&endDate='.date("Ymd").'"'?>>直近1年</a>
    <a <?php echo $_GET["option"]=="6m"?"":'href="sumByStore.php?option=6m&startDate='.date("Ymd",strtotime("-6 month")).'&endDate='.date("Ymd").'"'?>>直近半年</a>
    <a <?php echo $_GET["option"]=="3m"?"":'href="sumByStore.php?option=3m&startDate='.date("Ymd",strtotime("-3 month")).'&endDate='.date("Ymd").'"'?>>直近3ヶ月</a>
    <a <?php echo $_GET["option"]=="1m"?"":'href="sumByStore.php?option=1m&startDate='.date("Ymd",strtotime("-1 month")).'&endDate='.date("Ymd").'"'?>>直近1ヶ月</a>

    <table border="1" id="tbSort">
    <thead>
        <tr>
        <th onclick="sortTime(this);"><a href="javascript:void(0)">利用店名</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">総金額</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">利用回数</a></th>
            <th onclick="sortTime(this);"><a href="javascript:void(0)">平均金額</a></th>
        </tr>
    </thead>
    <tbody>
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

        $startDate="19000101";
        $endDate="30001231";
        $leastUseCount="0";

        if(isset($_GET["startDate"])){
            $startDate=str_replace("-","",$_GET["startDate"]);
        }
        if(isset($_GET["endDate"])){
            $endDate=str_replace("-","",$_GET["endDate"]);
        }
        if(isset($_GET["leastUseCount"])){
            $startDate=$_GET["leastUseCount"];
        }
        
        
        $sql="select
                store_name_user_input as store,
                sum(usage_amount) as amount,
                count(1) as count,
                sum(usage_amount)/count(1) as average
            from
                t_credit_card_user_input_details
                where date_of_use between $startDate and $endDate
                group by store
                having count>$leastUseCount
                order by amount desc;";

        $ret = $db->query($sql);
        $storeCount=0;
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            echo "<tr>";
            echo "<td>".$row['store']."</td>";
            echo "<td>".$row['amount']."</td>";
            echo "<td>".$row['count']."</td>";
            echo "<td>".$row['average']."</td>";
            echo "</tr>";
            $storeCount+=1;
         }
        $db->close();
        echo "</tbody>";
        echo "<tr><th align='right'><font color='red'>$storeCount</font></th><th align='right'>⇐総利用店数</th><th></th><th></th></tr>"
        ?>
    </table>
    </div>
</body>
</html>