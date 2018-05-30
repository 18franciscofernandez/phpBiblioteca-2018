<?php

function conectar(){
	$db="biblioteca";
	$link = mysqli_connect('localhost', 'root', '', $db);
	return $link;
}
?>