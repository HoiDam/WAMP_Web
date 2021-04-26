<?php

function msgPack($res, $reason = "")
{
  return array("status" => $res, "msg" => $reason);
}

function create_room($user_id, $max_player, $question)
{
  $inv_code = uniqid();
  $room_id = rand(1000, 9999);
  try {
    if (checkuser($user_id) != false) {
      if (checkroomid($room_id) != false) {
        $sql = "INSERT INTO room (room_id,inv_code,max_player,status,current_q,list_of_player, now_no) VALUES ($room_id, '$inv_code', $max_player, 'created', 0, $user_id, 0)";
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
  $question = json_decode($question);
  $question_id = rand(100, 999);

  $q = $question[0];
  $correct_q = $question[1];
  $c2 = $question[2];
  $c3 = $question[3];
  $c4 = $question[4];

  $sql = "INSERT INTO quiz.question(question_id,question,c1,c2,c3,c4,correct_q,room_id) VALUES ($question_id, $q, $correct_q, $c2, $c3, $c4, $correct_q, $room_id)";

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
  try {
    $sql = "SELECT * FROM user WHERE user_id = $userid";
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", 'The user does not exist');
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
    return msgPack("failed", 'The room failed to start');
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
