<html>
<head>

</head>
<title>明細検索</title>
   <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="theme-color" content="#DCDCDC">
<body>
<h3 align="center">明細検索</h3>
<div align="right">
    <a href="../index.php">入力画面</a>
    <a href="./">戻る</a>
</div>

<div align="center">
<form  action="showMonthDetails.php" method="get">
<table>
<tr><td aligh="left">
<input type="hidden" name="action" value="search">
期間:
<input type="date" name="startDate">～<input type="date" name="endDate"><br>
利用店名:
<input type="text" name="store"><br>
金額:
<input type="number" name="startAmount">～<input type="number" name="endAmount"><br>
利用区分:<br>
<input type="checkbox" name="users[]" value="現金(姜)" checked>現金(姜)<br>
<input type="checkbox" name="users[]" value="現金(王)" checked>現金(王)<br>
<input type="checkbox" name="users[]" value="aeon_姜(9705)" checked>イオン_姜(9705)<br>
<input type="checkbox" name="users[]" value="aeon_王(9713)" checked>イオン_王(9713)<br>
<input type="checkbox" name="users[]" value="epos_姜(8142)" checked>EPOS_姜(8142)<br>
<input type="checkbox" name="users[]" value="epos_王(6393)" checked>EPOS_王(6393)<br>
<input type="checkbox" name="users[]" value="bic(6116)" checked>Bic(6116)<br>
<input type="checkbox" name="users[]" value="本人" checked>楽天_姜(6229)<br>
<input type="checkbox" name="users[]" value="家族" checked>楽天_王(9283)<br>                
<input type="checkbox" name="users[]" value="lumine(7914)" checked>Lumine(7914)<br>
<input type="checkbox" name="users[]" value="ft(8518)" checked>ファミマT(8518)<br>
<input type="checkbox" name="users[]" value="toho(8000)" checked>TOHO(8000)<br>
支払方法:
<input type="text" name="paymentMethod"><br>
備考:
<input type="text" name="comment"><br>
</td></tr>
<tr><td align="center"><br><input type="submit" value="検索"></td></tr>
</table>
</form>
</div>

</body>
</html>