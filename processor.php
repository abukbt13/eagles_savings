<?php
include 'connection.php';
if(isset($_POST["register"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $time=time();

    $sql2 = "select username from users where email='$email'";
    $result2 = mysqli_query($conn, $sql2);
    $count2 = mysqli_num_rows($result2);
    if ($username == "" || $password == "" || $email == "") {
        session_start();
        $_SESSION['status'] = 'All inputs are required';
        header("Location:register.php");
    } else {

        if ($count2 > 0) {
            session_start();
            $_SESSION['status'] = 'Email already exist';
            header("location:register.php");
        }
        else {
            $save = "insert into users(username,email,password) values('$username','$email','$password')";
            $res = mysqli_query($conn, $save);
            if ($res) {
                $find = "select * from users where email='$email'";
                $retrieve = mysqli_query($conn, $find);
                $users = mysqli_fetch_all($retrieve, MYSQLI_ASSOC);


                //the password was correct
                foreach ($users as $user) {
                    $user_id = $user['user_id'];
                    $uid = $user['user_id'];
                    $role = $user['role'];
                    $username = $user['username'];
                }


                session_start();
                $_SESSION['status'] = 'SUccessfully registered';
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] =  $user_id;
                $_SESSION['uid'] =  $uid;
                $_SESSION['role'] = $role;
                header("location:dashboard.php");
            }
            else {
                session_start();
                $_SESSION['status'] = 'Something went wrong';
                header("location:register.php");
            }
        }
    }

}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $sql = "select username from users where email='$email' && password='$password'";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    if ($count == 1) {
        $find = "select * from users where email='$email'";
        $retrieve = mysqli_query($conn, $find);
        $users = mysqli_fetch_all($retrieve, MYSQLI_ASSOC);


        //the password was correct
        foreach ($users as $user) {
            $user_id = $user['user_id'];
            $uid = $user['user_id'];
            $role = $user['role'];
            $username = $user['username'];
        }
        if($role == '1'){
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['uid'] =  $uid;
            $_SESSION['status'] = 'welcome back';
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            header("location:admindashboard.php");
        }
        else{
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['uid'] =  $uid;
            $_SESSION['status'] = 'welcome back';
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            header("location:dashboard.php");
        }


    }

    else {
        session_start();
        $_SESSION['status'] = "The credentials does not match";
        header("Location:signin.php");
    }
}