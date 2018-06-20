<?php
  $subject = "testSubject" ;
  $message = "
  <html>
  <head>
  <title>HTML email</title>
  </head>
  <body>
  <p>This email contains HTML Tags!</p>
  <table>
  <tr>
  <th>Firstname</th>
  <th>Lastname</th>
  </tr>
  <tr>
  <td>John</td>
  <td>Doe</td>
  </tr>
  </table>
  $_POST[timestampOfCall]
  </body>
  </html>
  ";

  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

  $sendSuccessed = mail( "herojiangkai@gmail.com",$subject,$message,$headers);
  if ($sendSuccessed){
    echo "OK";
  }else{
    echo "NG";
  } 
?>