<html>
<head>
    <title>クレジット入力照会</title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
</head>
<body>
<h3>クレジット入力照会</h3>
<a href="../index.php">入力画面</a>
<br><br>
<form method= "post" action="showCsvDetails.php">
    <table>
    <?php
        $file=scandir("../csv");
        foreach($file as $csvFileName){
            if(strpos($csvFileName, ".csv")!==false){
                 echo '<tr><td><input type="submit" name="submit" value="'.$csvFileName.'"<tr><td><br><br>';
            }
        }
    ?>
    </table>
</form>
</body>
</html>
