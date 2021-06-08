<!DOCTYPE html>
<html lang="en">
<head>


<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password</title>

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
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
    <div class="containter">
        <br />
        <br />
        <div class="row justify-content-md-center">
            <div class="col col-md-4 mt-5">

<?php
include('db.php');
if (isset($_GET["key"]) && isset($_GET["email"])
&& isset($_GET["action"]) && ($_GET["action"]=="reset")
&& !isset($_POST["action"])){
$key = $_GET["key"];
$email = $_GET["email"];
$curDate = date("Y-m-d H:i:s");
$query = mysqli_query($con,"
SELECT * FROM `password_reset_temp` WHERE `key`='".$key."' and `email`='".$email."';");
$row = mysqli_num_rows($query);
if ($row==""){
$error .= '<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link from the email, 
or you have already used the key in which case it is deactivated.</p>
<p><a href="http://127.0.0.1:8888/chatapp/forgot_password.php">Click here</a> to reset password.</p>';
    }else{
    $row = mysqli_fetch_assoc($query);
    $expDate = $row['expDate'];
    if ($expDate >= $curDate){
    ?>
    <div class="card">
                    <div class="card-header">Reset Password</div>
                    <div class="card-body">

                        <form method="post" name="update" action="">
                            <input type="hidden" name="action" value="update">
                            <div class="form-group">
                                <label>Enter New Password</label>
                                <input type="password" name="pass1" id="pass1" class="form-control" data-parsley-minlength="8" data-parsley-maxlength="20" data-parsley-pattern="^[a-zA-Z0-9]+$" required />
                            </div>

                            <div class="form-group">
                                <label>Re-Enter New Password</label>
                                <input type="password" name="pass2" id="pass2" class="form-control" data-parsley-minlength="8" data-parsley-maxlength="20" data-parsley-pattern="^[a-zA-Z0-9]+$" required />
                            </div>
                            <input type="hidden" name="email" value="<?php echo $email;?>"/>

                            <div class="form-group text-center">
                                <input type="submit" id="reset" class="btn btn-success" value="Reset Password" />
                            </div>

                        </form>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>



<?php
}else{
$error .= "<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which as valid only 24 hours (1 days after request).<br /><br /></p>";
                }
        }
if($error!=""){
    echo "<div class='error'>".$error."</div><br />";
    }           
} // isset email key validate end


if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"]=="update")){
$error="";
$pass1 = mysqli_real_escape_string($con,$_POST["pass1"]);
$pass2 = mysqli_real_escape_string($con,$_POST["pass2"]);
$email = $_POST["email"];
$curDate = date("Y-m-d H:i:s");
if ($pass1!=$pass2){
        $error .= "<p>Password do not match, both password should be same.<br /><br /></p>";
        }
    if($error!=""){
        echo "<div class='error'>".$error."</div><br />";
        }else{

mysqli_query($con,
"UPDATE `chat_user_table` SET `user_password`='".$pass1."' WHERE `user_email`='".$email."';");  

mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `email`='".$email."';");     
    
echo '<div class="error"><p>Congratulations! Your password has been updated successfully.</p>';
}       
}
?>

</div>
</body>
</html>