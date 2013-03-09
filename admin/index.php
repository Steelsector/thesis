<?php
session_start();
ini_set ('display_errors', 'On');
error_reporting(E_PARSE || E_ERROR || E_ALL);

$title="myadmin";
include_once("../conf/config.php");
myconnect();
include_once("inc/login.php");

if($_SESSION["uid"]){

	if ($_GET["rss"]) {
		include_once("inc/rss.php");
		$content.="
		<div id='adminleft'> $categories
			<p><a href='./'>Categories</a></p>
			<p><a href='?rss=1'>RSS feeds</a></p>
			<p><a href='?logout=1'>Log out</a></p>
		</div>
		<div id='adminrss'>$rssfeed</div>
		";

	} else {
		include_once("inc/category.php");
		if($cat) {
			include_once("inc/articles.php");
		} else { 
			$articles="no articles";
		}
		if($art) {
			include_once("inc/article.php"); 
		} else { 
			$article="nothing in here";
		}
		$content.="
		<div id='adminleft'> $categories
			<p><a href='?rss=1'>RSS feeds</a></p>
			<p><a href='?logout=1'>Log out</a></p>
		</div>
		<div id='admincenter'>$articles</div>
		<div id='adminright'>$article</div>
		";
	}

}

include_once("../template.html");

myclose();
?>