<?php 
    $cardTypeName=$_GET["cardTypeName"];
    $folderPath=$_GET["folderPath"];
    $csvFileName=$_GET["csvFileName"];
?>

<html>
<head>
    <title>【編集】<?php echo $cardTypeName." ".$csvFileName?></title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#ffd700">
    <script type="text/javascript">
        function checkAndSubmit(lineNumber) {
            errCount=0;
            for(i=1;i<lineNumber;i++){
                if(document.getElementById("usedDate"+"_"+i).value==""){
                     alert(i+"行目の利用日を入力してください。");
                     errCount++;
                }
                if(document.getElementById("storeName"+"_"+i).value==""){
                    alert(i+"行目の利用店名を入力してください。");
                    errCount++;
                }
                if(document.getElementById("amount"+"_"+i).value==""){
                    alert(i+"行目の利用金額を入力してください。");
                    errCount++;
                }
            }
            if(errCount==0){
                document.getElementById("editCsvDetails").submit();
            }
        }
    </script>
</head>
<body>
    <h3 align="center">【編集】<?php echo $cardTypeName." ".$csvFileName?></h3>
    <div align="right">
        <a href="../index.php">入力画面</a>
        <a href="../q/">入力照会・変更</a>
        <a href="javascript:history.go(-1)">戻る</a><br><br>

    </div>
    <form action="moveAndSaveCsv.php" method="post" id="editCsvDetails">
    <table border="1" id="tbSort">
    <thead>
        <tr>
            <th>行No.</th>
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
    </thead>
    <tbody>
        <?php
        echo "<input type='hidden' name='cardTypeName' value='$cardTypeName'>";
        echo "<input type='hidden' name='folderPath' value='$folderPath'>";
        echo "<input type='hidden' name='csvFileName' value='$csvFileName'>";
        $csvFilePath=$folderPath.$csvFileName;
        $csvFile = fopen($csvFilePath, "r") or die("Unable to open csv file-> ".$csvFilePath);
        $lineNumber=0;
        while(!feof($csvFile)) {
            $lineNumber+=1;
            $currentLine=fgets($csvFile);
            $currentColums=explode('","',$currentLine);
            if(sizeof($currentColums)>1){
                $receiptNo=substr($currentColums[0],1);
                $usedDate=date("Y-m-d",strtotime($currentColums[1]));
                $usedTime= $currentColums[2];
                $user= $currentColums[3];
                $storeName= $currentColums[4];
                $paymentSplitTimes= $currentColums[5] ;
                $amount= $currentColums[6] ;
                $paymentMethod= $currentColums[7] ;
                $comment= substr($currentColums[8],0,-3);
                echo "<tr>";
                echo "<td align='right'>$lineNumber</td>";
                echo "<td><input type='text' value='$receiptNo' name='receiptNo_$lineNumber' id='receiptNo_$lineNumber'></td>";
                echo "<td><input type='date' value='$usedDate' name='usedDate_$lineNumber' id='usedDate_$lineNumber'></td>";
                echo "<td><input type='number' value='$usedTime' name='usedTime_$lineNumber' id='usedTime_$lineNumber' oninput='if(value.length>6)value=value.slice(0,6)' onblur='if(value.length==4)value=value+\"00\"'></td>";
                echo "<td><select name='user_$lineNumber' id='user_$lineNumber'>";
                    printSelection("現金(姜)","現金(姜)",$user);
                    printSelection("現金(王)","現金(王)",$user);
                    printSelection("aeon_姜(9705)","イオン_姜(9705)",$user);
                    printSelection("aeon_王(9713)","イオン_王(9713)",$user);
                    printSelection("epos_姜(8142)","EPOS_姜(8142)",$user);
                    printSelection("epos_王(6393)","EPOS_王(6393)",$user);
                    printSelection("bic(6116)","Bic(6116)",$user);
                    printSelection("本人","楽天_姜(6229)",$user);
                    printSelection("家族","楽天_王(9283)",$user);
                    printSelection("lumine(7914)","Lumine(7914)",$user);
                    printSelection("ft(8518)","ファミマT(8518)",$user);
                    printSelection("toho(8000)","TOHO(8000)",$user);
                echo "</select></td>";
                echo "<td><input type='text' value='$storeName' name='storeName_$lineNumber' id='storeName_$lineNumber'></td>";
                echo "<td><input type='number' value='$paymentSplitTimes' name='paymentSplitTimes_$lineNumber' id='paymentSplitTimes_$lineNumber'></td>";
                echo "<td><input type='number' value='$amount' name='amount_$lineNumber' id='amount_$lineNumber'></td>";
                echo "<td><input type='text' value='$paymentMethod' name='paymentMethod_$lineNumber' id='paymentMethod_$lineNumber'></td>";
                echo "<td><input type='text' value='$comment' name='comment_$lineNumber' id='comment_$lineNumber'></td>";
                echo "</tr>";
            }
        }
        fclose($csvFile);
        echo "</tbody>";
        function printSelection($value,$labelName,$userValue){
            echo "<option value=$value ".($userValue==$value?"selected":"").">$labelName</option>";
        }
        ?>

    </table><br>
    <div align="center">
    <input type="reset" value="リセット">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<?php echo "<input type='button' value='　保存　' onclick='checkAndSubmit($lineNumber)'>"?>
    </div>
    </form>
</body>
</html>