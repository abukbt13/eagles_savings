<?php
include '../connection.php';
if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $otp=rand();
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
                    'to' => '0728548760',
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
//                header("location:auth/reset.php");
            }
        }
        else{
            session_start();
            $_SESSION['status'] = "Something went wrong maybe network problem try again";
echo "Status $status ";
//            header("location:forget_password.php");
        }
    }
    else{
        session_start();
        $_SESSION['status'] = "Email does not exist?";

        header("location:forget_password.php");
    }

}
//if (isset($_POST['resetpassword'])) {
//    $email=$_POST['email'];
//    $otp=$_POST['otp'];
//
//    $password =md5($_POST['password']);
//    $confirmpassword = md5($_POST['confirmpassword']);
//
//    if($password !== $confirmpassword) {
//        session_start();
//        $_SESSION['status'] = "Password do not match?";
//
//        header("location:resetpasswordprocessor.php");
//    }
//    else{
//        $changepassword = "UPDATE users SET password='$password' WHERE email='$email' and otp='$otp'";
//        $changepassword_run=mysqli_query($conn,$changepassword);
//        if($changepassword_run){
//            session_start();
//            $_SESSION['status'] = "Password changed successfully";
//
//            header("location:signin.php");
//        }
//        else{
//            session_start();
//            $_SESSION['status'] = "Credentials does not match check try again to reset";
//            header("location:resetpassword.php");
//        }
//    }
//
//}