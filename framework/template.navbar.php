<?php
switch ($_SESSION["PAGE_NAME"]) {
  case 'HOME':
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
        <?php // TODO: If user is not logged in, display this, if they are show their accessible functions ?>
        <form class="form-inline my-2 my-lg-0" action="login.php" method="POST">
          <input class="form-control mr-sm-2" name="username" type="text" placeholder="Username" data-toggle="tooltip" aria-label="Username" title="6 to 20 characters
Allowed characters [A-Z a-z 0-9 _ .]" pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
        </form>
      </div>
    </nav>
<?php
  break;
  case 'LOGIN':
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
      </div>
    </nav>
<?php
  break;
  default:
    // TODO: 404
    break;
} ?>
