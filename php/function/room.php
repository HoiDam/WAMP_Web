<?php

function msgPack($res, $reason = "")
{
  return array("status" => $res, "msg" => $reason);
}

function create_room($user_id, $max_player)
{
  $inv_code = uniqid();
  $room_id = rand(1000, 9999);
  try {
    $sql = "INSERT INTO room (room_id,inv_code,max_player,status,current_q,list_of_player, now_no) VALUES ($room_id, '$inv_code', $max_player, 'created', 0, $user_id, 0)";
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
    return msgPack("success", $inv_code);
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
}


function start_room($room_id)
{
  $sql = "UPDATE room SET status = 'started' WHERE room_id = $room_id";

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
    return msgPack("success");
  } catch (PDOException $e) {
    return msgPack("failed", 'The room failed to start');
  }
}


function join_room($user_id, $inv_code)
//{"user_id": "4841", "inv_code": "6086d23d8cdc0"}
{
  $checkinv = checkinv($inv_code);
  $checkuser = checkuser($user_id);
  if ($checkinv == 1 && $checkuser == 1) {
    try {
      $sql = "SELECT room_id FROM room WHERE inv_code = '$inv_code'";
      $db = new db();
      $db = $db->connect();
      $stmt = $db->query($sql);
      $room_id = $stmt->fetch()["room_id"];
      $db = null;
      $checkmax = checkmax($room_id);
      if ($checkmax != 1) {
        return msgPack("failed", "The room has reached its upper limit of members");
      } else {
        $assign = assign_player($room_id, $user_id);
        if ($assign != 1) {
          return msgPack("failed", "The player failed to be assigned");
        } else {
          $update = update($room_id);
          if ($update != 1) {
            return msgPack("failed", "The count of player failed to update");
          } else return msgPack("succeeded", "The player joined the room");
        }
      }
    } catch (PDOException $e) {
      return msgPack("failed", $e);
    }
  } else return msgPack("failed", "Either the user id nor the code is wrong");
}

function checkuser($user_id)
{
  $sql = "SELECT * FROM user WHERE user_id = $user_id";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $fetched = $stmt->fetch();
    if ($fetched != null)  return 1;
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
};


function checkinv($inv_code)
{
  $sql = "SELECT * FROM room WHERE inv_code='$inv_code'";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $fetched = $stmt->fetch();
    if ($fetched != null)  return 1;
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
}

function checkmax($room_id)
//{"room_id":"3395"}
{
  $sql = "SELECT now_no FROM room WHERE max_player>now_no AND room_id='$room_id'";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $fetched = $stmt->fetchAll(PDO::FETCH_OBJ);
    if ($fetched != null)  return 1;
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
}

function assign_player($room_id, $user_id)
{
  $sql = "UPDATE user SET room_id='$room_id' WHERE user_id = '$user_id'";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $fetched = $stmt->execute();
    if ($fetched != null)  return 1;
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
}

function update($room_id)
{
  try {
    $sql0 = "UPDATE room SET now_no = now_no+1  WHERE room_id=$room_id";
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql0);
    $fetched = $stmt->execute();
    if ($fetched != null)  return 1;
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
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


function end_room($room_id)
{
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
