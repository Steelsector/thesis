<?php
$cat=$_GET["cat"];
if(!$cat) $cat=0;
if ($_POST["catname"]){
	myquery("insert into categories set name='?'",$_POST["catname"]);
}
if ($_POST["catdel"]){
	myquery("update categories set active=0 where id='?'",$_POST["catdel"]);
}
$result=myquery("select * from categories where active=1 order by id");
foreach ($result as $row) {
	$rowid=$row["id"];
	$rowname=$row["name"];
	if ($rowid==$cat){
	 	$class="active"; 
		}else{
		 $class="passive";
		}
	$categories.="
	<div id='category'>
		<form method='post'>
			<a href='index.php?cat=$rowid' class='$class'>$rowname</a>
			<input type='hidden' name='catdel' value='".$row["id"]."'/>
			<input type='submit' value='Delete' />
		</form>
	</div>
		";
}
$categories.="
<form method='post'>
	<input type='text' name='catname'/>
	<input type='submit' name='nemcat' value='ok'/>				


</form>\n";
?>