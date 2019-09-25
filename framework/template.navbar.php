<?php
switch ($_SESSION["PAGE_NAME"]) {
  case 'HOME':
    HOME:
?>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-light bg-light">
      <a class="navbar-brand" href="<?php echo $_SESSION['URL']; ?>">APSU IAS: Badge Management</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="login.php" method="POST">
          <input class="form-control mr-sm-2" name="username" type="text" placeholder="Username"
          data-toggle="tooltip" aria-label="Username"
          title="6 to 20 characters
Allowed characters [A-Z a-z 0-9 _ .]"
          pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$">
          <button class="btn btn-outline-success my-2 my-sm-0 ml-auto" type="submit">Login</button>
        </form>

        <a class="btn btn-outline-danger my-2 my-sm-0 ml-sm-2" role="button" href="register.php">Register</a>
      </div>
    </nav>
<?php
  break;
  case 'LOGIN':
    LOGIN:
?>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-light bg-light">
      <a class="navbar-brand" href="<?php echo $_SESSION['URL']; ?>">APSU IAS: Badge Management</a>
      <a class="btn btn-outline-danger my-2 my-sm-0 ml-auto" role="button" href="register.php">Register</a>
    </nav>
<?php
  break;
  default:
  case 'ERROR':
    // Probably not the most efficient or best way, but it's the jist of what this should do
    // if the login token is set, show the navigation bar for a logged in user
    // if not, show the home's navbar, which is a login bar
    if (isset($_SESSION["TOKEN"])) {
      ?>
      <!-- Navigation -->
      <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo $_SESSION['URL']; ?>">APSU IAS: Badge Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <?php
            if (in_array("_admin", $_SESSION["ROLES"])) {
            ?>
            <li class="nav-item">
              <a class="nav-link <?php echo ($_SESSION["PAGE_NAME"] === "USER_MANAGEMENT") ? "active" : "" ; ?>" href="/user_management.php">User Management</a>
            </li>
            <?php
            }
            if (in_array("issuer", $_SESSION["ROLES"]) or in_array("_admin", $_SESSION["ROLES"])) {
            ?>
            <li class="nav-item">
              <a class="nav-link <?php echo ($_SESSION["PAGE_NAME"] === "BADGE_MANAGEMENT") ? "active" : "" ; ?>" href="/badge_management.php">Badge Management</a>
            </li>
            <?php
            }
            ?>
            <li class="nav-item">
              <a class="nav-link <?php echo ($_SESSION["PAGE_NAME"] === "MY_BACKPACK") ? "active" : ""; ?>" href="/my_backpack.php">My Backpack</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0" action="framework/framework.logout.php" method="POST">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
          </form>
        </div>
      </nav>
      <?php
    } else {
      goto HOME;
    }
    break;
} ?>
