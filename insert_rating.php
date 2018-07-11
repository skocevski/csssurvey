<?php
include 'connection.php';

if (isset($_POST["index"], $_POST["speaker_id"])) {
    $query = "INSERT INTO rating(speaker_id, rating) VALUES (:speaker_id, :rating)";
    $statement = $connect->prepare($query);
    $statement->execute(
            array(
                ':speaker_id' => $_POST["speaker_id"],
                ':rating' => $_POST["index"]
            )
    );
    $result = $statement->fetchAll();
    if (isset($result)) {
        echo 'done';
    }
}
?>
