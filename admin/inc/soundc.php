<?php
ini_set ('display_errors', 'On');
error_reporting(E_PARSE || E_ERROR || E_ALL);
//soundcloud link feltöltés
include_once("../../conf/config.php");
myconnect();

// beágyazott lejátszó
require_once 'Soundcloud/Services/Soundcloud.php';
$cid="d30d2126a101873e290c4344f58ad078";
$csecret="4d82b5b6f0eb59dbeb694c4425a5e8bc";

$result=myquery("select * from articles where id=5");
$sc_link=$result[0]["sc_link"];
var_dump($sc_link);
var_dump($result);
/*/ create a client object with your app credentials
$client = new Services_Soundcloud($cid, $csecret);
$client->setCurlOptions(array(CURLOPT_FOLLOWLOCATION => 1));

// get a tracks oembed data
$track_url = $sc_link;
$embed_info = json_decode($client->get('oembed', array('url' => $track_url)));

// render the html for the player widget
$result2= $embed_info->html;
*/
$post.="
			<div class='post'>
				<div class='title'>$title</div>
				<div class='text'>$text</div>

				<div class='player'> $sc_link
					 				</div>
					 				";


myclose();

?>


