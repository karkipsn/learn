<?php

session_start();

$db = mysqli_connect('localhost', 'root', '', 'multi_login');

// variable declaration
$username = "";
$email    = "";
$errors   = array();

if (isset($_POST['register_btn'])) {
	register();
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// to check whether the user is admin or simple user
function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database
		/*  for admin panel the user_type value will be user_type else for users the type will be the users*/

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email, user_type, password) 
			VALUES('$username', '$email', '$user_type', '$password')";
			mysqli_query($db, $query);

			$_SESSION['success']  = "New user successfully created!!";

			header('location: home.php');
		}
		else{
			$query = "INSERT INTO users (username, email, user_type, password) 
			VALUES('$username', '$email', 'user', '$password')";

			mysqli_query($db, $query);
			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');				
		}
	}
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}


// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;

	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}


function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
		foreach ($errors as $error){
			echo $error .'<br>';
		}
		echo '</div>';
	}}
	/* This function when called, tells you if a user is logged in or not by returning true or false. */
	function isLoggedIn(){

		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}}

	// LOGIN USER
		function login(){
			global $db, $username, $errors;

	// grap form values
			$username = e($_POST['username']);
			$password = e($_POST['password']);

	// make sure form is filled properly
			if (empty($username)) {
				array_push($errors, "Username is required");
			}
			if (empty($password)) {
				array_push($errors, "Password is required");
			}

	// attempt login if no errors on form
			if (count($errors) == 0) {
				$password = md5($password);

				$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
				$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);

			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

// image uploading
if (isset($_POST['upload'])) {
    // Get image name
	$image = $_FILES['image']['name'];
    // Get text
	$image_text = e($_POST['image_text']);
    //assign directory to the variable
	$target = "images/".basename($image);

	$sql = "INSERT INTO images (image, image_text) VALUES ('$image', '$image_text')";

	mysqli_query($db, $sql);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

		$msg = "Image uploaded successfully";
		header('location: activity1.php');
	}
	else{
		echo $msg = "Failed to upload image";
		header('location: activity.php');
	}
     // to check if the file is already there
	// if (file_exists($target)) {
	// 	echo "Sorry, file already exists.";
	// 	header('location: activity.php');
	// }

     // defining the file size
	// if ($_FILES["image"]["size"] > 500000) {
	// 	echo "Sorry, your file is too large.";
	// 	header('location: activity.php');
	// }

	

}	

?>