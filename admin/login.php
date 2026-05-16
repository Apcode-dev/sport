<?php
session_start();
include('conn.php');

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($username) && !empty($password)) {
        $query = "SELECT * FROM tbl_admin WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if($password == $user['password']) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['login'] = "Login Successful!";
                header("Location: index.php");
                die;
            }
        }
        echo "Invalid login credentials!";
    } else {
        echo "Please fill in all fields!";
    }
}
?>
<html>
<head>
    <title>Login - Sports Order System</title>
    <link rel="stylesheet" href="../css/adminlogin.css">
</head>
<body>
    <div class="login">
        <br><br><br>
        <h2 class="text-center">Admin Login</h2>
        <br><br>
        <div class="container">
            <div class="myform">
                <!-- Login Form Starts Here -->
                <form action="" method="POST">
                    Username: <br>
                    <input type="text" name="username" placeholder="Enter Username"><br><br>
                    Password: <br>
                    <input type="password" name="password" placeholder="Enter Password"><br><br>
                    <input type="submit" name="submit" value="Login" class="btn-primary">
                    <br><br>
                </form>
            </div>
            <div class="image">
                <img src="../images/image.jpg">
            </div>
        </div>
    </div>
</body>
</html>
