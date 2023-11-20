<style>
li{
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}
li:hover{
    background: #0a53be;
    cursor: pointer;
}
</style>
<div class="head   mx-2 d-md-flex d-lg-flex  justify-content-between align-items-center py-1 bg-light">
    <h2 style="font-size: 18px;">Eagles Savings
        <div id="menu" style="background: yellow; padding: 0.3rem" class="border d-block d-lg-none d-md-none border-primary float-end" aria-label="Close">Menu</div>
        <div id="close" style="background: yellow; padding: 0.3rem" class="border d-none d-lg-none d-md-none  border-primary float-end" aria-label="Close">Close</div>

    </h2>
    <div id="nav_bar" class="d-none d-md-block d-lg-block">
      <ul style="list-style: none;" class="d-block d-sm-flex d-lg-flex">
          <li>
              <a href="login.php" class="btn btn-success">
                  Login
              </a>
          </li>

          <li>
              <a href="about_us.php" class="btn btn-success">
                  About Us
              </a>
          </li>
          <li>
              <a href="dashboard.php" class="btn btn-success">
                  Dashboard
              </a>
          </li>
          <li>
              <a href="logout.php" class="btn btn-success">
                  Logout
              </a>
          </li>
      </ul>
    </div>
</div>
<script src="app.js">


</script>