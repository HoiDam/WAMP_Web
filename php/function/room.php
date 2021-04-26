<?php

function msgPack($res, $reason = "")
{
  return array("status" => $res, "msg" => $reason);
}

function create_room($user_id, $max_player, $question)
{
  $inv = rand();
  $inv_code = md5($inv);
  $room_id = rand(1000, 9999);
  try {
    if (checkuser($user_id) != false) {
      if (checkroomid($room_id) != false) {
        $sql = "INSERT INTO room (room_id,inv_code,max_player,status,current_q,list_of_player) VALUES ($room_id, '$inv_code', $max_player, 'created', 0, $user_id)";
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
      }
    }
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
  $ray = array("code: $inv_code", "room ID: $room_id");
  return msgPack("sucess", $ray);

  insert_q($question, $room_id);
}

function insert_q($question, $room_id)
{
  $stored = json_decode($question);
  $stored = shuffle($stored);
  $question_id = rand(1000, 9999);
  foreach ($stored as $value) {
    $q = $stored;
    $c1 = $stored;
    $c2 = $stored;
    $c3 = $stored;
    $c4 = $stored;
    $correct_q = $stored;
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
  $db = new db();
  $db = $db->connect();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $db = null;
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

  return msgPack("success", $stmt);
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

function checkhost($user_id)
{
}
