<?php

function insert_q($question, $room_id)
{
  $question = json_decode($question);
  $question_id = rand(100, 999);

  $q = $question["question"];
  $real_ans = $question["correct_ans"];
  $c2 = $question["choice_2"];
  $c3 = $question["choice_3"];
  $c4 = $question["choice_4"];
  $the_array = array("$real_ans", "$c2", "$c3", "$c4");
  shuffle($the_array);

  $sql = "INSERT INTO quiz.question(question_id,question,c1,c2,c3,c4,correct_ans,room_id) VALUES ($question_id, $q, $the_array[0], $the_array[1], $the_array[2], $the_array[4], $real_ans, $room_id)";

  $position = array_search($real_ans, $the_array);

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack('success', $position);
}

function get_question($room_id, $question_id)
{
  $sql = "SELECT question,c1,c2,c3,c4,correct_q FROM room where question_id = '$question_id' AND room_id = '$room_id'";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $stmt->fetch($sql);
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack("success", $stmt);
}

function change_question($room_id, $question_id)
{
  $old_question_id = $question_id;
  $sql = "UPDATE question SET question_id = '$question_id' WHERE question_id = $old_question_id AND room_id = $room_id";
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
