<?php
include 'connection.php';
if(isset($_POST["register"])) {


    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone_number = $_POST['phone'];
    $cleaned_phone_number = ltrim($phone_number, '0');
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $time=time();
    $otp=rand(999,10000);
    $code='+254';
    $phone=$code.$cleaned_phone_number;
    $sql2 = "select first_name from users where email='$email'";
    $result2 = mysqli_query($conn, $sql2);
    $count2 = mysqli_num_rows($result2);
    if ($fname == "" || $lname == "" || $email == "") {
        session_start();
        $_SESSION['status'] = 'All inputs are required';
        header("location:auth/register.php");
    } else {

        if ($count2 > 0) {
            session_start();
            $_SESSION['status'] = 'Email already exist';
            header("location:auth/register.php");
        }
        else {
            $save = "insert into users(first_name,last_name,phone,email,password,otp) values('$fname','$lname','$phone','$email','$password','$otp')";
            $res = mysqli_query($conn, $save);
            if ($res) {
                $curl = curl_init();
                $message ="Ni ABraham nko Kutest kitu kaa unaeza tuma io code kwa whatapp kaa uko online.You have been successfully been Registered in Eagles. Verify your account using the OTP $otp ";
                $data = array(
                    'api_token' => 'BjBz8xAii6Tb7c8C4xhTBrUJkl91cSYD3Kt3n3AtQy56LtBczsVE5b3IFORUIqMVrhnjMXfRM2XdYDbgfcA2FQ',
                    'from' => 'SHARA',
                    'to' => $phone,
                    'message' => $message
                );

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://app.sharasms.co.ke/api/sms/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => http_build_query($data),
                ));

                $response = curl_exec($curl);

                $data = json_decode($response, true);

                $status = $data['status'];
                if($status == 'success'){
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['status'] = 'Check your phone for OTP  send';
                    header("location:/auth/verify.php");
                }
                else{
                    session_start();
                    $_SESSION['status'] = 'Something went wrong try again later';
                    header("location:/auth/register.php");
                }

            }
            else {
                session_start();
                $_SESSION['status'] = 'Something went wrong';
                header("location:auth/register.php");
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
            header("location:/admin/index.php");
        }
        else{
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['status'] = 'welcome back';
            $_SESSION['first_name'] = $fname;
            $_SESSION['last_name'] = $lname;
            $_SESSION['role'] = $role;
            header("location:/user/index.php");
        }


    }

    else {
        session_start();
        $_SESSION['status'] = "The credentials does not match";
        header("Location:/auth/login.php");
    }
}

if (isset($_POST['inquire'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $save = "insert into inquiries(name,email,phone,message) values('$name','$email','$phone','$message')";
    $res = mysqli_query($conn, $save);
    if($res) {
        session_start();
        $_SESSION['status'] = 'Message sent Successfully will contact you soon';
        header("location:index.php");
    }
    else{
        session_start();
        $_SESSION['status'] = 'Error sending the message try again later';
        header("location:index.php");
    }
}
if(isset($_POST["picture"])) {
    $image= $_FILES['profileimage']['name'];
    
    $imagetmp = $_FILES['profileimage']['tmp_name'];

if(empty($image)){
    move_uploaded_file($imagetmp,"profiles/". $image);
    die();
}
else{
    move_uploaded_file($imagetmp,"profiles/". $image);
    header("location:user/index.php");
    die();
}


}

if(isset($_POST['verify'])){
    session_start();
    $email=$_SESSION['email'];
    $otp=$_POST['otp'];
    $sql2 = "select first_name from users where email='$email' and otp=$otp";
    $result2 = mysqli_query($conn, $sql2);
    $count2 = mysqli_num_rows($result2);
    if ($count2 == 1) {
        $update = "update users set verified = 'YES' where email = '$email'";
        $update_run = mysqli_query($conn, $update);
        if ($update_run) {
            session_start();
            $_SESSION['status'] = 'Your account have been verified';
            header("location:/auth/login.php");
        }
    } else {
        session_start();
        $_SESSION['status'] = 'You have entered the wrong otp try again with the correct OTP';
        header("location:auth/verify.php");
    }
}