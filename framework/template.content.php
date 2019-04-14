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
                <div class="text-right">
                  <button class="btn btn-outline-success my-2 ml-auto" type="submit">Login</button>
                </div>
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
  case 'USER_MANAGEMENT':
    ?>
    <section class="container">
      <div class="row my-4">
        <div class="col-12">
          <a href="/user_account.php" class="btn btn-success">Create Account</a>
        </div>
      </div>
      <div class="row my-4 mx-1">
        <div class="col-xl-6 col-md-8 col-sm-10">
          <input class="form-control mb-2" id="userSearch" type="text" placeholder="Search users..">
          <ul class="list-group mb-4" id="users">
              <?php
              if (isset($_SESSION["TOKEN"])) {
                $ch = curl_init();
                $auth_header = array();

                $auth_header[] = 'Content-length: 0';
                $auth_header[] = 'Content-type: application/x-www-form-urlencoded';
                $auth_header[] = 'Cookie: '.$_SESSION["TOKEN"];

                curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/_users/_design/_auth/_view/user-info"); // use couchdb session database for login
                curl_setopt($ch, CURLOPT_HTTPHEADER, $auth_header);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($ch);
                // var_dump($response);
                // var_dump($_SESSION["TOKEN"]);
                $curl_info = curl_getinfo($ch);
                $code = intval($curl_info["http_code"]);
                // var_dump($code);
                $json_data = json_decode($response, true);
                if ($code !== 401) {
                  foreach ($json_data["rows"] as $user) {
                    // fName, lName
                    // uname - role
                    ?>
                    <form action="/user_account.php" method="POST">
                      <button type="submit" class="list-group-item list-group-item-action">
                        <input type="hidden" name="fName" value="<?php echo $user["value"][0]; ?>" />
                        <input type="hidden" name="lName" value="<?php echo $user["value"][1]; ?>" />
                        <input type="hidden" name="username" value="<?php echo $user["key"]; ?>" />
                        <input type="hidden" name="role" value="<?php echo $user["value"][2][0]; ?>" />
                        <h5><?php echo $user["value"][1].", ".$user["value"][0] ?></h5>
                        <small><?php echo $user["key"]." - ".$user["value"][2][0] ?></small>
                      </button>
                    </form>
                    <?php
                  }
                } else {
                  curl_close($ch);
                  header("Location: /framework/framework.logout.php");
                }
              }
              ?>
          </ul>
        </div>
      </div>
    </section>
    <?php
    break;
  case 'USER_ACCOUNT':
    if (isset($_POST["username"]) and
        isset($_POST["fName"]) and
        isset($_POST["lName"]) and
        isset($_POST["role"])) {
          // Get User info
          $username = $_POST["username"];
          $fName = $_POST["fName"];
          $lName = $_POST["lName"];
          $role = $_POST["role"];
          ?>
          <section class="container">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-7 col-sm-10 col-xs-12">
                <h5>Edit Account: <?php echo $lName.", ".$fName; ?></h5>
                <form class="" action="/framework/framework.update_userinfo.php" method="post">
                  <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" readonly><br>
                  <input class="form-control" type="text" name="fName" value="<?php echo $fName; ?>"><br>
                  <input class="form-control" type="text" name="lName" value="<?php echo $lName; ?>"><br>
                  <input class="form-control" type="text" name="role" value="<?php echo $role; ?>"><br>
                  <button class="btn btn-success" type="submit">Save Changes</button>
                </form>
              </div>
            </div>
          </section>
          <?php
    } else {
      // creating a new user
      ?>
      <section class="container">
        <div class="row">
          <div class="col-xl-6 col-lg-6 col-md-7 col-sm-10 col-xs-12">
            <h5>Create New Account</h5>
            <form class="" action="/framework/framework.update_userinfo.php" method="post">
              <input class="form-control" type="text" name="username" placeholder="Username" required><br>
              <input class="form-control" type="text" name="fName" placeholder="First Name" required><br>
              <input class="form-control" type="text" name="lName" placeholder="Last Name" required><br>
              <input class="form-control" type="text" name="password" placeholder="Password" required><br>
              <input class="form-control" type="text" name="password" placeholder="Confirm Password" required><br>
              <input class="form-control" type="text" name="role" placeholder="Authentication role" required><br>
              <button class="btn btn-success" type="submit">Create User</button>
            </form>
          </div>
        </div>
      </section>
      <?php
    }
    break;
  case 'MY_BACKPACK':
  ?>
  <?php
  break;
  case 'BADGE_MANAGEMENT':
  ?>
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
