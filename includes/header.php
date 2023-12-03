<style>
li{
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.9rem;
    padding-bottom: 0.5rem;
}
li a:hover{
    cursor: pointer;
}
</style>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="head   mx-2 d-md-flex d-lg-flex  justify-content-between align-items-center  bg-light">
    <div class="text-decoration-none d-flex align-items-center justify-content-between text-uppercase" style="font-size: 18px;">
        <p style="font-size: 24px;padding-top: 0.7rem"><a href="../index.php" ">Eagles Savings</a></p>
        <div id="menu" style="padding: 0.3rem" class="border d-block d-lg-none d-md-none border-primary float-end" aria-label="Close"><i style="font-size: 27px; color: blue;" class="fa fa-bars" aria-hidden="true"></i></div>
    </div>
    <div id="nav_bar" class="d-none d-md-block d-lg-block">
      <ul style="list-style: none;" class="d-block align-items-center d-sm-flex d-lg-flex">

          <?php
          if(isset($_SESSION['user_id'])){
              echo '
              <li>
              <a href="../auth/logout.php" class="btn btn-success">
              Logout
              </a>
          </li>
              ';
               echo '<li>
              <a href="../user/index.php" class="btn btn-success">
                  Dashboard
              </a>
          </li>';
          }
          else{

              echo ' <li>
              <a href="../auth/register.php" class="btn btn-success">
                  Register
              </a>
          </li>';
              echo '  <li>
              <a href="../auth/login.php" class="btn btn-success">
                  Login
              </a>
          </li>';
          }
          ?>

          <li>
              <a style="text-decoration: none" href="../profile.php">
                  <i style="font-size: 29px;" class="fa fa-user-circle" aria-hidden="true">Profile</i>
              </a>
          </li>
      </ul>
    </div>

    <script>
        const menu = document.getElementById('menu')
        const nav_bar = document.getElementById('nav_bar')

        // Assuming 'menu' is a reference to your menu element
        menu.addEventListener('click', () => {
            nav_bar.classList.toggle('d-none')
        });
        const message = document.getElementById('message')
        function showForm() {
            message.style.display = 'block';
        }
    </script>
    <script src="../js/main.js"></script>
</div>