<html>
<head>
    <!DOCTYPE HTML>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no" name="viewport">
</head>
<body>

<?php
if (isset($_REQUEST['message']))
//if "email" is filled out, send email
  {
  //send email
  //$email = $_REQUEST['email'] ; 
  //$email = "herojiangkai@163.com" ; 
  $subject = $_REQUEST['subject'] ;
  $message = $_REQUEST['message'] ;
  $sendSuccessed = mail( "herojiangkai@gmail.com",$subject,
  $message);//, "From: $email"
  if ($sendSuccessed){
    echo "Well done!";
  }else{
    echo "Not good!";
  }
  
  }
else
//if "email" is not filled out, display the form
  {
    //Email: <input name='email' type='text' /><br />
  echo "<form method='post' action='index.php'>
  
  Subject: <input name='subject' type='text' />&nbsp;&nbsp;<input type='submit' /><br />
  Message:<br />
  <textarea name='message' rows='15' cols='40'></textarea><br /><br />
  <input type='submit' />
  </form>";
  }
?>

</body>
</html>