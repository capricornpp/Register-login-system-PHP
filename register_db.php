<?php
    session_start();
    include('connect_db.php');

    $errors = array();

    if (isset($_POST['reg_user'])) { 
        // ไม่มี อักขระ พิเศษ
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        if (empty($username)) {
            array_push($errors, "Please enter your Username");
        }
        if (empty($password_1)) {
            array_push($errors, "Please enter your Password");
        }
        if (empty($password_2)) {
            array_push($errors, "Please enter your Confirm password");
        }
        if (empty($email)) {
            array_push($errors, "Please enter your Email");
        }
        if ($password_1 != $password_2) {
            array_push($errors, "Password is not macth");
        }
        // check username , email ถ้ามีอยู่ในระบบแล้ว 
        $userCheck_query = "SELECT * FROM user WHERE username = '$username' OR email = '$email' ";
        $query = mysqli_query($conn, $userCheck_query);
        $result = mysqli_fetch_assoc($query);

        if ($result){
            if ($result['username'] === $username) {
                array_push($errors, "Username already exists");
            }
            if ($result['email'] === $email) {
                array_push($errors, "Email already exists");
            }
        }
        if (count($errors) == 0) {
            $password = md5($password_1); //เข้ารหัส md5 password ก่อนลง db

            $sql = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";
            mysqli_query($conn, $sql);

            $_SESSION['username'] =  $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }else {
            array_push($errors, "Username or email already exists");
            $_SESSION['error'] ="Username or email already exists Try agian ";
            header('location: register.php');
        }

    }

?>