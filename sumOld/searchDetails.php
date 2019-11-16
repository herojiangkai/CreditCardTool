<html>
<head>
    <title>明細検索</title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="theme-color" content="#DCDCDC">

    <script type="text/javascript">
        function unCheckAll(){
            var checkson = document.getElementsByName("users[]");       
            for(var i = 0; i < checkson.length ;i++){
                checkson[i].checked = false;
            }
        }
        function checkAll(){
            var checkson = document.getElementsByName("users[]");       
            for(var i = 0; i < checkson.length ;i++){
                checkson[i].checked = true;
            }
        }
    </script>

</head>

<body>
<h3 align="center">明細検索</h3>
<div align="right">
    <a href="../index.php">入力画面</a>
    <a href="./">戻る</a>
</div>

<div align="center">
<form  action="showMonthDetails.php" method="get">
<input type="hidden" name="action" value="search">

<table>
<tr><td>期間 from:</td><td><input type="date" name="startDate"></td></tr>
<tr><td>期間 to:</td><td><input type="date" name="endDate"></td></tr>
<tr><td>利用店名:</td><td><input type="text" name="store"></td></tr>
<tr><td>金額 min:</td><td><input type="number" name="startAmount"></td></tr>
<tr><td>金額 max:</td><td><input type="number" name="endAmount"></td></tr>
<tr><td>利用区分:</td><td><a href="javascript:checkAll()">全選択</a> <a href="javascript:unCheckAll()">全解除</a></td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="現金(姜)" checked>現金(姜)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="現金(王)" checked>現金(王)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="aeon_姜(9705)" checked>イオン_姜(9705)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="aeon_王(9713)" checked>イオン_王(9713)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="epos_姜(8142)" checked>EPOS_姜(8142)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="epos_王(6393)" checked>EPOS_王(6393)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="bic(6116)" checked>Bic(6116)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="本人" checked>楽天_姜(6229)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="家族" checked>楽天_王(9283)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="lumine(7914)" checked>Lumine(7914)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="ft(8518)" checked>ファミマT(8518)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="toho(8000)" checked>TOHO(8000)</td></tr>
<tr><td>支払方法:</td><td><input type="text" name="paymentMethod"></td></tr>
<tr><td>備考:</td><td><input type="text" name="comment"></td></tr>
<tr><td></td><td><input type="submit" value="検索"></td></tr>
</table>

</form>
</div>
<br><br><br><br><br><br>
</body>
</html>