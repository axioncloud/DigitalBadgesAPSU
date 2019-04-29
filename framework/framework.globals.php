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

  function bake($assertion)
  {
    exec('node_modules/openbadges-bakery-v2/bin/oven '.'--in img/badges/CSCI3600.png '.'--out img/issued_badges/nate6631_CSC3600.png '.$assertion);
  }

  /* hasBadges ******************************************************************/
  // This function checks to see if the active user has any badges.
  /******************************************************************************/
  function hasBadges($userObj){
	if (isset($_SESSION["TOKEN"])){
		$ch = curl_init();
		$userName = $userObj['name'];
		curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/issued_badges/".$userName);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"],'Content-Length: 0'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);
		$hasBadges = $data['user']['hasBadges'];
		return $hasBadges;
	}
  }

  /* getUserBadges **************************************************************/
  // This function sends a cURL request to CouchDB to get all badges for a user. /
  /******************************************************************************/
  function getUserBadges($userObj){
	  if (isset($_SESSION["TOKEN"])) {

	  }
  }
