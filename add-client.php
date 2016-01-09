<?php
// The fully qualified URL to your WHMCS installation root directory
$whmcsUrl = "https://secure.scaleforce.net/";

// Admin username and password
$username = "Admin";
$password = "password123";

// Get values from html form
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$companyname = $_POST["companyname"];
$email = $_POST["email"];
$address1 = $_POST["address1"];
$city = $_POST["city"];
$state = $_POST["state"];
$postcode = $_POST["postcode"];
$country = $_POST["country"];
$phonenumber = "9999999999";
$password2 = bin2hex(openssl_random_pseudo_bytes(4));

// Set post values
$postfields = array(
  'username' => $username,
  'password' => md5($password),
  'action' => 'addclient',
  'responsetype' => 'json',
  'firstname' => $firstname,
  'lastname' => $lastname,
  'companyname' => $companyname,
  'email' => $email,
  'address1' => $address1,
  'city' => $city,
  'state' => $state,
  'postcode' => $postcode,
  'country' => $country,
  'phonenumber' => $phonenumber,
  'password2' => $password2,
);

// Call the API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
$response = curl_exec($ch);
if (curl_error($ch)) {
  die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
}
curl_close($ch);

$response = file_get_contents('http://reg.j.scaleforce.net/signup?email='.$email.'&group=leb');

// Attempt to decode response as json
$jsonData = json_decode($response, true);
 
// Dump array structure for inspection
var_dump($jsonData);
?>
