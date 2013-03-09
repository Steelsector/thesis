<?php
$old=5;


if($_GET["old"]){
	$start= $start+$old;
}



$pager.="
		<form method='get'>
			<div class='new' name='new'>New posts</div>
			<div class='old' name='new'>
				<input type='hidden' value='$old'/>
				<input type='submit' value='Old Posts'/>
			</div>
		</form>

";





?>