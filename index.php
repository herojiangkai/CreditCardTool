<html>

<head>
    <title>レシート・クレジット実績登録画面</title>
</head>

<body>
    <div align="right">
        <input type="button" value="メニュー">
        <input type="button" value="精算画面">
    </div>

    <h1 align="center">レシート・クレジット実績登録画面</h1>
    <br>
    <form action="">
        <table align="center">
            <tr>
                <td>レシート又は注文番号:</td>
                <td><input type="text"></td>
                <td>255文字以内</td>
            </tr>
            <tr>
                <td>利用日:</td>
                <td><input type="text">*</td>
                <td>yyyyMMdd形式</td>
                <td><span style="color:red">入力必須項目</span></td>
            </tr>
            <tr>
                <td>利用時刻:</td>
                <td><input type="text"></td>
                <td>HHmmss形式</td>
            </tr>
            <tr>
                <td>利用者:</td>
                <td><select>
                    <option value="本人" selected>本人</option>
                    <option value="家族">家族</option>
                </select></td>
                <td> </td>
                <td><span style="color:red">入力必須項目</span></td>
            </tr>
            <tr>
                <td>利用店名:</td>
                <td><input type="text">*</td>
                <td>50文字以内</td>
                <td><span style="color:red">入力必須項目</span></td>
            </tr>
            <tr>
                <td>分割支払回数:</td>
                <td><input type="text" value="1">*</td>
                <td></td>
                <td><span style="color:red">入力必須項目</span></td>
            </tr>
            <tr>
                <td>利用金額:</td>
                <td><input type="text">*</td>
                <td></td>
                <td><span style="color:red">入力必須項目</span></td>
            </tr>
            <tr>
                <td>支払方法:</td>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td>備考:</td>
                <td><input type="text"></td>
                <td>255文字以内</td>
            </tr>
        </table>
        <br>
        <div align="center">
            <input type="submit">
            <input type="button" value="クリア">
        </div>

    </form>
</body>

</html>