<?php
  require 'framework.cookiemanagement.php';
  $_SESSION["URL"] = "/";
  $_SESSION["COUCHDB"] = "localhost:5984";
  ensureAuthentication();

  /**
  * Add common functions here
  */

  /**
  * TODO: finish documentation
  * createBadge is a function that send a cURL request to the CouchDB server to create a badge
  * @param
  */
  function createBadge($badgeId, $badgeName, $description, $image='', $criteria='', $alignment=[], $tags=[])
  {
    $data = array('name' => $badgeName,
                  'description' => $description,
                  'image' => $image,
                  'criteria' => $criteria,
                  'alignment' => $alignment,
                  'tags' => $tags);
    $data_json = json_encode($data);
    print_r($data_json);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/badge_management/_design/badge_management/_update/add_badge/badges?name=$badgeId");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],'Content-Length: ' . strlen($data_json)));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  function editBadge($badgeId, $badgeName, $description, $image='', $criteria='', $alignment=[], $tags=[])
  {
    $data = array('name' => $badgeName,
                  'description' => $description,
                  'image' => $image,
                  'criteria' => $criteria,
                  'alignment' => $alignment,
                  'tags' => $tags);
    $data_json = json_encode($data);
    print_r($data_json);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/badge_management/_design/badge_management/_update/edit_badge/badges?name=$badgeId");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],'Content-Length: ' . strlen($data_json)));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $response  = curl_exec($ch);
    curl_close($ch);
  }

  function getAllBadges()
  {
    // /badge_management/_design/badge_management/_list/all_badges/badge-info
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/badge_management/_design/badge_management/_list/all_badges/badge-info");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],'Content-Length: 0'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
  }

  function getAllUsers()
  {
    // /badge_management/_design/badge_management/_list/all_badges/badge-info
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/_users/_design/_all-users/_list/users/user-info");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],'Content-Length: 0'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
  }

  function getUserInfo() {
    if (isset($_SESSION["TOKEN"])) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/_session");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],'Content-Length: 0'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response  = curl_exec($ch);
      $jsonObj = json_decode($response, true);
      curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/_users/org.couchdb.user:".$jsonObj['userCtx']['name']);
      $response = curl_exec($ch);
      $jsonObj = json_decode($response, true);
      curl_close($ch);
      return $jsonObj;
    }
  }

  function ensureAuthentication() {
    if (isset($_SESSION["TOKEN"])) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/badge_management/_all_docs");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],'Content-Length: 0'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response  = curl_exec($ch);

      $curl_info = curl_getinfo($ch);
      $code = intval($curl_info["http_code"]);

      if ($code !== 200) {
        header("Location: /framework/framework.logout.php");
      }

      curl_close($ch);
    }


  }

  function issueBadge($username, $badgeId, $expirationDate) {
    if (isset($_SESSION["TOKEN"])) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/issued_badges/$username");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);

        $curl_info = curl_getinfo($ch);
        $code = intval($curl_info["http_code"]);
        if ($code !== 200) {
          $data = array('_id' => $username,
                        'user' => array('name' => $username, 'badges' => array()));
          $data_json = json_encode($data, JSON_FORCE_OBJECT);
          var_dump($data_json);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
          $response = curl_exec($ch);
          $curl_info = curl_getinfo($ch);
          $code = intval($curl_info["http_code"]);
          echo $code;
          if ($code !== 201) {
            // couldn't add the user, something went wrong
            return false;
          }
        }
      //check if issuedAlready
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_POSTFIELDS, "");
      $response = curl_exec($ch);
      $curl_info = curl_getinfo($ch);
      $code = intval($curl_info["http_code"]);
      $json = json_decode($response, true);
      //if issued already
      //return false;
      if (array_key_exists($badgeId, $json['user']['badges'])) {
        return false;
      } else {
        // if the $expirationDate is set, convert it to the ISO standard
        // if not, set it to empty
        $expirationDate = ($expirationDate === "") ? "\"\"" : date("c", strtotime($expirationDate)) ;
        //create assertion entry
        $assertion = "{".
            "\"type\":\"Assertion\",".
            "\"recipient\":{".
              "\"name\":\"$username\"".
            "},".
            "\"image\":\"https://ioncloud64.com/img/badges/".$username."_".$badgeId.".png\",".
            "\"evidence\":\"\",".
            "\"issuedOn\":\"".date("c")."\",".
            "\"expires\":".$expirationDate.",".
            "\"badge\":\"https://ioncloud64.com:6984/badge_management/_design/badge_management/_show/get_badge/badges?badgeid=$badgeId\",".
            "\"verification\":{".
              "\"type\":\"hosted\"".
            "}".
          "}";

        //create badge entry in assertions
        curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/badge_management/_design/badge_management/_update/add_assertion/assertions?name=".$username."_".$badgeId);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $assertion);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        $response = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        $code = intval($curl_info["http_code"]);

        echo $code;
        // if something failed adding the assertion
        if ($code !== 201 && $code !== 200) {
          return false;
        }

        curl_setopt($ch, CURLOPT_URL,$_SESSION["COUCHDB"]."/issued_badges/_design/issue_management/_update/issue/$username?badgeid=".$username."_".$badgeId);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $assertion);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        $response = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        $code = intval($curl_info["http_code"]);

        echo $_SESSION["TOKEN"];
        // if something failed adding the issued badge
        if ($code !== 201 && $code !== 200) {
          return false;
        }

        //bake badge using assertion
        bake($assertion, $badgeId);
      }
        curl_close($ch);
        return true;

    } else {
      header("Location /framework/framework.logout.php");
    }
  }

  function bake($assertion, $badgeId)
  {
    echo getcwd()."<br>";
    chdir("../");
    echo getcwd()."<br>";
    $json = json_decode($assertion, true);
    $command = './node_modules/openbadges-bakery-v2/bin/oven '.'--in img/badges/'.$badgeId.'.png '.'--out img/issued_badges/'.$json['recipient']['name'].'_'.$badgeId.'.png "'.$assertion.'"';
    echo $command;
    exec($command, $output);
  }

  /* hasBadges ******************************************************************/
  // This function checks to see if the active user has any badges.
  /******************************************************************************/
  function hasBadges($userObj){
	if (isset($_SESSION["TOKEN"])){
		$userName = $userObj['name'];
		$files = glob('img/issued_badges/'.$userName.'*{png}', GLOB_BRACE);

		if (sizeOf($files) > 0)
			$hasBadges = true;
		else
			$hasBadges = false;

		return $hasBadges;

		/************************************************************************
		// The following can be used to implement hasBadges function from the
		// issued_badges database. When implemented, ensure json_decode is used
		// from the fn call in content else $hasBadges will be a String.
		/************************************************************************
		$ch = curl_init();
		$userName = $userObj['name'];
		curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/issued_badges/".$userName);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],'Content-Length: 0'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);

		if (isset($data['user'])) {                      #Prevents an exception if, for whatever reason,
		   $hasBadges = $data['user']['hasBadges'];      #the user does not have an issued_badges db entry.
		   return $hasBadges;
		}
		*/
	}
  }

  /* getUserBadges **************************************************************/
  // This function sends a cURL request to CouchDB to get all badges for a user. /
  /******************************************************************************/
  function getUserBadges($userObj){
	  if (isset($_SESSION["TOKEN"])) {

	  }
  }
