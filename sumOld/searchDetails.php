<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">


    <link rel="stylesheet" href="/OnsenUI/OnsenUI-dist-2.10.10/css/onsenui.css">
    <link rel="stylesheet" href="/OnsenUI/OnsenUI-dist-2.10.10/css/onsen-css-components.min.css">
    <script src="/OnsenUI/OnsenUI-dist-2.10.10/js/onsenui.min.js"></script>

    <link rel="stylesheet" href="/jquery/jquery-ui-1.12.1.custom/jquery-ui.css" />
    <script src="/jquery/jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
    <script src="/jquery/jquery-ui-1.12.1.custom/jquery-ui.js"></script>


    <script>
        window.fn = {};

        window.fn.open = function () {
            var menu = document.getElementById('menu');
            menu.open();
        };

        window.fn.load = function (page) {
            var content = document.getElementById('content');
            var menu = document.getElementById('menu');
            content.load(page)
                .then(menu.close.bind(menu));
        };
        window.fn.close = function () {
            var menu = document.getElementById('menu');
            menu.close();
        };
    </script>

    <script>
        function showStoreNames() {
            $("#storeName").autocomplete({
                minLength: 0,
                source: "/forAjax/getStoreNames.php",
                focus: function () {
                    return false;
                },
                select: function (event, ui) {
                    $this = $(this);
                    setTimeout(function () {
                        $this.blur();
                    }, 1);
                },
                appendTo: ".content"
            }).focus(function () {
                $(this).autocomplete("search");//姜メモ:ここは「search」固定
                return false;
            }
            );
        };
        function showPaymentMethods() {
            $("#paymentMethod").autocomplete({
                minLength: 0,
                source: "/forAjax/getPaymentMethods.php",
                focus: function () {
                    return false;
                },
                select: function (event, ui) {
                    $this = $(this);
                    setTimeout(function () {
                        $this.blur();
                    }, 1);
                },
                appendTo: ".content"
            }).focus(function () {
                $(this).autocomplete("search");//姜メモ:ここは「search」固定
                return false;
            }
            );
        };
        function showComments() {
            $("#comment").autocomplete({
                minLength: 0,
                source: "/forAjax/getComments.php",
                focus: function () {
                    return false;
                },
                select: function (event, ui) {
                    $this = $(this);
                    setTimeout(function () {
                        $this.blur();
                    }, 1);
                },
                appendTo: ".content"
            }).focus(function () {
                $(this).autocomplete("search");//姜メモ:ここは「search」固定
                return false;
            }
            );
        };

        

    </script>


</head>

<body>
    <ons-splitter>
        <ons-splitter-side id="menu" side="right" width="220px" collapse swipeable>
            <ons-page>
                <ons-list>
                    <ons-list-item onclick="location='/'" tappable>
                        出費登録
                    </ons-list-item>
                    <ons-list-item onclick="location='/sum'" tappable>
                        直近月間集計
                    </ons-list-item>
                    <ons-list-item onclick="location='/q'" tappable>
                        入力照会・変更
                    </ons-list-item>
                    <ons-list-item onclick="location='/sumOld'" tappable>
                        過去集計
                    </ons-list-item>
                </ons-list>
            </ons-page>
        </ons-splitter-side>
        <ons-splitter-content id="content">



        <ons-page>
    <ons-toolbar>
        <div class="right">
            <ons-toolbar-button onclick="fn.open()">
                <ons-icon icon="md-menu"></ons-icon>
            </ons-toolbar-button>
        </div>
        <div class="center">
        明細検索
        </div>
    </ons-toolbar>

    <div class="content">



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
<br>
   <div align="right">
   <div class="button-bar" style="width:200px;">
    <div class="button-bar__item">
        <button class="button-bar__button" onclick="window.location.href='/'">入力画面</button>
    </div>
    <div class="button-bar__item">
        <button class="button-bar__button" onclick="window.location.href='./'">戻る</button>
    </div>
    </div>
   </div>

<div align="center">
<form  action="showMonthDetails.php" method="get" autocomplete="off" name="form1">
<input type="hidden" name="action" value="search">

<table>
<tr><td>期間 from:</td><td><input type="date" name="startDate"></td></tr>
<tr><td>期間 to:</td><td><input type="date" name="endDate"></td></tr>
<tr><td>利用店名:</td><td><input type="text" name="store" id="storeName" onfocus="showStoreNames()"></td></tr>
<tr><td>金額 min:</td><td><input type="number" name="startAmount"></td></tr>
<tr><td>金額 max:</td><td><input type="number" name="endAmount"></td></tr>
<tr><td>利用区分:</td><td><a href="javascript:checkAll()">全選択</a> <a href="javascript:unCheckAll()">全解除</a></td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="現金(姜)" checked>現金(姜)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="現金(王)" checked>現金(王)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="aeon_姜(9705)" checked>イオン_姜(9705)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="aeon_王(9713)" checked>イオン_王(9713)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="epos_姜(8743)" checked>EPOS_姜(8743)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="epos_王(4642)" checked>EPOS_王(4642)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="bic(6116)" checked>Bic(6116)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="本人" checked>楽天_姜(6229)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="家族" checked>楽天_王(9283)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="lumine(7914)" checked>Lumine(7914)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="ft(8518)" checked>ファミマT(8518)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="toho(8000)" checked>TOHO(8000)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="epos_姜(8142)" checked>【旧】EPOS_姜(8142)</td></tr>
<tr><td></td><td><input type="checkbox" name="users[]" value="epos_王(6393)" checked>【旧】EPOS_王(6393)</td></tr>
<tr><td>支払方法:</td><td><input type="text" name="paymentMethod" id="paymentMethod" onfocus="showPaymentMethods()"></td></tr>
<tr><td>備考:</td><td><input type="text" name="comment" id="comment" onfocus="showComments()"></td></tr>
<tr><td></td><td><ons-button onclick='document.form1.submit();'>検索</ons-button></td></tr>
</table>

</form>
</div>
<br><br>

<script>
        showStoreNames();
        showPaymentMethods();
        showComments();

</script>

</body>
</html>





</div>
</ons-page>

</ons-splitter-content>
    </ons-splitter>

</body>

</html>