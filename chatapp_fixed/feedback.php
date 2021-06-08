<?php
include('db.php');
if( isset( $_POST[ 'btnSign' ] ) ) {

	// Get input
	$message = trim( $_POST[ 'mtxMessage' ] );
	$name    = trim( $_POST[ 'txtName' ] );

	// Sanitize message input
	$message = stripslashes( $message );
	$message = htmlspecialchars( $message );

	// Sanitize name input
	$name = stripslashes( $name );
	$name = htmlspecialchars( $name );

	// Update database
	$data = "INSERT INTO feedback ( comment, name ) VALUES ( '$message', '$name' );";
	$res=mysqli_query($con,$data);
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>Feedback</title>

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
<p><a href="<?php echo($_SERVER["SCRIPT_NAME"]);?>?url=feedback"></a></p>
    
<div class="containter">
        <br />
        <br />
        <h1 class="text-center">Feedback</h1>
        
        <div class="row justify-content-md-center">
            <div class="col col-md-4 mt-5">
<div class="card">
    <div class="card-body">
		<form method="post" name="guestform">
			
				<div class="form-group">
					<label>Name:</label>
					<input name="txtName" type="text" data-parsley-maxlength="10" id="txtName" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Feedback:</label>
					<input name="mtxMessage" data-parsley-maxlength="50" id="mtxMessage" class="form-control" requiredz></input>
				</div>
					<div class="form-group text-center">
						<input name="btnSign" type="submit" value="submit" onclick="return validateGuestbookForm(this.form);\" />

</div>
		</form>
	</div>
</div>
</div>
</div>
</div>
</body>
</html>

<?php
$sql = "SELECT * FROM feedback";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "Name: " . $row["name"]. " " ."Comments: " . $row["comment"]. "<br>";
  }
} else {
	//
}

mysqli_close($con);
?>