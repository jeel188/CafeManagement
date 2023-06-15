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
        <h1>Add Item To List</h1>
        <?php
        require('../db.php');
       session_start();
        if(!isset($_SESSION['isSuccess'])){
           echo"<h1>Something Went Wrong Redirecting To Login Page In Few Seconds<h1>";
           header("refresh:3;url=http://localhost:/cafeBackendMaster/login.php");
           return;
        }
            $ItemName =  '';
            $ItemPrice = 0 ;
            $error = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ItemName = $_POST['Item'];
                $ItemPrice = $_POST['ItemPrice'];
                if(!empty($ItemName)&&!empty($ItemPrice)){
                $query = "INSERT INTO `items`( `itemName`, `price`) VALUES ('$ItemName','$ItemPrice')";
                $result = $database->query($query);
                if($result){
                  $error = "Item Added To List";
    
                }
            }else{
              $error = "Please Fill Both Feilds";
            }
          }
        ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="Item Name">Enter Item Name:</label>
                <input type="text" id="Item" name="Item" required>
            </div>
            <div class="form-group">
                <label for="Item Price">Item Price:</label>
                <input type="number" id="Item Price" name="ItemPrice"required>
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
                <input type="submit" value="Add Item"><br><br>
                <input type="button" value="Go Back To Dashboard" onclick="changePage()">
            </div>
        </form>
    </div>
    <script>
    function changePage() {
      window.location.href = 'http://localhost:/cafeBackendMaster/login.php';
    }
  </script>
</body>
</html>
