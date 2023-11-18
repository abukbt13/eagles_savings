<?php
include 'connection.php';
if(isset($_POST["register"])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $time=time();

    $sql2 = "select first_name from users where email='$email'";
    $result2 = mysqli_query($conn, $sql2);
    $count2 = mysqli_num_rows($result2);
    if ($fname == "" || $lname == "" || $email == "") {
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
            $save = "insert into users(first_name,last_name,phone,email,password) values('$fname','$lname','$phone','$email','$password')";
            $res = mysqli_query($conn, $save);
            if ($res) {

                session_start();
                $_SESSION['status'] = 'Successfully registered login now';
                //the password was correct

                header("location:login.php");
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
    $sql = "select first_name from users where email='$email' && password='$password'";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    if ($count == 1) {
        $find = "select * from users where email='$email'";
        $retrieve = mysqli_query($conn, $find);
        $users = mysqli_fetch_all($retrieve, MYSQLI_ASSOC);


        //the password was correct
        foreach ($users as $user) {
            $user_id = $user['id'];
            $role = $user['role'];
            $fname = $user['first_name'];
            $lname = $user['last_name'];
        }
        if($role == '1'){
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['status'] = 'welcome back';
            $_SESSION['first_name'] = $fname;
            $_SESSION['last_name'] = $lname;
            $_SESSION['role'] = $role;
            header("location:admin.php");
        }
        else{
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['status'] = 'welcome back';
            $_SESSION['first_name'] = $fname;
            $_SESSION['last_name'] = $lname;
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