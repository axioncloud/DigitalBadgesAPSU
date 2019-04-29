<?php
switch ($_SESSION["PAGE_NAME"]) {
  case 'HOME':
?>
    <section class="container">
      <div class="row">
        <div class="col-sm-6 mx-auto">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <?php
              $files = glob('img/badges/*.{png}', GLOB_BRACE);
              $count = 0;
              foreach ($files as $file) {
                if ($count === 0) {
                  $count = $count + 1;
                  ?>
                  <div class="carousel-item active">
                    <img class="d-block w-100" src="<?php echo $file; ?>">
                  </div>
                  <?php
                } else {
                ?>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="<?php echo $file; ?>">
                  </div>
                <?php
                }
              }
              ?>
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
          <ul class="list-group mb-4" style="max-height: 75%; overflow: auto;" id="users">
              <?php
              if (isset($_SESSION["TOKEN"])) {
                $ch = curl_init();
                $auth_header = array();

                $auth_header[] = 'Content-length: 0';
                $auth_header[] = 'Content-type: application/x-www-form-urlencoded';
                $auth_header[] = 'Cookie: '.$_SESSION["TOKEN"];

                curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/_users/_design/_all-users/_list/users/user-info"); // use couchdb session database for login
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
                // var_dump($json_data);
                if ($code !== 401) {
                  foreach ($json_data as $user) {
                    // fName, lName
                    // uname - role
                    ?>
                    <form action="/user_account.php" method="POST">
                      <button type="submit" class="list-group-item list-group-item-action">
                        <input type="hidden" name="fName" value="<?php echo $user["fName"]; ?>" />
                        <input type="hidden" name="lName" value="<?php echo $user["lName"]; ?>" />
                        <input type="hidden" name="username" value="<?php echo $user["name"]; ?>" />
                        <input type="hidden" name="role" value="<?php echo $user["role"]; ?>" />
                        <h5><?php echo $user["fName"].", ".$user["lName"] ?></h5>
                        <small><?php echo 'username: '.$user["name"].'<br>role: '.$user["role"] ?></small>
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
                  <label for="username">Username: </label>
                  <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" readonly><br>
                  <label for="fName">First Name: </label>
                  <input class="form-control" type="text" name="fName" value="<?php echo $fName; ?>"><br>
                  <label for="lName">Last Name: </label>
                  <input class="form-control" type="text" name="lName" value="<?php echo $lName; ?>"><br>
                  <label for="role">Role: </label>
                  <select class="form-control" name="role" required>
                    <option value="recipient" <?php if ($role === "recipient") echo "selected"; ?>>Recipient</option>
                    <option value="issuer" <?php if ($role === "issuer") echo "selected"; ?>>Issuer</option>
                    <option value="_admin" <?php if ($role === "_admin") echo "selected"; ?>>Admin</option>
                  </select><br>
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
              <label for="username">Username: </label>
              <input class="form-control" type="text" name="username" placeholder="Username" required><br>
              <label for="fName">First Name: </label>
              <input class="form-control" type="text" name="fName" placeholder="First Name" required><br>
              <label for="lName">Last Name: </label>
              <input class="form-control" type="text" name="lName" placeholder="Last Name" required><br>
              <label for="password">Password: </label>
              <input class="form-control" type="text" name="password" placeholder="Password" required><br>
              <label for="password">Confirm Password: </label>
              <input class="form-control" type="text" name="password" placeholder="Confirm Password" required><br>
              <label for="role">Role: </label>
              <select class="form-control" name="role" required>
                <option value="recipient">Recipient</option>
                <option value="issuer">Issuer</option>
                <option value="_admin">Admin</option>
              </select><br>
              <button class="btn btn-success" type="submit">Create User</button>
            </form>
          </div>
        </div>
      </section>
      <?php
    }
    break;
  case 'MY_BACKPACK':
  $userObj = getUserInfo();

  ?>
  <section class="container">
    <div class="row my-4">
      <div class="col-12">
        <em><h3><?php echo $userObj["fName"]." ".$userObj["lName"].'\'s Backpack'; ?></h3></em>


		<?php
		if(!isset($hasBadges)){                                 #Makes sure $hasBadges is not set.
		   $hasBadges = json_decode(hasBadges($userObj));       #Check to see if user has badges. Convert result to bool.
		   #$hasBadges = true;
		   if(isset($hasBadges) && ($hasBadges === true)){      #If $hasBadges is set and true.
		?>
		    <!-- Display Badges -->
		    <div class="row">
				<div class="col-md-4">
				<div class="thumbnail">
				  <a href="/issued_badges/CSIT/IAS/CSCI3630.png">
					<img src="/issued_badges/CSIT/IAS/CSCI3630.png" alt="CSCI 3630" style="width:85%">
				  </a>
				</div>
				</div>
				<div class="col-md-4">
				<div class="thumbnail">
				  <a href="/issued_badges/CSIT/IAS/CSCI3601.png">
					<img src="/issued_badges/CSIT/IAS/CSCI3601.png" alt="CSCI 3601" style="width:85%">
				  </a>
				</div>
				</div>
				<div class="col-md-4">
				<div class="thumbnail">
				  <a href="/issued_badges/CSIT/IAS/CSCI3602.png">
					<img src="/issued_badges/CSIT/IAS/CSCI3602.png" alt="CSCI3602" style="width:85%">
				  </a>
				</div>
			</div>
		</div>

		<?php
		   } else                                               #If $hasBadges is not set or is not true
		      $hasBadges = false;                               #set to false. Fail secure.
		}

		if ($hasBadges === false) {                             #Finally, if $hasBadges is false, display a message.
		   echo '<p>No badges to display.</p>';

		} elseif ($hasBadges != true)
		   echo '<p>Something weird happened.</p>';             #We had an error.
		?>
  <?php
  break;
  case 'BADGE_MANAGEMENT':
  ?>
  <section class="container">
    <div class="row my-4">
      <div class="col-12">
        <a href="/badge_create.php" class="btn btn-success">Create Badge</a>
      </div>
    </div>
    <div class="row my-4 mx-1">
      <div class="col-xl-7 col-md-8 col-sm-10">
        <input class="form-control mb-2" id="badgeSearch" type="text" placeholder="Search badges..">
        <ul class="list-group mb-4" style="min-height: 200px; max-height: 400px; overflow: auto;" id="badges">
            <?php
            if (isset($_SESSION["TOKEN"])) {

                $json_data = getAllBadges();

                foreach ($json_data as $badge) {
                  // badgeName
                  // description - tags
                  ?>
                  <form class="mb-2" action="/badge_edit.php" method="POST">
                    <button type="submit" class="list-group-item list-group-item-action">
                      <input type="hidden" name="name" value="<?php echo $badge["name"]; ?>" />
                      <input type="hidden" name="description" value="<?php echo $badge["description"]; ?>" />
                      <input type="hidden" name="image" value="<?php echo $badge["image"]; ?>" />
                      <input type="hidden" name="criteria" value="<?php echo $badge["criteria"]; ?>" />
                      <input type="hidden" name="alignment" value="<?php foreach ($badge["alignment"] as $tag) {
                      if ($tag === end($badge["alignment"])) echo $tag;
                      else echo $tag.", ";
                    }; ?>" />
                      <input type="hidden" name="tags" value="<?php foreach ($badge["tags"] as $tag) {
                      if ($tag === end($badge["tags"])) echo $tag;
                      else echo $tag.", ";
                    }; ?>" />
                      <h5><b><?php echo $badge["name"]; ?></b></h5>
                      <div class="row">
                        <div class="col-4">
                          <img src="<?php echo $badge['image']; ?>" class="img-thumbnail">
                        </div>
                        <div class="col-8">
                          <small><?php echo $badge["description"]; ?><br>
                            tags: <em><?php foreach ($badge["tags"] as $tag) {
                            if ($tag === end($badge["tags"])) echo $tag;
                            else echo $tag.", ";
                          }; ?></em></small>
                        </div>
                      </div>
                    </button>
                  </form>
                  <?php
                }
            }
            ?>
        </ul>
      </div>
    </div>
  </section>
  <?php
  break;
  case 'BADGE_ISSUE':
  ?>
  <section class="container">
    <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-7 col-sm-10 col-xs-12">
        <h5>Edit Badge: <?php echo $_POST["name"]; ?></h5>
        <form class="" action="/framework/framework.update_badgeinfo.php" method="post">
          <label for="name">Badge Name: </label>
          <input class="form-control" type="text" name="name" placeholder="Badge Name" value="<?php echo $_POST['name']; ?>" required><br>
          <label for="description">Badge Description: </label>
          <input class="form-control" type="text" name="description" placeholder="Badge Description" value="<?php echo $_POST['description']; ?>" required><br>
          <label for="image">Badge Image: </label>
          <input class="form-control" type="file" name="image" accept="image/x-png" value="<?php echo $_POST['image']; ?>" required><br>
          <label for="criteria">Criteria: </label>
          <input class="form-control" type="text" name="criteria" placeholder="Criteria" value="<?php echo $_POST['criteria']; ?>" required><br>
          <label for="alignment">Alignment: </label>
          <input class="form-control" type="text" name="alignment" placeholder="Alignment" value="<?php echo $_POST['alignment']; ?>" required><br>
          <label for="tags">Tags: </label>
          <input class="form-control" type="text" name="tags" placeholder="Tags" value="<?php echo $_POST['tags']; ?>" required><br>
          <button class="btn btn-success" type="submit">Issue</button>
        </form>
      </div>
    </div>
  </section>
  <?php
  break;
  case 'BADGE_CREATE':
  ?>
  <section class="container">
    <div class="row">
      <div class="col-xl-8 col-lg-7 col-md-7 col-sm-10 col-xs-12 mb-3 mt-3">
        <h5>Create a New Badge</h5>
        <form class="" action="/framework/framework.update_badgeinfo.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-6">
              <label for="name">Badge Name: </label>
              <input class="form-control" type="text" name="name" placeholder="Badge Name" required><br>
              <label for="description">Badge Description: </label>
              <input class="form-control" type="text" name="description" placeholder="Badge Description"  required><br>
              <label for="tags">Tags: </label>
              <input class="form-control" type="text" name="tags" placeholder="Tags" required><br>
            </div>
            <div class="col-6">
              <label for="criteria">Criteria: </label>
              <input class="form-control" type="url" name="criteria" placeholder="Criteria" required><br>
              <label for="alignment">Alignment: </label>
              <input class="form-control" type="text" name="alignment" placeholder="Alignment" ><br>
            </div>
          </div>
          <label for="image">Badge Image: </label>
          <input class="form-control" type="file" name="image" accept="image/x-png" required><br>
          <button class="btn btn-success" type="submit">Create Badge</button>
        </form>
      </div>
    </div>
  </section>
  <?php
  break;
  case 'BADGE_EDIT':
  ?>
  <section class="container">
    <div class="row">
      <div class="col-xl-9 col-lg-7 col-md-7 col-sm-10 col-xs-12 mb-3 mt-3">
        <h5>Edit Badge: <?php echo $_POST["name"]; ?></h5>
        <form class="" action="/framework/framework.update_badgeinfo.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="image_url" value="<?php echo $_POST['image']; ?>">
          <div class="row">
            <div class="col-6">
              <label for="name">Badge Name: </label>
              <input class="form-control" type="text" name="name" placeholder="Badge Name" value="<?php echo $_POST['name']; ?>" required><br>
              <label for="description">Badge Description: </label>
              <input class="form-control" type="text" name="description" placeholder="Badge Description" value="<?php echo $_POST['description']; ?>" required><br>
              <label for="tags">Tags: </label>
              <input class="form-control" type="text" name="tags" placeholder="Tags" value="<?php echo $_POST['tags']; ?>" required><br>
            </div>
            <div class="col-6">
              <label for="criteria">Criteria: </label>
              <input class="form-control" type="url" name="criteria" placeholder="Criteria" value="<?php echo $_POST['criteria']; ?>" required><br>
              <label for="alignment">Alignment: </label>
              <input class="form-control" type="text" name="alignment" placeholder="Alignment" value="<?php echo $_POST['alignment']; ?>"><br>
            </div>
          </div>
          <label for="image">Badge Image: </label>
          <input class="form-control" type="file" name="image" accept="image/x-png" value="<?php echo $_POST['image']; ?>"><br>
          <img class="img-fluid" src="<?php echo $_POST['image']; ?>"><br>
          <button class="btn btn-success" type="submit">Save Badge</button>
        </form>
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
