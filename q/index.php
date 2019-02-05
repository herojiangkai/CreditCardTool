<html>
<head>
    <title>クレジット入力照会</title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="theme-color" content="#ffd700">
</head>
<body>
<h3 align="center">クレジット入力照会</h3>
<div align="right"><a href="../index.php">入力画面</a></div>
<br><br>
    <table align="center" border="1">
    <?php
        printCsvFileList("イオンカード","../csvAeon/");
        printCsvFileList("EPOSカード(姜)","../csvEposJiang/");
        printCsvFileList("EPOSカード(王)","../csvEposWang/");
        printCsvFileList("Bicカード","../csvBic/");
        printCsvFileList("楽天カード","../csv/");
        printCsvFileList("LUMINEカード","../csvLumine/");
        printCsvFileList("ファミマTカード","../csvFt/");
    ?>
    </table>
    <br><br><br><br><br><br>
</body>
</html>
<?php

function printCsvFileList($cardTypeName,$folderPath){
    echo "<tr><td>$cardTypeName</td><td><br>";
    echo '<form method= "post" action="showCsvDetails.php">';
    echo '<input type="hidden" name="folderPath" value="'.$folderPath.'">';
    $file=scandir($folderPath);
    foreach($file as $csvFileName){
        if(strpos($csvFileName, ".csv")!==false){
             echo '<input type="submit" name="csvFileName" value="'.$csvFileName.'"><br><br>';
        }
    }
    echo "</form></td></tr>";
}

?>