<!DOCTYPE html>
<html>
<head>
    <title>Admin Login Of Xyz Cafe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 360px;
            padding: 40px;
            margin: 100px auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group .error-message {
            color: red;
            font-size: 14px;
        }

        .form-group .success-message {
            color: green;
            font-size: 14px;
        }

        .form-group .submit-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Login </h1>
        <?php
           require('db.php');
           session_start();
            // Define valid credentials for demonstration purposes
            if(isset($_SESSION['isSuccess'])&&$_SESSION['isSuccess']){
                header("Location:http://localhost/cafeBackendMaster/dashboard.php");
                return;
            }
            $email = $password = '';
            $uname = '';
            $error = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $query = "SELECT *FROM users WHERE email = '$email'";
                $result = $database->query($query);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Invalid email address";
                } else {
                    if (strlen($password) < 8) {
                        // Password is too short
                        $error =  "Password should be at least 8 characters long";
                    }
                }
                if($result->num_rows>0){
                    $row = $result->fetch_assoc();
                    $sPass = $row['password'];
                    $email2  = $row['email'];
                    $_SESSION['uname'] = $row['uname'];
                    if ($password == $sPass && $email == $email2) {
                        // Password is correct
                        $_SESSION['isSuccess'] = true;
                        header("Location:http://localhost/cafeBackendMaster/dashboard.php");
                    } else {
                        // Password is incorrect
                        $error =  "Invalid password: $password";
                    }
                }else{
                    $error = "Invalid Email";
                }
            }
     
        ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"required>
            </div>
            <?php if (!empty($error)) : ?>
                <div class="form-group">
                    <span class="error-message"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>
            <?php if (!empty($successMessage)) : ?>
                <div class="form-group">
                    <span class="success-message"><?php echo $successMessage; ?></span>
                </div>
            <?php endif; ?>
            <div class="form-group submit-btn">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>

</body>
</html>
