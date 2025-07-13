<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	header('location:'.$store_url.'dashboard.php');		
}

$errors = array();

if($_POST) {		

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Username is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists
			$mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];

				// set session
				$_SESSION['userId'] = $user_id;

				header('location:'.$store_url.'dashboard.php');	
			} else{
				
				$errors[] = "Incorrect username/password combination";
			} // /else
		} else {		
			$errors[] = "Username doesnot exists";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharma Vault - Sign In</title>
    <link rel="icon" href="logo.png" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="custom/css/custom.css">

    <!-- jQuery -->
    <script src="assests/jquery/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assests/bootstrap/js/bootstrap.min.js"></script>
</head>
<body style="min-height: 100vh; background: var(--gray-100); display: flex; align-items: center; justify-content: center; padding: 24px; font-family: var(--font-family);">
    <div style="background: white; border-radius: 16px; box-shadow: var(--shadow-xl); overflow: hidden; width: 100%; max-width: 400px; border: 1px solid var(--gray-200);">
        <!-- Header Section -->
        <div style="background: var(--gray-900); color: white; padding: 32px; text-align: center;">
            <div style="margin-bottom: 16px;">
                <img src="logo.png" alt="Pharma Vault" style="max-height: 50px; filter: brightness(0) invert(1);">
            </div>
            <h1 style="margin: 0; font-size: 24px; font-weight: 600;">Welcome Back</h1>
            <p style="margin: 8px 0 0 0; opacity: 0.9; font-size: 14px;">Sign in to access your inventory dashboard</p>
        </div>
        
        <!-- Form Section -->
        <div style="padding: 32px;">
            <?php if($errors): ?>
                <div style="background: var(--danger-50); color: var(--danger-600); border: 1px solid var(--danger-200); border-radius: 8px; padding: 16px; margin-bottom: 24px; border-left: 4px solid var(--danger-500);">
                    <i class="fa fa-exclamation-triangle" style="margin-right: 8px;"></i>
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo $error; ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 8px; font-size: 14px;">
                        <i class="fa fa-user" style="color: var(--gray-400); margin-right: 8px;"></i> Username
                    </label>
                    <input type="text" name="username" placeholder="Enter your username" autocomplete="off" required 
                           style="width: 100%; padding: 12px 16px; border: 2px solid var(--gray-200); border-radius: 8px; font-size: 16px; transition: var(--transition-fast); background: white;" 
                           onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px rgb(14 165 233 / 0.1)'"
                           onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'" />
                </div>
                
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 8px; font-size: 14px;">
                        <i class="fa fa-lock" style="color: var(--gray-400); margin-right: 8px;"></i> Password
                    </label>
                    <input type="password" name="password" placeholder="Enter your password" autocomplete="off" required 
                           style="width: 100%; padding: 12px 16px; border: 2px solid var(--gray-200); border-radius: 8px; font-size: 16px; transition: var(--transition-fast); background: white;" 
                           onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px rgb(14 165 233 / 0.1)'"
                           onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'" />
                </div>
                
                <button type="submit" style="width: 100%; background: var(--primary-600); color: white; border: none; padding: 14px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: var(--transition-fast); display: flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.background='var(--primary-700)'; this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.background='var(--primary-600)'; this.style.transform='translateY(0)'">
                    <i class="fa fa-sign-in"></i>
                    Sign In to Dashboard
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 24px; color: var(--gray-500); font-size: 13px;">
                <p style="margin: 0;">&copy; 2025 Pharma Vault. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>







	