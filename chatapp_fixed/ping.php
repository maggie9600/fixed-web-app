<?php

$html="";
if( isset( $_POST[ 'Submit' ]  ) ) {

	// Get input
	$target = $_REQUEST[ 'ip' ];
	$target = stripslashes( $target );

	// Split the IP into 4 octects
	$octet = explode( ".", $target );

	// Check IF each octet is an integer
	if( ( is_numeric( $octet[0] ) ) && ( is_numeric( $octet[1] ) ) && ( is_numeric( $octet[2] ) ) && ( is_numeric( $octet[3] ) ) && ( sizeof( $octet ) == 4 ) ) {
		// If all 4 octets are int's put the IP back together.
		$target = $octet[0] . '.' . $octet[1] . '.' . $octet[2] . '.' . $octet[3];

		// Determine OS and execute the ping command.
		if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
			// Windows
			$cmd = shell_exec( 'ping  ' . $target );
		}
		else {
			// *nix
			$cmd = shell_exec( 'ping  -c 4 ' . $target );
		}

		// Feedback for the end user
		$html .= "<pre>{$cmd}</pre>";
		echo $html;
	}
	else {
		$html .= '<pre>ERROR: You have entered an invalid IP.</pre>';
		echo $html;
	}
}

if(isset($_POST['Back'])){
	header("Location: index.php");
	exit;
}

?>	



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>Ping ChatAPP</title>

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
<div class="container">
        <br />
        <br />
        <h1 class="text-center">Ping</h1>
        <div class="row justify-content-md-center mt-5">
            
            <div class="col-md-4">
</head>
<div class="card">
    <div class="card-body">
		<form name="ping" action="" method="post">
			<div class="form-group">
        <div class="form-group">
            <label>Enter an IP address:</label>
				<input type="text" name="ip" id="ip" class="form-control" required>
			</div>
			<div class="form-group text-center">
                <input type="submit" name="Submit" id="Submit" class="btn btn-primary" value="Submit">
		</form>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
<form name="ping" action="" method="post">
	<center><input type="submit" name="Back" id="Back" value="Back"></center>
</form>
</body>
</html>

