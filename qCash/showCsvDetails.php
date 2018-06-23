<html>
<head>
    <title>現金　<?php echo $_POST["submit"]?></title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#008000">
</head>
<body>
    <h3 align="center">現金　<?php echo $_POST["submit"]?></h3>
    <div align="right">
        <a href="../index.php">入力画面</a>
        <a href="#" onClick="javaScript:history.go(-1)" style="text-align:center">返回</a>
    </div>
    <table border="1">
        <tr>
            <th>レシート・注文番号</th>
            <th>利用日</th>
            <th>利用時刻</th>
            <th>利用区分</th>
            <th>利用店名</th>
            <th>分割支払回数</th>
            <th>利用金額</th>
            <th>支払方法</th>
            <th>備考</th>
        </tr>
        <?php
        $csvFilePath="../csvCash/".$_POST["submit"];
        $csvFile = fopen($csvFilePath, "r") or die("Unable to open csv file-> ".$csvFilePath);
        while(!feof($csvFile)) {
            $currentLine=fgets($csvFile);
            $currentColums=explode('","',$currentLine);
            if(sizeof($currentColums)>1){
                echo "<tr>";
                echo "<td>".substr($currentColums[0],1)."</td>";
                for($i=1;$i<sizeof($currentColums)-1;$i++){
                    echo "<td>".$currentColums[$i]."</td>";
                }
                echo "<td>".substr($currentColums[sizeof($currentColums)-1],0,-3)."</td>";
                echo "</tr>";
            }
        }
        fclose($csvFile);
        ?>

    </table>
</body>
</html>