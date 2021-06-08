<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>Forgot Password</title>

	<!-- Bootstrap core CSS -->
    <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor-front/jquery/jquery.min.js"></script>
    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
	<title>Forgot Password</title>
	<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<div class="container">
        <br />
        <br />
        <h1 class="text-center">Forgot Password?</h1>
        <div class="row justify-content-md-center mt-5">
            
            <div class="col-md-4">


<?php
include('db.php');
if(isset($_POST["email"]) && (!empty($_POST["email"]))){
$email = $_POST["email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email) {
  	$error .="<p>Invalid email address please type a valid email address!</p>";
	}else{
	$sel_query = "SELECT * FROM `chat_user_table` WHERE user_email='".$email."'";
	$results = mysqli_query($con,$sel_query);
	$row = mysqli_num_rows($results);
	if ($row==""){
		$error .= "<p>No user is registered with this email address!</p>";
		}
	}
	if($error!=""){
	echo "<div class='error'>".$error."</div>
	<div class='form-group text-center'>
	<br /><a href='javascript:history.go(-1)'>Go Back</a>";
		}else{
	$expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+1, date("Y"));
	$expDate = date("Y-m-d H:i:s",$expFormat);
	$key = md5(uniqid());

// Insert Temp Table
mysqli_query($con,
"INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
VALUES ('".$email."', '".$key."', '".$expDate."');");

$output='<p>Dear user,</p>';
$output.='<p>Please click on the following link to reset your password.</p>';
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p><a href="http://localhost:8888/chatapp/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">http://127.0.0.1:8888/chatapp/reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';		
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';
$output.='<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your password to secure your account.</p>';   	
$output.='<p>Thanks,</p>';
$body = $output; 
$subject = "Password Reset";

$email_to = $email;
$fromserver = "noreply@chatapp.com"; 
require("PHPMailer/PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = "smtp.email.com"; // Enter your host here
$mail->SMTPAuth = true;
$mail->Username = "example@email.com"; // Enter your email here
$mail->Password = "testpassword"; //Enter your passwrod here
$mail->Port = 587;      //smtp port (SSL/TLS)
$mail->IsHTML(true);
$mail->From = "noreply@chatapp.com";
$mail->FromName = "Chatapp";
$mail->Sender = $fromserver; // indicates ReturnPath header
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
if(!$mail->Send()){
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
echo "<div class='error'>
<p>An email has been sent to you with instructions on how to reset your password.</p>
</div><br /><br /><br />";
	}

		}	

}else{
?>
<div class="card">
    <div class="card-body">
<form method="post" action="" name="reset"><br /><br />
	<div class="form-group">
<div class="form-group">
    <label>Enter Your Email Address</label>
        <input type="text" name="email" id="email"  class="form-control" data-parsley-type="email" required />
</div>
<div class="form-group text-center">
    <input type="submit" name="reset" id="reset" class="btn btn-primary" value="Reset Password" />
</div>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>

</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>