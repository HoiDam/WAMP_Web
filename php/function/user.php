<?php

function create_user($username)
{
  try {
    $user_id = rand(1000, 9999);
    $created_at = date('Y-m-d H:i:s');
    $sql = "INSERT INTO user(user_id, name, created_at) VALUES ($user_id,'$username','$created_at')";

    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
  return msgPack("success", $user_id);
}

function get_player($room_id)
//{"room_id":"3395"}
{

  $sql = "SELECT * FROM user WHERE room_id = '$room_id'";
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

function assign_player($room_id, $user_id)
//{"room_id":"3395", "user_id":"2529"}
{
  if (checkuser($user_id) != false) {
    if (checkroom($room_id) != false) {
      $sql = "UPDATE user SET room_id='$room_id' WHERE user_id = '$user_id'";
      try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $fetched = $stmt->execute();
        $db = null;
        return msgPack("success", $fetched);
      } catch (PDOException $e) {
        return msgPack("failed", $e);
      }
    }
  }
}

function checkuser($user_id)
{
  try {
    $sql = "SELECT * FROM user WHERE user_id = $user_id";
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $fetched = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    return msgPack("success", $fetched);
  } catch (PDOException $e) {
    return msgPack("failed", 'The user does not exist');
  }
};

function checkroom($room_id)
{
  try {
    $sql = "SELECT * FROM room WHERE room_id = $room_id";
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $fetched = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    return msgPack("success", $fetched);
  } catch (PDOException $e) {
    return msgPack("failed", 'The room does not exist');
  }
};
