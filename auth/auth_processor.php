<?php
include '../connection.php';
if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $otp=rand(999,10000);
    $checkemail="select * from users where email='$email'";
    $checkemail_run=mysqli_query($conn,$checkemail);
    $users = mysqli_fetch_all($checkemail_run, MYSQLI_ASSOC);

    //the password was correct
    foreach ($users as $user) {
        $phone = $user['phone'];
        $fname = $user['first_name'];
        $lname = $user['last_name'];
    }

    $count=mysqli_num_rows($checkemail_run);

    if($count==1) {

        $curl = curl_init();
                $message ="Hello $fname we have received your request for changing password.Use the  OTP $otp To change your password";
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
        curl_close($curl);
                $response = curl_exec($curl);

                $data = json_decode($response, true);

                $status = $data['status'];
        if($status == 'success'){
            echo "Status $status ";
            $otp="update users set otp='$otp' where email='$email'";
            $otp_run=mysqli_query($conn,$otp);
            if($otp_run){
                session_start();
                $_SESSION['status'] = "Check yoor phone for OTP send and use it to reset your password?";
                header("location:reset.php?email=$email");
            }
        }
        else{
            session_start();
            $_SESSION['status'] = "Something went wrong maybe network problem try again";

            header("location:forget_password.php");
        }
    }
    else{
        session_start();
        $_SESSION['status'] = "Email does not exist?";

        header("location:forget_password.php");
    }

}



if (isset($_POST['reset'])) {
    session_start();
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    if ($password != $c_password) {
        $_SESSION['status'] = "Passwords do not match";
        header("location: reset.php?email=$email");
        exit();
    } else {
        // Hash the password using a secure hashing algorithm
        $encrypted_password = md5($password);

        // Execute the SQL query to check if the email and OTP match
        $update_query = "SELECT * FROM users WHERE email='$email' AND otp='$otp'";
        $update_queryrun = mysqli_query($conn, $update_query);

        if (!$update_queryrun) {
            $_SESSION['status'] = "Error: " . mysqli_error($conn);
            header("location: reset.php?email=$email");
            exit();
        }

        $num_rows = mysqli_num_rows($update_queryrun);

        if ($num_rows == 1) {
            // Update the user's password in the database
            $update_password_query = "UPDATE users SET password='$encrypted_password' WHERE email='$email' AND otp=$otp";
            $update_password_query_run = mysqli_query($conn, $update_password_query);

            if ($update_password_query_run) {
                $_SESSION['status'] = "Password changed successfully";
                header("location: login.php");
                exit();
            } else {
                $_SESSION['status'] = "Error updating password";
                header("location: reset.php?email=$email");
                exit();
            }
        } else {
            $_SESSION['status'] = "Incorrect OTP";
            header("location: reset.php?email=$email");
            exit();
        }
    }
}

