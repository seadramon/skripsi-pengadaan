<!DOCTYPE html>
<html>
<head>
<title>Rakernas BCA - Reset Password</title>
<meta charset="utf-8">
<link href="<?= site_url()?>assets/css/forgot_password.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

		<!--webfonts-->
		<link href='http://fonts.googleapis.com/css?family=Raleway:500,300,400' rel='stylesheet' type='text/css'>
		<!--//webfonts-->       
</head>

<body>
	 <!-----start-main---->
	 <div class="main">
		<div class="head"><img src="<?= site_url()?>assets/img/user.png" alt=""/></div>
		<div class="line"></div>
		<div class="login-form">
			<h1>Reset Your Password</h1>
				<form method="post" action="<?=site_url('admpage/reset_password/act')?>">
					<input type="password" name="password" id="password" placeholder="New Password">
					<input type="password" name="pass_conf" id="pass_conf" placeholder="Confirm Your New Password">
					<input type="hidden" value="<?=$email?>" name="email">
					<div class="submit">
						<input type="submit" value="Reset Password" >
					</div>
					<!--<p><a href="#">Forgot Password ?</a></p>-->
				</form>
			</div>
            
            <footer class="footer-line">
            <section class="copyright">BCA Rakernas © 2014</section>
                <!--<nav>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Developers</a></li>
                    </ul>
                </nav>-->
			</footer>
			<!--//End-login-form-->
			 <!-----start-copyright---->
   					<!--<div class="copy-right">
						<p><a href="#">Auto Kencana</a></p> 
					</div>-->
				<!-----//end-copyright---->
		</div>
			 <!-----//end-main---->
		 		
</body>
</html>