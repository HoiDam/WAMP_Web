<?php

function msgPack($res, $reason = "")
{
  return array("status" => $res, "msg" => $reason);
}

function create_room($max_player, $question)
{

	$room_id = null;
	$dic = null; 
	$max_player = (int)$max_player;
	$question_total = count($question);
	
	$inv_code = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
	  try {
		$sql = "INSERT INTO room (inv_code,max_player,status,current_q, now_no,question_total) VALUES ('$inv_code', $max_player, 'created', 0, 0,$question_total)";
		$db = new db();
		$db = $db->connect();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$db = null;

		
	  } catch (PDOException $e) {
		return msgPack("failed", $e);
	  }
	  try {
		$sql2 = "SELECT room_id FROM room WHERE inv_code='$inv_code' order by room_id desc Limit 1 ;";
		$db = new db();
		$db = $db->connect();
		$stmt2 = $db->query($sql2);
		$fetched = $stmt2->fetch();
		$room_id = $fetched["room_id"];
		$dic = array($inv_code, $room_id);
		//return msgPack("test",$room_id);
		$db = null;
		} catch (PDOException $e) {
		return msgPack("failed", $e);
	  }
	  for ($i=0 ; $i < count($question) ;$i++)
		{
		  insert_q($question[$i], $room_id, $i);
		}
	  return msgPack("success",$dic);
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
          } else return msgPack("success", $room_id);
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
  $sql = "SELECT status, current_q , question_total from quiz.room where room_id = $room_id";
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
