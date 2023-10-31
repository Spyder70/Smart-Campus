<?php
session_start();
//require("connect.php");
require("DB/config.php");
require 'class.phpmailer.php';
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
$ck=$_SESSION['SMC_Login'];
if($ck=="yes")
{
	header("location:DashBoard/");
	exit;
} 
if(isset($_POST['Submit']))
{
       
	$username = $_POST['user'];
	if($username=="admin")
	{
	goto OutHere;
	}
	$a=0;
	
	$sql ="SELECT * FROM Faculty WHERE Faculty_ID=:username ";
    	$query= $dbh -> prepare($sql);
    	$query-> bindParam(':username', $username, PDO::PARAM_STR);
    	$query-> execute();
    	$results=$query->fetchAll(PDO::FETCH_OBJ);
    	if($query->rowCount() > 0)
   	{
   	
   		foreach($results as $result)
		{
			
			$F_Name=$result->Name;
			$F_Email=$result->Email;  
		}
   		$str2="qmaidqwertyuignzexswkftpasdfghefdvbsxtghnploknedtvunfikmecgdevjhouyibndrteskhlczsrvrttbjimmfersdcthbfetgcsrt";
		$FKey = substr( $str2 ,mt_rand( 0 ,23 ) ,14 ) ;
		$FKey = $FKey.mt_rand( 1 ,9000 );
		
		$sql2 = "UPDATE Faculty SET Forgot_Key=:FKey WHERE  Faculty_ID=:username";
		$query2 = $dbh->prepare($sql2);
		$query2 -> bindParam(':FKey',$FKey, PDO::PARAM_STR);
		$query2-> bindParam(':username',$username, PDO::PARAM_STR);
		$query2 -> execute();
		
	      $Rurl="<a href='http://172.16.2.220/SMC/Reset.php?FID=".$username."&FKEY=".$FKey."' target='_blank' > Click Here To Reset</a>";
	
	
	
		//sending Email
    	$mail = new PHPMailer;
    	$mail->isSMTP();                                      
    	$mail->Host = 'smtp.gmail.com';                       
    	$mail->SMTPAuth = true;                               
    	$mail->Username = 'use@gmail.com';                          		// SMTP username
 	$mail->Password = 'passwords';              	  		// SMTP password
	$mail->SMTPSecure = 'tls';                                        // Enable encryption, 'ssl' also accepted
	$mail->Port = 587;                                                // Set the SMTP port number - 587 / 456 for authenticated TLS
	//$mail->addAttachment('RFiles/'.$usn.'-Reg.pdf');
    	$mail->setFrom('use@gmail.com', 'SMART-CAMPUS NMAMIT Nitte');              // Set who the message is to be sent from
	$mail->addAddress($F_Email,$F_Name);                                  // Add a recipient
	        								// Add a recipient
	$mail->WordWrap = 800;                                             // Set word wrap to 50 characters
	$mail->isHTML(true);                                              // Set email format to HTML
	$mail->Subject = 'Link To Reset SMART CAMPUS Login';
	$mail->Body    = " <font color='red' size='4'> $Rurl  ";
		if(!$mail->send()) 
		{
			$a=1;
			$_SESSION['a']=$a;
			$_SESSION['msg']="Unable To Send mail Try again..";
		}
		else
		{        
			$a=1;
			$_SESSION['a']=$a;
			$_SESSION['msg']="Reset Link is Sent to Your Email..";
		}	
		
	}
	else 
	{
	OutHere:
		$a=1;
		$_SESSION['a']=$a;
		$_SESSION['msg']="Couldn't find your username..!";
	}

}
 
?>
<!DOCTYPE html>
<html>
<head>
<title>Smart Campus</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="" />

	

	<!-- Custom Theme files -->
	 <link href="css/login-style.css" rel="stylesheet" type="text/css" media="all" />
	 <link href="css/login-font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
	<!-- //Custom Theme files -->

	<!-- web font -
	<link href="//fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
	<!-- //web font -->

</head>
<body>

<!-- main -->
<div class="w3layouts-main"> 
	<div class="bg-layer"><br><br>
		<h1>Smart Campus</h1><br>
		<div class="header-main">
			<div class="main-icon">
				<h3>Forgot Password</h3> <br>
			</div>
			
			<div class="header-left-bottom">
				
				<form action="Forgot.php" method="post">
					
					<div class="icon1">
						<input id="user" name="user" type="text" placeholder="Your User name" required=""/>
						<label  class="fa fa-user input-icon"></label>
					</div>
					
					
					<div class="bottom">
						<input type="submit" class="btn" id="Submit" name="Submit" value="Reset The Password"/>
					</div>
					<div class="links" style="color:orange;font-weight:bold"><center><br>
					<?php 
						if($_SESSION['a']==1){
						echo $_SESSION['msg'];
						$_SESSION['a']=0;
						}?> <span><a style="color:white;font-size:15px" href="index.php">Sign In Here</a></span>
						</center>	
					</div>
				</form>
					
			</div>
			
		</div>
		
		<!-- copyright -->
		<div class="copyright">
			<p>SmartCampus@Nmamit : 2021 &hearts; Students EMS</p>
		</div>
		<!-- //copyright --> 
	</div>
</div>	
<!-- //main -->

</body>
</html>
