<?php

function create_user($username)
{
	try {
	$created_at = date('Y-m-d H:i:s');
	$sql = "INSERT INTO user (name, created_at) VALUES ('$username','$created_at') ;";

	$db = new db();
	$db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();	
	$db = null;
	
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
  try {
	$sql2 = "SELECT user_id FROM user WHERE name='$username' order by user_id desc Limit 1 ;";
	$db = new db();
    $db = $db->connect();
    $stmt2 = $db->query($sql2);
    $fetched = $stmt2->fetch();
    $db = null;
	} catch (PDOException $e) {
    return msgPack("failed", $e);
  }
  return msgPack("success", $fetched["user_id"]);
}

function get_player($room_id)
//{"room_id":"3395"}
{

  $sql = "SELECT name FROM user WHERE room_id = '$room_id'";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $fetched = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
	
    return msgPack("success", $fetched);
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
}
