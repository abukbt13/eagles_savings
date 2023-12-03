<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:login.php');
}
$user_id = $_SESSION['user_id'];
include 'connection.php';
$sql = "select * from users where  id = $user_id";
$sqlrun= mysqli_query($conn,$sql);
$user_details = mysqli_fetch_all($sqlrun, MYSQLI_ASSOC);
foreach ($user_details as $user) {
    $fname = $user['first_name'];
    $lname = $user['last_name'];
    $email = $user['email'];
    $phone= $user['phone'];
    $initialpicture= $user['profile'];
}
if(isset($_POST["edit"])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $profile = $_FILES['profile']['name'];
    $profiletmp = $_FILES['profile']['tmp_name'];
    $profile_new_name =  rand().$profile;
    $path="profiles/";
    $fullpath=$path.$initialpicture;
    if(empty($profile)){
        $update_profile = "update users set first_name = '$fname',last_name='$lname',phone = $phone where id = $user_id";
        $update_profilerun = mysqli_query($conn, $update_profile);
        if ($update_profilerun) {
            $_SESSION['status'] = 'Profile details updated successfully';
            header('Location:profile.php');
            die();
        }
    }
    else{
        $update_profile = "update users set first_name = '$fname',last_name='$lname',phone = $phone,profile='$profile_new_name' where id= $user_id";
        $update_profilerun = mysqli_query($conn, $update_profile);
        if($update_profilerun){
            if(empty($initialpicture)){
                move_uploaded_file($profiletmp,"profiles/".  $profile_new_name);

            }
            else{
                move_uploaded_file($profiletmp,"profiles/".  $profile_new_name);
                if (file_exists($fullpath)) {
                    unlink($fullpath);
                }
            }
            $_SESSION['status'] = 'Profile Updated successfully';
            header('Location:profile.php');
            die();
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
</head>
<body>
<?php include 'includes/header.php';?>

<!-- Modal -->
<div class="">
    <div class="d-flex flex-column justify-content-center align-items-center">
        <?php
        if(isset($_SESSION['status'])){
            ?>
            <div>
                <p class="text-white bg-danger btn-danger p-2"><?php echo $_SESSION['status']; ?> ?</p>
            </div>
            <?php
            unset($_SESSION['status']);
        }
        ?>
        <img style="border-radius: 50%;"  src="profiles/<?php echo $initialpicture; ?>" alt="" width="300" height="300" >
        <table style="width: 20rem;" class="table border">
            <tr class="border">
                <td class="border">
                    <h2>Name</h2>
                    <h5><?php echo $fname.' '.$lname; ?></h5>
                </td>
            </tr>
            <tr class="border">
                <td class="border">
                    <h2>Email</h2>
                    <h5><?php echo $email; ?></h5>
                </td>
            </tr>
            <tr class="border">
                <td class="border">
                    <h2>Phone</h2>
                    <h5><?php echo $phone; ?></h5>
                </td>
            </tr>

            <tr class="border">
                <td class="border">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfile">
                        Edit Profile
                    </button>
                </td>
            </tr>
        </table>
    </div>

</div>
<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="profile.php" method="post" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">First Name</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Last Name</label>
                        <input type="text" name="lname" class="form-control" value="<?php echo $lname; ?>"  aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Phone number</label>
                        <input type="number" name="phone" class="form-control" value="<?php echo $phone; ?>"aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Initial Profile</label>
                        <img src="profiles/<?php echo $initialpicture; ?>" width="120" height="120" alt="">
                        <input type="file" name="profile" class="form-control">
                    </div>

                    <button type="submit" name="edit" class="btn btn-primary float-end"> Update profile </button>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>