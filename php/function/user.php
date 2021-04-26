<?php

function create_user($username)
{
  $user_id = rand(1000, 9999);
  $created_at = date('Y-m-d H:i:s');
  $sql = "INSERT INTO user(user_id, name, created_at) VALUES ($user_id,'$username','$created_at')";

  $db = new db();
  $db = $db->connect();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $db = null;
}
