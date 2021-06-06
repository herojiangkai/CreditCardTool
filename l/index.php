<html>

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width,user-scalable=no" name="viewport">

    <script>
        function checkAndSubmit() {
            if(document.getElementById("link").value.trim()==""){
                alert("链接不能为空");
            }else{
                document.getElementById("linkInputForm").submit();
            }
        }
    </script>
    

</head>

<body>
    <div align="center" >
        <div style='height:200px'></div>
        <form action="writeLink.php" method="POST" id="linkInputForm">
            <table>
                <tr>
                    <td>链接</td>
                    <td><input type="text" name="link" id="link"><br></td>
                </tr>
                <tr>
                    <td>备注</td>
                    <td><input type="text" name="comment"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="button" value="提交" onclick="checkAndSubmit()"></td>
                </tr>
            </table>


        </form>
        <table border="1" >
            <tr>
                <th>备注</th>
                <th>链接</th>
            </tr>
            <?php
                $csvFile = fopen("links.txt", "r") or die("Unable to open csv file");
                while(!feof($csvFile)) {
                    $currentLine=fgets($csvFile);
                    $currentColums=explode('","',$currentLine);
                    if(sizeof($currentColums)>1){
                        echo "<tr>";
                        echo "<td>".htmlspecialchars(substr($currentColums[0],1),ENT_QUOTES)."</td>";
                        $linkStr=substr($currentColums[sizeof($currentColums)-1],0,-3);
                        $linkStr=htmlspecialchars($linkStr,ENT_QUOTES);
                        echo "<td><a href='$linkStr' target='_blank'>".$linkStr."</a></td>";                
                        echo "</tr>";
                    }
                }
                fclose($csvFile);
        ?>

        </table>
        <div style='height:200px'></div>
    </div>
</body>

</html>