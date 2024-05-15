<?php
session_start();
$pageTitle = 'Admin Login';

if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
{
    header('Location: dashboard.php');
}
?>

<!-- PHP INCLUDES -->

<?php include 'connect.php'; ?>
<?php include 'Includes/functions/functions.php'; ?>
<?php include 'Includes/templates/header.php'; ?>

<!-- LOGIN FORM -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Login</title>
    <style>
        body {
            background-color: #f0f0f0;
        }

        .login {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 450px;
            border: 2px solid #00FF00; /* Set border color to #7FFFD4 */
            box-shadow: 0 0 10px rgba(127, 255, 212, 0.5); /* Add box shadow */
        }

        .login100-form-title {
            font-size: 24px;
            color: #333;
            text-align: center;
            display: block;
            margin-bottom: 30px;
        }

        .form-input {
            margin-bottom: 20px;
        }

        .txt1 {
            font-size: 14px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
            color: #333;
        }

        .form-control:focus {
            border-color: #1dc116;
            box-shadow: 0 0 8px rgba(29, 193, 22, 0.4);
        }

        .btn-primary {
            background-color: #1dc116;
            border: 1px solid #1dc116;
        }

        .btn-primary:hover {
            background-color: #14a80b;
            border: 1px solid #14a80b;
        }

        .forgotPW {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="login">
    <form class="login-container validate-form" name="login-form" action="index.php" method="POST" onsubmit="return validateLoginForm()">
        <span class="login100-form-title p-b-32">
            Admin Login
        </span>
        <?php
        //Check if user click on the submit button
        if(isset($_POST['admin_login']))
        {
            $username = test_input($_POST['username']);
            $password = test_input($_POST['password']);


            //Check if User Exist In database

            $stmt = $con->prepare("Select user_id, username, password from users where username = ? and password = ?");
            $stmt->execute(array($username,$password));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            // Check if count > 0 which mean that the database contain a record about this username

            if($count > 0)
            {

                $_SESSION['username_restaurant_qRewacvAqzA'] = $username;
                $_SESSION['password_restaurant_qRewacvAqzA'] = $password;
                $_SESSION['userid_restaurant_qRewacvAqzA'] = $row['user_id'];
                header('Location: dashboard.php');
                die();
            }
            else
            {
                ?>
                <div class="alert alert-danger">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="messages">
                        <div>Username and/or password are incorrect!</div>
                    </div>
                </div>
                <?php
            }
        }
        ?>


        <!-- USERNAME INPUT -->

        <div class="form-input">
            <span class="txt1">Username</span>
            <input type="text" name="username" class="form-control username" oninput="document.getElementById('username_required').style.display = 'none'" id="user" autocomplete="off">
            <div class="invalid-feedback" id="username_required">Username is required!</div>
        </div>

        <!-- PASSWORD INPUT -->

        <div class="form-input">
            <span class="txt1">Password</span>
            <input type="password" name="password" class="form-control" oninput="document.getElementById('password_required').style.display = 'none'" id="password" autocomplete="new-password">
            <div class="invalid-feedback" id="password_required">Password is required!</div>
        </div>

        <!-- SIGNIN BUTTON -->

        <p>
            <button type="submit" name="admin_login" class="btn btn-primary">Sign In</button>
        </p>

        <!-- FORGOT PASSWORD PART -->

        <span class="forgotPW">Quên mật khẩu? <a href="quenmatkhau.php">Đặt lại tại đây.</a></span>

    </form>
</div>

</body>
</html>






<?php include 'Includes/templates/footer.php'; ?>
