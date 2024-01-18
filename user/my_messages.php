<?php
session_start();
include '../connection.php';
if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:login.php');
}
$user_id= $_SESSION['user_id'];
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;

if(isset($_POST["create_message"])) {
    $message = $_POST['message'];
    $title = $_POST['title'];
    $date = date('d-m-y');

    $save = "insert into messages(message,title,date,user_id) values('$message','$title','$date',$user_id)";
    $res = mysqli_query($conn, $save);

    if($save){
        $_SESSION['status'] = 'message create successfully';
        header('Location:my_messages.php');
        die();
    }
    else{
        $_SESSION['status'] = 'An error occurred try again later';
        header('Location:my_messages.php');
        die();
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
    <title>Messages</title>
    <link rel="shortcut icon" href="../images/eagle.jpg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php
include '../includes/header.php';
?>
<div>
    <style>
        .sidebar{
            background: yellow;
            display: block;
            position: absolute;
            left: 2rem;
            top: 1rem;
        }

        .message{
            width: 23rem;
            position: absolute;
            top: 5rem;
            left: 15rem;
            background: yellow;
            z-index: 0.2;
            padding: 2rem;
            display: none;
        }
        @media (min-width: 300px) and (max-width: 600px) {
            .message {
                width: 16rem;
                position: absolute;
                top: 2rem;
                left: 2rem;
                background: grey;
                z-index: 0.2;
                padding: 2rem;
                display: none;
            }
        }

    </style>
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
    <div class="contents  d-md-flex d-lg-flex">
        <button class="d-md-none d-lg-none d-sm-block" style="color: blue;border:none;padding-right:0.5rem;margin:0.6rem;font-size: 23px;" onclick="sideBar()">
            <i  class="fa fa-align-left" aria-hidden="true">
            </i>
        </button>

        </button><div id="sidebar" class="d-none px-4 d-md-block d-lg-block">
            <h5 class="mb-1 border-bottom text-center">Dashboard</h5>
            <a href="index.php" class="text-uppercase text-decoration-none"><p>Home</p></a>

            <a href="my_savings.php" class="text-uppercase  text-decoration-none"><p>My savings</p></a>

            <a href="my_loans.php" class="text-uppercase  text-decoration-none"><p>My loans</p></a>
            <a href="my_messages.php" class="text-uppercase nav-link active  text-decoration-none"><p>Messages</p></a>
        </div>


        <div class="table-responsive">
            <table class="table border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="5" class="">
                        My messages
                        <button class="btn btn-primary float-end" onclick="createMessage()">Create message</button>
                    </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Message</th>
                    <th scope="col">Date created</th>
                    <th scope="col">status</th>
                    <th scope="col">Operations</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $savings="SELECT * FROM messages where user_id = $user_id ";
                $savingsrun=mysqli_query($conn,$savings);
                $id=1;
                while($message=mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++ ?></th>
                        <th ><?php echo $message['title'] ?></th>
                        <td><?php echo $message['message'] ?></td>
                        <td><?php echo $message['date'] ?></td>
                        <td><?php echo $message['status'] ?></td>
                        <td><button class="btn btn-success">View</button></td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>

            </table>
        </div>

    </div>


    <div id="message" class="message  rounded">
        <button type="button" onclick="closeBtn()" class="btn-close float-end" aria-label="Close"></button>

        <form action="my_messages.php" method="post">
            <p style="font-size: 20px" class="text-primary">Contact Admin for help or Queries</p>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Title</label>
                <input type="text" min="1" class="form-control" name="title">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Message</label>
                <textarea name="message"  class="form-control" rows="5"></textarea>
            </div>
            <button type="submit" name="create_message" class="btn btn-primary float-end">Submit</button>

        </form>
    </div>
    </body>


    <script src="../js/admin.js">
    </script>
    <script>
        const showmessage=document.getElementById('message')
        function createMessage(){
            showmessage.classList.toggle('d-block')
        }
        function closeBtn(){
            showmessage.classList.remove('d-block')
        }
    </script>
</html>
