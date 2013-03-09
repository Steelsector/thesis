<?php
/*
$login_email=$_POST["login_email"];
$login_pass=$_POST["login_pass"];
*/
foreach($_POST as $key => $value) $$key=$value;

//kiléptetés
if($_GET["logout"]) unset($_SESSION["uid"]);

// ellenőrizzük, volt-e belépés
if( $login_submit){
	$error=0;
	$result=myquery("select * from users where email='?' and admin>0", $login_email);
	if(count($result)){
		//jelszó ellenőrzés
		if($result[0]["password"]==sha1($login_pass)){
			$_SESSION ["uid"]=$result[0]["id"];
			header("Location: index.php");
			exit;
		}else {
			$error=1;
		}
	} else {
		$error=1;
	}
	if ($error){
		$content.="<div class='errormsg'>Hibás belépési adatok!</div>";
	}
}

// beléptetőform, ha nem vagyunk belépve
if(!$_SESSION["uid"]){
	$content.= "
	<div align='center' id='loginbox'>
	<table>
		<form method='post'>
		<tr>
			<td>E-mail: </td>
			<td><input type='text' name='login_email' value='$login_email'/></td>
		</tr>
		<tr>
			<td>Jelszó: </td>
			<td><input type='password' name='login_pass' value=''/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class='right'><input type='submit' name='login_submit' value='Login'/></td>
		</tr>
		</form>
	</table>
	</div>
	";
}
	

?>