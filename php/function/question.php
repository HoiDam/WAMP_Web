<?php

function insert_q($input)
/*{
  "the_question": "question",
  "correct_ans": "this is c1",
  "choice_2": "this is c2",
  "choice_3": "this is c3",
  "choice_4": "this is c4",  
  "room_id": "3395"
}*/
{
  $question_id = rand(1, 999);
  $created_at = date('Y-m-d H:i:s');

  $q = $input['the_question'];
  $real_ans = $input['correct_ans'];
  $c2 = $input['choice_2'];
  $c3 = $input['choice_3'];
  $c4 = $input['choice_4'];
  $room_id = $input['room_id'];

  $the_array = array($real_ans, $c2, $c3, $c4);
  shuffle($the_array);
  $actual = array_search($real_ans, $the_array);

  $sql = "INSERT INTO question(question_id,question,c1,c2,c3,c4,correct_ans,room_id,created) VALUES ($question_id, '$q', '$the_array[0]', '$the_array[1]', '$the_array[2]', '$the_array[3]', $actual, '$room_id', '$created_at')";

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
    return msgPack('success', $actual);
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
}

function get_question($room_id, $question_id)
//{"room_id": "3395", "question_id": "635"}
{
  $sql = "SELECT question,c1,c2,c3,c4,correct_ans,created FROM question where question_id = '$question_id' AND room_id = '$room_id' ORDER BY created";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $question_set = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    return msgPack("success", $question_set);
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
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
