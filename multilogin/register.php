<?php include('connection.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Register</h2>
	</div>
	<form method="post" action="register.php" onsubmit="return Validate()" name="vform" >

		<php echo didplay_error(); ?>
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username" value="<?php echo $username; ?>" required>
				<div id="name_error"></div>
			</div>
			<div class="input-group">
				<label>Email</label>
				<input type="email" name="email" value="<?php echo $email; ?>" required>
				<div id="email_error"></div>
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password_1" required>
			</div>
			<div class="input-group">
				<label>Confirm password</label>
				<input type="password" name="password_2" required>
				<div id="password_error"></div>
			</div>
			<div class="input-group">
				<button type="submit" class="btn" name="register_btn">Register</button>
			</div>
			<p>
				Already a member? <a href="login.php">Sign in</a>
			</p>
		</form>
	</body>
	</html>

	<script src="jquery.min.js"></script>
<script type="scripts.js"></script>

   