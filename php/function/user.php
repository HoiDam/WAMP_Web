<?php

function create_user($username)
{
  $user_id = rand(1000, 9999);
  $created_at = getdate();
  $sql = "INSERT INTO quiz.user(user_id, name, created_at) VALUES ('$user_id','$username','$created_at')";

  try {
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
