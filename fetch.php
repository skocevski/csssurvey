<?php
include 'connection.php';
//fetch.php
$query = "SELECT * FROM speaker ORDER BY rand()";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$output = '';
foreach ($result as $row) {
    $rating = count_rating($row['speaker_id'], $connect);
    $total_rating = total_rating($row['speaker_id'], $connect);
    $color = '';
    $output .= '
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">Speaker Id: ' . $row['speaker_id'] . ' | Gender: ' . $row['speaker_gender'] . '</div>
            <div class="panel-body">
                <img src="Images/' . $row["speaker_image"] . '" class="img img-responsive" />
            </div>
            <div class="panel-footer">
                <ul class="list-inline speaker-' . $row['speaker_id'] . '" data-rating="' . $rating . '" title="Average Rating - ' . $rating . '">
                <li>Rate this:</li><br>';
    for ($count = 1; $count <= 10; $count++) {
        if ($count <= $rating) {
            $color = 'color:#ffcc00;';
        } else {
            $color = 'color:#ccc;';
        }
        $output .= '<li title="' . $count . '" id="' . $row['speaker_id'] . '-' . $count . '" data-index="' . $count . '"  data-speaker_id="' . $row['speaker_id'] . '" data-rating="' . $rating . '" class="rating" style="cursor:pointer; ' . $color . ' font-size:16px;">&#9733;</li>';
    }
    $output .= '
                </ul>
            </div>
        </div>
    </div>
 ';
}
echo $output;

function count_rating($speaker_id, $connect) {
    $output = 0;
    $query = "SELECT AVG(rating) as rating FROM rating WHERE speaker_id = '" . $speaker_id . "'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if ($total_row > 0) {
        foreach ($result as $row) {
            $output = round($row["rating"]);
        }
    }
    return $output;
}

function total_rating($speaker_id, $connect) {
    $output = 0;
    $query = "SELECT count(rating) as rating FROM rating WHERE speaker_id = '" . $speaker_id . "'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if ($total_row > 0) {
        foreach ($result as $row) {
            $output = round($row["rating"]);
        }
    }
    return $output;
}

?>