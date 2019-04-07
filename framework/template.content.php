<?php
switch ($_SESSION["PAGE_NAME"]) {
  case 'HOME':
?>
    <section class="container">
      <div class="row">
        <div class="col-12">
          <img class="mx-auto d-block" src="img/badges/csci3601.png" alt="CSCI 3601" style="width:50%; ">
        </div>
      </div>
    </section>
<?php
  break;
  case 'LOGIN':
    if (isset($_SESSION['STORED_POST'])) {
      $_POST = $_SESSION['STORED_POST'];
      $_SERVER['REQUEST_METHOD'] = 'POST';
      unset($_SESSION['STORED_POST']);
    }
?>
    <section class="container">
      <div class="card w-50 mx-auto">
        <div class="card-body">
          <?php
            if (isset($_SESSION["TOKEN"])) {
              if ($_SESSION["TOKEN"] === "false") {
          ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Login entry is incorrect!<br>Please try again.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php
                unset($_SESSION["TOKEN"]);
              }
            }
          ?>
          <form action="framework/framework.login.php" method="POST">
          <strong>Requirements:</strong><br>
          <ul>
            <li>6 to 20 characters</li>
            <li>Allowed characters [A-Z a-z 0-9 _ .]</li>
            <li>Underscore cannot be at the beginning or end</li>
            <li>Spaces are not allowed</li>
          </ul>
            <input class="form-control mr-sm-2" name="username" type="text" placeholder="Username"
             aria-label="Username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$" value="<?php echo $_POST['username']; ?>" required>
           <strong>Requirements:</strong><br>
           <ul>
             <li>Minimum of 8 chracters</li>
             <li>At least 1 capital letter</li>
             <li>At least 1 lowercase letter</li>
             <li>At least 1 number</li>
             <li>Allowed characters A-Z a-z 0-9 # ? ! @ $ % ^ & *</li>
             <li>Spaces are not allowed</li>
           </ul>
            <input class="form-control mr-sm-2" name="password" type="password" placeholder="Password"
            aria-label="Password" pattern="^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=[#?!@$%^&*-]*)\S{8,}$" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
          </form>
        </div>
      </div>
    </section>
<?php
  break;
  case 'DASHBOARD'
?>
    <section class="container">
      <div class="row">
        <div class="col-6 center">
          <p>You can put an image or slideshow here</p>
        </div>
      </div>
    </section>
<?php
  break;
  default:
    // TODO: 404
    break;
} ?>
