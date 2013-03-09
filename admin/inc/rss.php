<?php
if ($_POST["rss_name"]) {
  myquery("insert into rss_source set rss_name='?', link='?'", $_POST["rss_name"], $_POST["rss_link"]);
}

if($_POST["rss_del"]){
	myquery("update rss_source set active=0 where id='?'", $_POST["rss_del"]);
}
$result=myquery("select * from rss_source where active=1 order by id");
foreach($result as $row){
	$rowid=$row["id"];
	$rss_name=$row["rss_name"];
	$rssfeed.="
		<div id='rss_list'>
			<form method='post'>
				<a>$rss_name</a>
				<input type='hidden' name='rss_del' value='$rowid'/>
				<input type='submit' value='Delete' />
			</form>
		</div>
	";
}
//szövegmező ahova az rss linket be lehet illeszteni, gomb amivel fel lehet tölteni
$rssfeed.="
			
				<form method='post'>
					<p>RSS feed name:<input type='text' id='rss_name' name='rss_name'></p>
					<p>RSS feed link:<input type='text' id='rss_link' name='rss_link'></p>
					<p align='center'><input type='submit' name='save' value='Save'></p>
				</form>
			
			";

?>