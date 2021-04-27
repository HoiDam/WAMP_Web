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
      $sql = "INSERT INTO room (room_id,inv_code,max_player,status,current_q,list_of_player, now_no) VALUES ($room_id, '$inv_code', $max_player, 'created', 0, $user_id, 0)";
      $db = new db();
      $db = $db->connect();
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $db = null;
    }
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
  $ray = array("code: $inv_code", "room ID: $room_id");
  return msgPack("sucess", $ray);

  insert_q($question, $room_id);
}



function start_room($user_id, $room_id)
{
  if (checkadmin($user_id, $room_id) != false) {
    $sql = "UPDATE room SET status = 'started' WHERE room_id = $room_id";

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

  function checkadmin($user_id, $room_id)
  {
    $sql = "SELECT * from room WHERE room_id = $room_id AND user_id LIKE '%$user_id%'";

    try {
      $db = new db();
      $db = $db->connect();
      $stmt = $db->prepare($sql);
      $stmt->fetch();
      $db = null;
    } catch (PDOException $e) {
      return msgPack("failed", 'The user does not belongs to this room');
    }

    return msgPack("success", "The user belongs to the room");
  }
}



function join_room($user_id, $inv_code)
//{"user_id": "4841", "inv_code": "6086d23d8cdc0"}
{
  if (checkinv($inv_code) != false) {
    $sql0 = "SELECT room_id FROM room WHERE inv_code = '$inv_code'";
    try {
      $db = new db();
      $db = $db->connect();
      $stmt = $db->query($sql0);
      $room_id = $stmt->fetch();
      var_dump($room_id);
      checkmax($room_id);
      $db = null;
      return msgPack("succeeded", "The Invitation Code is Correct");
    } catch (PDOException $e) {
      return msgPack("failed", "The Invitation Code is Wrong");
    }

    assign_player($room_id, $user_id);
  }


  function checkmax($room_id)
  {
    try {
      $sql0 = "SELECT now_no FROM room WHERE room_id='$room_id'";
      $db = new db();
      $db = $db->connect();
      $stmt = $db->query($sql0);
      $current_no = intval($stmt->fetch());
      var_dump($current_no);
      $db = null;
      $sql1 = "SELECT now_no FROM room WHERE max_player>$current_no";
      $db = new db();
      $db = $db->connect();
      $stmt = $db->query($sql1);
      $current_no = intval($stmt->fetch());
      var_dump($current_no);
      $db = null;

      update_current($room_id, $current_no);

      return msgPack("success", "The Room have not reaches its limit");
    } catch (PDOException $e) {
      return msgPack("failed", $e);
    }
  }



  function update_current($room_id, $current_no)
  {
    try {
      $sql0 = "UPDATE room SET now_no = $current_no+1  WHERE room_id=$room_id";
      $db = new db();
      $db = $db->connect();
      $stmt = $db->prepare($sql0);
      var_dump($stmt);
      $stmt->execute();
      $db = null;
      return msgPack("success", "+1");
    } catch (PDOException $e) {
      return msgPack("failed", $e);
    }
  }




  function checkinv($inv_code)
  {
    $sql = "SELECT inv_code FROM room WHERE inv_code='$inv_code'";
    var_dump($inv_code);

    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $fetched = $stmt->fetch();
    if ($fetched != null)
      return msgPack("success", "The Code is Valid");
    else return msgPack("failed", "The Code is Invalid");
    var_dump($fetched);
    $db = null;
  }

  function get_room_status($room_id)
  {
    $sql = "SELECT status from quiz.room where room_id = $room_id";
    try {
      $db = new db();
      $db = $db->connect();
      $stmt = $db->query($sql);
      $fetched = $stmt->fetch()["status"];
      $db = null;
    } catch (PDOException $e) {
      return msgPack("failed", $e);
    }

    return msgPack("success", $fetched);
  }


  function end_room($user_id, $room_id)
  {
    checkadmin($user_id, $room_id);
    $sql = "UPDATE room SET status = 'finished', current_q = 0, now_no = 0 WHERE room_id = $room_id";

    try {
      $db = new db();
      $db = $db->connect();
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $db = null;
    } catch (PDOException $e) {
      return msgPack("failed", $e);
    }

    return msgPack("success", "The room is now closed");
  }

  
}
