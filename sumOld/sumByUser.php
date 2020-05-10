<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">


    <link rel="stylesheet" href="/OnsenUI/OnsenUI-dist-2.10.10/css/onsenui.css">
    <link rel="stylesheet" href="/OnsenUI/OnsenUI-dist-2.10.10/css/onsen-css-components.min.css">
    <script src="/OnsenUI/OnsenUI-dist-2.10.10/js/onsenui.min.js"></script>



    <script>
        window.fn = {};

        window.fn.open = function () {
            var menu = document.getElementById('menu');
            menu.open();
        };

        window.fn.load = function (page) {
            var content = document.getElementById('content');
            var menu = document.getElementById('menu');
            content.load(page)
                .then(menu.close.bind(menu));
        };
        window.fn.close = function () {
            var menu = document.getElementById('menu');
            menu.close();
        };
    </script>


</head>

<body>
    <ons-splitter>
        <ons-splitter-side id="menu" side="right" width="220px" collapse swipeable>
            <ons-page>
                <ons-list>
                    <ons-list-item onclick="location='/'" tappable>
                        出費登録
                    </ons-list-item>
                    <ons-list-item onclick="location='/sum'" tappable>
                        直近月間集計
                    </ons-list-item>
                    <ons-list-item onclick="location='/q'" tappable>
                        入力照会・変更
                    </ons-list-item>
                    <ons-list-item onclick="location='/sumOld'" tappable>
                        過去集計
                    </ons-list-item>
                </ons-list>
            </ons-page>
        </ons-splitter-side>
        <ons-splitter-content id="content">



        <ons-page>
    <ons-toolbar>
        <div class="right">
            <ons-toolbar-button onclick="fn.open()">
                <ons-icon icon="md-menu"></ons-icon>
            </ons-toolbar-button>
        </div>
        <div class="center">
        利用区分別集計
        </div>
    </ons-toolbar>

    <div class="content">





<html>
<head>
    <title>利用区分別集計</title>
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
<br>
   <div align="right">
   <div class="button-bar" style="width:200px;">
    <div class="button-bar__item">
        <button class="button-bar__button" onclick="window.location.href='/'">入力画面</button>
    </div>
    <div class="button-bar__item">
        <button class="button-bar__button" onclick="window.location.href='./'">戻る</button>
    </div>
    </div>
   </div>

    <div align="left">
         <button class="toolbar-button toolbar-button--outline" onclick="location.reload()" style="height:27px;width:100px">
            <a style="font-size:13px; vertical-align:2px;">表示順reset</a>
         </button>
   </div>
   
    <div align="center">
    <?php 
    $startDate="19000101";
    $endDate="30001231";
    $leastUseCount="1";

    if(isset($_GET["startDate"])){
        $startDate=str_replace("-","",$_GET["startDate"]);
    }
    if(isset($_GET["endDate"])){
        $endDate=str_replace("-","",$_GET["endDate"]);
    }
    if(isset($_GET["leastUseCount"])){
        $leastUseCount=$_GET["leastUseCount"];
    }
    ?>
    <form action="sumByUser.php" method="get" name="form1">
        期間:<ons-input modifier="material" type="date" name="startDate" value="<?php echo date("Y-m-d",strtotime($startDate))?>"></ons-input>
        ～<ons-input modifier="material" type="date" name="endDate" value="<?php echo date("Y-m-d",strtotime($endDate))?>"></ons-input><br>
        最低利用回数:<ons-input modifier="material" type="number" name="leastUseCount" value="<?php echo $leastUseCount?>" style="width:160px"></ons-input>
        <ons-button onclick='document.form1.submit();'>検索</ons-button>
    </form>
    <a <?php echo isset($_GET["option"])&&$_GET["option"]=="all"?"":'href="sumByUser.php?option=all"'?>>すべて</a>
    <a <?php echo isset($_GET["option"])&&$_GET["option"]=="1y"?"":'href="sumByUser.php?option=1y&startDate='.date("Ymd",strtotime("-1 year")).'&endDate='.date("Ymd").'"'?>>直近1年</a>
    <a <?php echo isset($_GET["option"])&&$_GET["option"]=="6m"?"":'href="sumByUser.php?option=6m&startDate='.date("Ymd",strtotime("-6 month")).'&endDate='.date("Ymd").'"'?>>直近半年</a>
    <a <?php echo isset($_GET["option"])&&$_GET["option"]=="3m"?"":'href="sumByUser.php?option=3m&startDate='.date("Ymd",strtotime("-3 month")).'&endDate='.date("Ymd").'"'?>>直近3ヶ月</a>
    <a <?php echo isset($_GET["option"])&&$_GET["option"]=="1m"?"":'href="sumByUser.php?option=1m&startDate='.date("Ymd",strtotime("-1 month")).'&endDate='.date("Ymd").'"'?>>直近1ヶ月</a>

    <table border="1" id="tbSort">
    <thead>
        <tr>
        <th onclick="sortTime(this);"><a href="javascript:void(0)">利用区分</a></th>
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

        
        
        
        $sql="select
                card_user as user,
                sum(usage_amount) as amount,
                count(1) as count,
                sum(usage_amount)/count(1) as average
            from
                t_credit_card_user_input_details
                where date_of_use between $startDate and $endDate
                group by user
                having count>=$leastUseCount
                order by amount desc;";

        $ret = $db->query($sql);
        $storeCount=0;
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            echo "<tr>";
            
            echo "<td><a href='showMonthDetails.php?user=".$row['user']."&startDate=$startDate&endDate=$endDate'>".$row['user']."</a></td>";

            //echo "<td>".$row['user']."</td>";
            echo "<td>".$row['amount']."</td>";
            echo "<td>".$row['count']."</td>";
            echo "<td>".$row['average']."</td>";
            echo "</tr>";
            $storeCount+=1;
         }
        $db->close();
        echo "</tbody>";
        echo "<tr><th align='right'><font color='red'>$storeCount</font></th><th align='right'>⇐利用区分数</th><th></th><th></th></tr>"
        ?>
    </table>
    </div>
</body>
</html>



</div>
</ons-page>

</ons-splitter-content>
    </ons-splitter>

</body>

</html>