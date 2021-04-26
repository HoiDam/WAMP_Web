<?php

function get_question($room_id, $question_id)
{
  $sql = "SELECT question, c1,c2,c3,c4,correct_q FROM room where question_id = '$question_id' AND room_id = '$room_id'";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $stmt->fetch($question, $c1, $c2, $c3, $c4, $correct_q);
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack("success", $stmt);
}


function change_question($user_id, $room_id, $question_id)
{
  $old_question_id = $question_id;
  $sql = "UPDATE quiz SET question_id = '$question_id' WHERE question_id = $old_question_id";
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
