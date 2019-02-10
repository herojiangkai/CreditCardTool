<html>
<head>
    <title>クレジット　<?php echo $_POST["csvFileName"]?></title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#ffd700">

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
    <h3 align="center">クレジット　<?php echo $_POST["csvFileName"]?></h3>
    <div align="right">
        <a href="../index.php">入力画面</a>
        <a href="../q/">クレジット入力照会</a>
    </div>
    <div align="left">
        <a href="javascript:void(0)" onclick="location.reload()">表示順reset</a>
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
        $csvFilePath=$_POST["folderPath"].$_POST["csvFileName"];
        $csvFile = fopen($csvFilePath, "r") or die("Unable to open csv file-> ".$csvFilePath);
        $totalAmount=0;
        while(!feof($csvFile)) {
            $currentLine=fgets($csvFile);
            $currentLine=str_replace(" ","&nbsp",$currentLine);
            $currentColums=explode('","',$currentLine);
            if(sizeof($currentColums)>1){
                echo "<tr>";
                echo "<td>".substr($currentColums[0],1)."</td>";
                for($i=1;$i<sizeof($currentColums)-1;$i++){
                    if($i===6){
                        echo "<td align='right'>".$currentColums[$i]."</td>";
                    }else{
                        echo "<td>".$currentColums[$i]."</td>";
                    }
                }
                echo "<td>".substr($currentColums[sizeof($currentColums)-1],0,-3)."</td>";
                echo "</tr>";
                $totalAmount+=(int)$currentColums[6];
            }
        }
        fclose($csvFile);
        echo "</tbody>";
        echo "<tr><th></th><th></th><th></th><th></th><th></th><th align='right'>総額⇒</th><th align='right'>$totalAmount</th><th></th><th></th></tr>"
        ?>

    </table>
</body>
</html>