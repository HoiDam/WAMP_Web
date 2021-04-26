<?php

function create_room($user_id, $max_player, $question)
{
  $inv = rand();
  $inv_code = md5($inv);
  $room_id = rand(1000, 9999);
  if (checkuser($user_id) != false) {
    if (checkroomid($room_id) != false) {
      $current_question = 0;
      $sql = "INSERT INTO quiz.room(room_id, inv_code, max_player, status, current_q, list_of_player) = ($room_id, $inv_code, $max_player, 'created', $current_question, '?' )";
      insert_q($question, $room_id);
    } else {
      $room_id = rand(1000, 9999);
      $sql = "INSERT INTO quiz.room(room_id, inv_code, max_player, status, current_q, list_of_player) = ($room_id, $inv_code, $max_player, 'created', $current_question, '?' )";
      insert_q($question, $room_id);
    }
  }

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack($inv_code, $room_id);
}

function insert_q($question, $room_id)
{
  $stored = json_decode($question);
  $stored = shuffle($stored);
  $question_id = rand(1000, 9999);
  foreach ($stored as $value) {
    $sql = "INSERT INTO quiz.question(question_id,question,c1,c2,c3,c4,correct_q,room_id) VALUES ($question_id, $q, $c1, $c2, $c3, $c4, $correct_q, $room_id)";
  }
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack('success');
}


function checkroomid($room_id)
{
  $sql = "SELECT * FROM room WHERE room_id = $room_id";

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", 'The room already existed');
  }

  return msgPack("success");
};

function checkuser($userid)
{
  $sql = "SELECT * FROM user WHERE user_id = $userid";

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", 'The user id is invalid');
  }

  return msgPack("success");
};

function start_room($user_id, $room_id)
{
  $sql = "UPDATE room SET status = 'started' WHERE room_id = $room_id AND user_id = $user_id";

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack("success");
}

function join_room($user_id, $inv_code)
{
  if (checkinv($inv_code) != false) {
    $sql0 = "SELECT * from quiz.room WHERE inv_code = '$inv_code'";
    try {
      $db = new db();
      $db = $db->connect();
      $stmt = $db->prepare($sql0);
      $stmt->execute();
      $db = null;
    } catch (PDOException $e) {
      return msgPack("failed", $e);
    }
    //if (checkmax($room_id) != false) {
    $sql = "INSERT INTO quiz.room (list_of_player) VALUES ($user_id)";

    try {
      $db = new db();
      $db = $db->connect();
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $db = null;
    } catch (PDOException $e) {
      return msgPack("failed", $e);
    }

    return msgPack("success");
  }
}

/* function checkmax($room_id)
{
  $sql = "SELECT max_player FROM room where room_id = $room_id";
  if (max_player == )
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
  return msgPack("success");
}
*/

function checkinv($inv_code)
{
  $sql = "SELECT * FROM quiz.room WHERE inv_code = '$inv_code'";

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack("success");
}

function get_room_status($room_id)
{
  $sql = "SELECT * from room where room_id = $room_id";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $stmt->fetch();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack("success", $status);
}


function end_room($user_id, $room_id)
{
  $sql = "UPDATE room SET status = 'finished' WHERE room_id = $room_id AND user_id = $user_id";

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
