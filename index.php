<ons-page>
    <ons-toolbar>
        <div class="right">
            <ons-toolbar-button onclick="fn.open()">
                <ons-icon icon="md-menu"></ons-icon>
            </ons-toolbar-button>
        </div>
        <div class="center">
        出費登録
        </div>
    </ons-toolbar>
<?php session_start();?>
<html>

<head>
    <title>出費登録</title>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="theme-color" content="#8a2be2">
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="bookmark" href="/favicon.ico" />


    <link rel="stylesheet" href="OnsenUI/OnsenUI-dist-2.10.10/css/onsenui.css">
    <link rel="stylesheet" href="OnsenUI/OnsenUI-dist-2.10.10/css/onsen-css-components.min.css">
    <script src="OnsenUI/OnsenUI-dist-2.10.10/js/onsenui.min.js"></script>


    <script type="text/javascript">
        var showAlert = function (msg) {
            ons.notification.alert(msg, {
                title: ""
            });
        };
        function checkAndSubmit() {
            if(document.getElementById("usedDate").value==""){
                showAlert("利用日を入力してください。");
            }else if(document.getElementById("storeName").value==""){
                showAlert("利用店名を入力してください。");
            }else if(document.getElementById("amount").value==""){
                showAlert("利用金額を入力してください。");
            }else if(document.getElementById("user").value==""){
                showAlert("利用区分を選択してください。");
            }else if(document.getElementById("user").value=="lumine(7914)"){
                rdo=document.getElementsByName("offPct");
                checkCount=0;
                for(i=0;i<rdo.length;i++){
                    if(rdo[i].checked){
                        checkCount++;
                    } 
                }
                if(checkCount==0){
                    showAlert("割引を選択してください。");
                }else{
                    document.getElementById("creditInputForm").submit();
                }
            }else{
                document.getElementById("creditInputForm").submit();
            }
        }
        function showOffPct(value){
            if(value=="lumine(7914)"){
                document.getElementById("offPctDiv").style.display="";
            }else{
                document.getElementById("offPctDiv").style.display="none";
            }
        }
        function showStoreNames() {
            $("#storeName").autocomplete({
                minLength: 0,
                source: "forAjax/getStoreNames.php",
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
                source: "forAjax/getPaymentMethods.php",
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
                source: "forAjax/getComments.php",
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

        showStoreNames();
        showPaymentMethods();
        showComments();
    </script>
</head>

<body>
<ons-page>
<div class="content">
    <br>

    <div align="center">
    <div class="button-bar" style="width:300px;">
    <div class="button-bar__item">
        <button class="button-bar__button" onclick="window.location.href='sumOld'">過去集計</button>
    </div>
    <div class="button-bar__item">
        <button class="button-bar__button" onclick="window.location.href='q'">入力照会・変更</button>
    </div>
    <div class="button-bar__item">
        <button class="button-bar__button" onclick="window.location.href='sum'">直近月間集計</button>
    </div>
    </div>
        
    </div>
    
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
    <form method= "post" action="writeCsv.php" id="creditInputForm" autocomplete="on">
        <table align="center">
            <tr><td><br><ons-input modifier="material" type="text" name="receiptNo" placeholder="レシート・注文番号" float></ons-input></td></tr>
            <tr><td><br><ons-input modifier="material" type="date" name="usedDate" id="usedDate" value="<?php echo date("Y-m-d")?>" placeholder="利用日" float></ons-input><span style="color:red">(必須)</span></td></tr>
            <tr><td><br><ons-input modifier="material" type="number" name="usedTime" oninput="if(value.length>6)value=value.slice(0,6)"
                            onblur="if(value.length==4)value=value+'00'" placeholder="利用時刻(HHmmss形式)" float></ons-input></td></tr>
            <tr><td><span style="color:blue">利用店名:</span></td></tr>
            <tr><td><input class="text-input text-input--material" type="text" name="storeName" id="storeName" onfocus="showStoreNames()" placeholder="選択推奨"><span style="color:red">(必須)</span></td></tr>
            <tr><td><br>¥&nbsp<ons-input modifier="material" type="number" name="amount" id="amount" placeholder="利用金額" float></ons-input><span style="color:red">(必須)</span></td></tr>
            <tr><td><span style="color:blue">利用区分:</span><span style="color:red">(選択間違い注意)</span></td></tr>
            <tr>
                <td><select class="select-input select-input--underbar" name="user" id="user" onchange="showOffPct(this.value)">
                    <option value="" selected>ーー</option>
                    <option value="現金(姜)">現金(姜)</option>
                    <option value="現金(王)">現金(王)</option>
                    <option value="aeon_姜(9705)">イオン_姜(9705)</option>
                    <option value="aeon_王(9713)">イオン_王(9713)</option>
                    <option value="epos_姜(8743)">EPOS_姜(8743)</option>
                    <option value="epos_王(6393)">EPOS_王(6393)</option>
                    <option value="bic(6116)">Bic(6116)</option>
                    <option value="本人">楽天_姜(6229)</option>
                    <option value="家族">楽天_王(9283)</option>
                    <option value="lumine(7914)">Lumine(7914)</option>
                    <option value="ft(8518)">ファミマT(8518)</option>
                    <option value="toho(8000)">TOHO(8000)</option>
                </select></td>
            </tr>
            <tr><td>
                <div style="display:none;background:yellow" id="offPctDiv"><span style="color:blue">割引:</span><br>
                <label class="radio-button radio-button--material">
                    <input class="radio-button__input radio-button--material__input" type="radio" name="offPct" value="0">
                    <div class="radio-button__checkmark radio-button--material__checkmark"></div>0%　</label>
                <label class="radio-button radio-button--material">
                    <input class="radio-button__input radio-button--material__input" type="radio" name="offPct" value="5">
                    <div class="radio-button__checkmark radio-button--material__checkmark"></div>5%　</label>
                <label class="radio-button radio-button--material">
                    <input class="radio-button__input radio-button--material__input" type="radio" name="offPct" value="10">
                    <div class="radio-button__checkmark radio-button--material__checkmark"></div>10%　</label>
                    <span style="color:red">(必須)</span>
                </div>
            </td></tr>
            <tr><td><br><ons-input modifier="material" type="number" value="1" name="paymentSplitTimes" placeholder="分割支払回数" float></ons-input></td></tr>
            <tr><td><span style="color:blue">支払方法:</span></td></tr>
            <tr><td><input class="text-input text-input--material" type="text" name="paymentMethod" id="paymentMethod" onfocus="showPaymentMethods()" placeholder="電子マネー、ポイント等"></td></tr>
            <tr><td><span style="color:blue">備考:</span></td></tr>
            <tr><td><input class="text-input text-input--material" type="text" name="comment" id="comment" onfocus="showComments()" placeholder="上記支払方法の金額等"></td></tr>
            
        </table>
        <br>
        <div align="center">
            <ons-button onclick="checkAndSubmit()">　　　登録　　　</ons-button>
            <br><br>
            <input class="ui-button ui-widget ui-corner-all" type="reset" value="クリア" onclick="showOffPct('')">
            <br><br>
        </div>
        
        

    </form>
</div>
</ons-page>
</body>

</html>
</ons-page>
