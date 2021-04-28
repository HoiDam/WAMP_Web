<?php
header("Access-Control-Allow-Origin：'*'");

// -- include libarary--------
require '../vendor/autoload.php'; //slim framwork
require '../src/config/db.php'; //db
require '../function/question.php';
require '../function/room.php'; 
require '../function/user.php'; 
// ---------------------------------

// --- HTTP request -------------------------------------
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// ------------------------------------------------------

$app = new \Slim\App;

// --- Question Routes -------------------------------------------------------
$app->post('/question/insert', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(insert_q($input));
});


$app->post('/question/get', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $room_id = $input['room_id'];
    $question_id = $input['question_id'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(get_question($room_id, $question_id));
});

$app->post('/question/change', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $user_id = $input['user_id'];
    $room_id = $input['room_id'];
    $question_id = $input['question_id'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(change_question($user_id, $room_id, $question_id));
});




// --- User Routes -------------------------------------------------------
$app->post('/user/create', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $username = $input['username'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(create_user($username));
});

$app->post('/user/obtain', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $room_id = $input['room_id'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(get_player($room_id));
});






// --- Room Routes -------------------------------------------------------
$app->post('/room/create', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $user_id = $input['username'];
    $max_player = $input['max_player'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(create_room($user_id, $max_player));
});

$app->post('/room/start', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $room_id = $input['room_id'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(start_room($room_id));
});

$app->post('/room/join', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $user_id = $input['user_id'];
    $inv_code = $input['inv_code'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(join_room($user_id, $inv_code));
});

$app->post('/room/status', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $room_id = $input['room_id'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(get_room_status($room_id));
});

$app->post('/room/end', function (Request $req, Response $res, $arg) {

  try {
    $input = $req->getParsedBody();
    $user_id = $input['user_id'];
    $room_id = $input['room_id'];
  } catch (Exception $e) {
    return json_encode(msgPack("failed", "parameters missing"));
  }
  return json_encode(end_room($user_id, $room_id));
});

// ---------------------------------------------------------------

$app->run();
