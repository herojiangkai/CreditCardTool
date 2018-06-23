<?php session_start();?>
<html>

<head>
    <title>出費登録画面</title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="bookmark"href="/favicon.ico" />
    <script type="text/javascript">
        function checkAndSubmit() {
            if(document.getElementById("usedDate").value==""){
                alert("利用日を入力してください。");
            }else if(document.getElementById("storeName").value==""){
                alert("利用店名を入力してください。");
            }else if(document.getElementById("amount").value==""){
                alert("利用金額を入力してください。");
            }else if(document.getElementById("user").value==""){
                alert("利用区分を選択してください。");
            }else{
                document.getElementById("creditInputForm").submit();
            }
        }
    </script>
</head>

<body>
    <!-- <div align="right">
        <input type="button" value="メニュー">
        <input type="button" value="精算画面">
    </div> -->

    <h1 align="center">出費登録</h1>

    <div align="center">
        <a href="q">クレジット入力照会</a>
        <a href="qCash">現金入力照会</a>
    </div>
    
    <br>
        <div align="center">
            <span style="color:blue">
            <?php
            if (isset($_SESSION['csvWriteResult'])) {
                echo $_SESSION['csvWriteResult'];
                unset($_SESSION['csvWriteResult']);
            }
            ?>
            </span>
        </div>
    <br>
    <form method= "post" action="writeCsv.php" id="creditInputForm">
        <table align="center">
            <tr><td>レシート・注文番号:</td></tr>
            <tr><td><input type="text" name="receiptNo"></td></tr>
            <tr><td>利用日(yyyyMMdd形式):</td></tr>
            <tr><td><input type="date" name="usedDate" id="usedDate" value="<?php echo date("Y-m-d")?>"><span style="color:red">(必須)</span></td></tr>
            <tr><td>利用時刻(HHmmss形式):</td></tr>
            <tr><td><input type="number" name="usedTime" oninput="if(value.length>6)value=value.slice(0,6)"
                            onblur="if(value.length==4)value=value+'00'"></td></tr>
            <tr><td>利用店名(50文字以内):</td></tr>
            <tr><td><input type="text" name="storeName" id="storeName"><span style="color:red">(必須)</span></td></tr>
            <tr><td>利用金額:</td></tr>
            <tr><td><input type="number" name="amount" id="amount"><span style="color:red">(必須)</span></td></tr>
            <tr><td>利用区分:</td></tr>
            <tr>
                <td><select name="user" id="user">
                    <option value="" selected>ーー</option>
                    <option value="本人">6229(姜)</option>
                    <option value="家族">9283(王)</option>
                    <option value="現金(姜)">現金(姜)</option>
                    <option value="現金(王)">現金(王)</option>
                </select><span style="color:red">(選択間違い注意)</span></td>
            </tr>
            <tr><td>分割支払回数:</td></tr>
            <tr><td><input type="number" value="1" name="paymentSplitTimes"><span style="color:red">(必須)</span></td></tr>
            <tr><td>支払方法:</td></tr>
            <tr><td><input type="text" name="paymentMethod"></td></tr>
            <tr><td>備考(255文字以内):</td></tr>
            <tr><td><input type="text" name="comment"></td></tr>
            
        </table>
        <br>
        <div align="center">
            <input type="button" onclick="checkAndSubmit()" value="     登録     ">
            <br><br>
            <input type="reset" value="クリア">
        </div>
        
        

    </form>
</body>

</html>
