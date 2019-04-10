<?php
switch ($_SESSION["PAGE_NAME"]) {
  case 'HOME':
?>
    <section class="container">
      <div class="row">
        <div class="col-sm-6 mx-auto">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="/img/badges/csci3601.png" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="/img/badges/csci3603.png" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="/img/badges/csci3630.png" alt="Third slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-10 mx-auto">
          <h3 class="display-4">Example Badges</h3>
          <p class="lead">
            The images above are some highlighted example badges earned in the APSU CSCI: IAS Graduate/Undergraduate program.
          </p>
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
      <div class="row">
        <div class="col-xl-6 col-lg-7 col-md-8 col-xs-12 mx-auto">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Login</h3>
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
              <strong>Username requirements:</strong><br>
              <ul>
                <li>6 to 20 characters</li>
                <li>Allowed characters [A-Z a-z 0-9 _ .]</li>
                <li>Underscore cannot be at the beginning or end</li>
                <li>Spaces are not allowed</li>
              </ul>
                <input class="form-control mr-sm-2" name="username" type="text" placeholder="Username"
                 aria-label="Username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$" value="<?php echo $_POST['username']; ?>" required>
               <strong>Password requirements:</strong><br>
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
  case 'ERROR':
    // This is a 404,403,401
    ?>
    <section class="container mb-3">
      <div class="row">
        <div class="col-6 center mx-auto w-50 text-center">
          <h1 class="display-1"><?php echo http_response_code(); ?></h1>
          <p class="">The page <b class="text-danger"><?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI']; ?></b> requested is unavailable, missing, or incorrect.</p>
          <a class="btn btn-outline-primary my-2 my-sm-0 btn-lg mx-auto center" href="/" role="button">Take me to safety!</a>
        </div>
      </div>
    </section>
    <?php
  break;
  default:
    break;
}
?>
