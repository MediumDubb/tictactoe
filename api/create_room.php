<?php
header("Content-Type: application/json");

require_once('../database/connect.php');

// init game room secret word

$submission = $_REQUEST;

$select_game_room = '';

$secret_word = 'INSERT INTO game_room (secret_word) VALUES (:secret_word)';
$grab_room = $dbh->prepare("SELECT * FROM game_room WHERE secret_word ='" . $submission['secret_word']. "'");

if ( isset($submission['secret_word']) ) {
    $data = [
        'secret_word' => $submission['secret_word']
    ];

    $dbh->prepare($secret_word)->execute($data);

    $grab_room->execute();
    $result = $grab_room->setFetchMode(PDO::FETCH_ASSOC);

    if ($result) {
        $assoc_array = $grab_room->fetch();
        echo json_encode($assoc_array);
    } else {
        echo json_encode(['Error' => 'Room not created']);
    }
}

