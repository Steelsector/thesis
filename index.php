<?php
session_start();
ini_set('display_errors', 'On');
error_reporting(E_PARSE || E_ERROR || E_WARNING);
$title="Steelsector";
include_once("conf/config.php");



myconnect();

$result=myquery("select * from categories where active=1 order by id");
foreach ($result as $row){
	$mid=$row["id"];
	$mname=$row["name"];
	$menu.="<div class='menuitem'><a href='index.php?cat=$mid'>$mname</a></div>\n";
}

if($_GET['cat'] or $_GET['id']){
	include_once("inc/post.php");
} else {
	include_once("inc/rss.php");
}
include_once("inc/fcactiv.php");
$content.= "
	<div id='rightside'>$post
		<div id='pager'>$pager</div>
	</div>
	<div id='leftside'>
		<div id='home' class='home'><a href='/'>Home</a></div>
		<div id='menu' class='menubox'>$menu</div>
		<div id='fbact'>$fbact</div>
		<div id='twitt'>$twitter</div>
	</div>
";

include_once("template.html");


myclose();
?>