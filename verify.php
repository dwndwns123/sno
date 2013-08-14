<?php require ('inc/head.php'); 

if($_SESSION["logged"]){
  include('inc/already-logged-in.php');
} else {
 
  $age = $_POST["regAge"];
  if ($age == '') {
      $age = 0;
  }
 
  if(!is_null($_POST["regTitle"]) && $_POST["regFirstname"] && $_POST["regLastname"] && $_POST["regEmail"] && $_POST["regPassword"] && !is_null($_POST["regCountry"]) && $_POST["regRole"] && !is_null($_POST["regGender"]) && !is_null($_POST["regOption"])){
    // we arrived by posting from the registration form and all the fields are here

    $sql = sprintf("SELECT * FROM Users WHERE email='%s'",
                   mysql_real_escape_string($_POST[regEmail]));
    
    $checkUser = mysql_query($sql) or die(mysql_error());
    $user = mysql_fetch_array($checkUser);
    $exists=0;
    if(mysql_num_rows($checkUser)==1){
      $exists=1;
      $message = '<div class="alert alert-error">That email address is already registered.</div>';  
    } else {
      $ver = md5(uniqid(mt_rand(), true));
      $pass = md5($_POST["regPassword"]);

      $sql = sprintf("INSERT INTO Users (title_id,first_name,last_name,email,password,role,age,gender_id,option_id,country_id,verification) VALUES ('$_POST[regTitle]','%s','%s','%s','$pass','%s','$age','$_POST[regGender]','$_POST[regOption]','$_POST[regCountry]','$ver')",
                     mysql_real_escape_string($_POST[regFirstname]),
                     mysql_real_escape_string($_POST[regLastname]),
                     mysql_real_escape_string($_POST[regEmail]),
                     mysql_real_escape_string($_POST[regRole]));

      mysql_query($sql) or die(mysql_error());

      $emailText = "Thanks for registering on the SNOMED CT Field Test Website.\r\n\r\nPlease verify your email address by visiting ".$configvars["environment"]["url"]."/verify.php and entering your verification code:\r\n\r\n".$ver;
      $subject = $configvars["email"]["subjecttag"]." - Registration";
      $to = $_POST["regEmail"];
      $headers = 'From: '.$configvars["email"]["fromname"].' <'.$configvars["email"]["fromemail"].'>' . "\r\n" . 'Reply-To: '.$configvars["email"]["fromname"].' <'.$configvars["email"]["fromemail"].'>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

      mail($to, $subject, $emailText, $headers);
      $exists=0;
    }
  }
?>
<title>SNOMED CT GP/FP RefSet Field Test - Registration confirmation</title>
</head>
<body>
	<div class="container">
		<?php
        require ('inc/header.php');
		?>
		<div class="main clearfix">

			<div class="page-header">
				<h1>Registration confirmation</h1>
			</div>
			<?php
if($message){
echo $message;
}
if ($exists == 0) {
			?>
			<div class="row">
				<div class="span12">
					<div class="well">
						<p class="lead">
							Thank you for registering for the GP/FP RefSet and ICPC mapping field test.
						</p>
						<p>
							A verification email has been sent to you.
						</p>
						<p>
							Please retrieve the verification code from this email and enter it below to confirm your email address.
						</p>
					</div>
				</div>
			</div>

			<div class="row span8 offset2">
				<form class="form-horizontal" id="verify" method="post" action="check-verification.php" data-validate="parsley">
					<fieldset>
						<div class="control-group">
							<label class="control-label" for="verEmail">Email address</label>
							<div class="controls">
								<input type="text" id="verEmail" name="verEmail" placeholder="Email address" value="<?= (empty($_POST["regEmail"]) ? '' : $_POST["regEmail"]); ?>" data-trigger="change" data-required="true" data-type="email">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="verCode">Verification code</label>
							<div class="controls">
								<input type="text" id="verCode" name="verCode" placeholder="Verification code" data-required="true">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input type="submit" class="btn" value="Go">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<p>
									<a href="resend-verification.php">Resend verification?</a>
								</p>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<?php
            } else {
			?>
			<div class="row">
				<div class="span12">
					<p>
						<a class="btn" href="index.php">Click here to login</a>
					</p>
				</div>
			</div>
			<?php
            }
            }
			?>
		</div>
		<?php
        require ('inc/footer.php');
		?>
	</div>

	<?php
    require ('inc/script.php');
?>
</body>
</html>