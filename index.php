<?php session_start();?>
<html>

<head>
    <title>レシート・クレジット実績登録画面</title>
</head>

<body>
    <!-- <div align="right">
        <input type="button" value="メニュー">
        <input type="button" value="精算画面">
    </div> -->

    <h1 align="center">クレジット登録</h1>
    <br>
    <form method= "post" action="writeCsv.php">
        <table align="center">
            <tr><td>レシート・注文番号:</td></tr>
            <tr><td><input type="text" name="receiptNo"></td></tr>
            <tr><td>利用日(yyyyMMdd形式):</td></tr>
            <tr><td><input type="text" name="usedDate" value="<?php echo date("Ymd")?>"><span style="color:red">(必須)</span></td></tr>
            <tr><td>利用時刻(HHmmss形式):</td></tr>
            <tr><td><input type="text" name="usedTime"></td></tr>
            <tr><td>利用者:</td></tr>
            <tr>
                <td><select name="user">
                    <option value="本人" selected>本人</option>
                    <option value="家族">家族</option>
                </select><span style="color:red">(選択間違い注意)</span></td>
            </tr>
            <tr><td>利用店名(50文字以内):</td></tr>
            <tr><td><input type="text" name="storeName"><span style="color:red">(必須)</span></td></tr>
            <tr><td>分割支払回数:</td></tr>
            <tr><td><input type="text" value="1" name="paymentSplitTimes"><span style="color:red">(必須)</span></td></tr>
            <tr><td>利用金額:</td></tr>
            <tr><td><input type="text" name="amount"><span style="color:red">(必須)</span></td></tr>
            <tr><td>支払方法:</td></tr>
            <tr><td><input type="text" name="paymentMethod"></td></tr>
            <tr><td>備考(255文字以内):</td></tr>
            <tr><td><input type="text" name="comment"></td></tr>
            
        </table>
        <br>
        <div align="center">
            <input type="submit" value="     登録     "><br><br>
            <input type="reset" value="クリア">
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
        

    </form>
</body>

</html>
