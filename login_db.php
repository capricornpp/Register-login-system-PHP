<?php
    session_start();
    $errors = array();
    include('connect_db.php');

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($username)) {
            array_push($errors, "Please enter your Username");
        }
        if (empty($password)) {
            array_push($errors, "Please enter your Password");
        }

        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM user  WHERE username = '$username' AND password = '$password' ";
            $result = mysqli_query($conn, $query);
        }

        //check ว่ามีข้อมูล อยู่ไหม
        if (mysqli_num_rows($result)){
            $_SESSION['username'] =  $username;
            $_SESSION['success'] ="You are now logged in";
            header('location: index.php');
        }else {
            array_push($errors, "Wrong !! username or password");
            $_SESSION['error'] ="Wrong !! username or password Try agian ";
            header('location: login.php');
        }
    }

?>