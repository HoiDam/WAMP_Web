<?php

function insert_q($input,$room_id,$i)
/*{
  "the_question": "question",
  "correct_ans": "this is c1",
  "choice_2": "this is c2",
  "choice_3": "this is c3",
  "choice_4": "this is c4",  
  "room_id": "3395"
}*/
{

  $created_at = date('Y-m-d H:i:s');

  $q = $input['question'];
  $real_ans = $input['correct_answer'];
  $c2 = $input['choice2'];
  $c3 = $input['choice3'];
  $c4 = $input['choice4'];

  $i = (int)$i;
  $the_array = array($real_ans, $c2, $c3, $c4);
  shuffle($the_array);
  $actual = array_search($real_ans, $the_array);

  $sql = "INSERT INTO question(question,c1,c2,c3,c4,correct_ans,room_id,question_no,created) VALUES ('$q', '$the_array[0]', '$the_array[1]', '$the_array[2]', '$the_array[3]', $actual, '$room_id', $i,'$created_at')";

  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;

  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }
}

function get_question($room_id, $question_no)

{
  $sql = "SELECT question,c1,c2,c3,c4,correct_ans,created FROM question where question_no = '$question_no' AND room_id = '$room_id' LIMIT 1";
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

function change_question($room_id)
{

  $sql = "UPDATE room SET current_q = current_q +1 WHERE room_id = '$room_id'  ";
  try {
    $db = new db();
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;
  } catch (PDOException $e) {
    return msgPack("failed", $e);
  }

  return msgPack("success","");
}
