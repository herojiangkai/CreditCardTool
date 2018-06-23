<html>
<head>
    <title>現金入力照会</title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="theme-color" content="#008000">
</head>
<body>
<h3 align="center">現金入力照会</h3>
<div align="right"><a href="../index.php">入力画面</a></div>
<br><br>
<form method= "post" action="showCsvDetails.php">
    <table align="center">
    <?php
        $file=scandir("../csvCash");
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
