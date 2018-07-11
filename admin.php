<?php
//for session_start
if ($_SESSION['username'] = '') {
    header("Location: https://csssurvey.000webhostapp.com/login.php");
} else {
    session_start();
}


//on logout click
if (isset($_GET['logout'])) {
    $_SESSION['username'] = '';
    header('Location: login.php');
}

include 'connection.php';

//fetch all
$query = "SELECT * FROM speaker ORDER BY speaker_id DESC";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            .img-responsive {
                width: auto;
                height: 300px;
                object-fit: cover;
            }

        </style>
    </head>
    <body>
<?php if ($_SESSION['username']): ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 align="center">Admin Panel</h2>
                        <ul class="breadcrumb">
                            <li>
                                Total Speaker:
    <?php
    //total vote by speaker id
    $query_ts = 'SELECT count(speaker_id) as count from speaker';
    $statement_ts = $connect->prepare($query_ts);
    $statement_ts->execute();
    $result_ts = $statement_ts->fetchColumn();
    echo $result_ts;
    ?>
                            </li>
                            <li>Total Voting:
                                <?php
                                //total vote by speaker id
                                $query_ts = 'SELECT count(rating_id) as count from rating';
                                $statement_ts = $connect->prepare($query_ts);
                                $statement_ts->execute();
                                $result_ts = $statement_ts->fetchColumn();
                                echo $result_ts;
                                ?>
                            </li>
                            <li>Total Voting for Male:
                                <?php
                                //total vote by speaker id
                                $query_ts = 'select count(speaker.speaker_gender) from speaker
                                        inner join rating on
                                        rating.speaker_id = speaker.speaker_id
                                        where speaker_gender = "m"';
                                $statement_ts = $connect->prepare($query_ts);
                                $statement_ts->execute();
                                $result_ts = $statement_ts->fetchColumn();
                                echo $result_ts;
                                ?>
                            </li>
                            <li>Total Voting for Female:
                                <?php
                                //total vote by speaker id
                                $query_ts = 'select count(speaker.speaker_gender) from speaker
                                        inner join rating on
                                        rating.speaker_id = speaker.speaker_id
                                        where speaker_gender = "f"';
                                $statement_ts = $connect->prepare($query_ts);
                                $statement_ts->execute();
                                $result_ts = $statement_ts->fetchColumn();
                                echo $result_ts;
                                ?>
                            </li>
                            <li class="pull-right">
                                <?= $_SESSION['username'] ?> | <a href="?logout=1">Logout</a>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
    <?php
    foreach ($result as $row) {
        ?>

                        <div class="col-lg-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    Speaker Id: <?php echo $row['speaker_id']; ?> | Gender: <?php echo $row['speaker_gender']; ?>
                                </div>
                                <div class="panel-body">
                                    <img src="Images/<?php echo $row['speaker_image']; ?>" class="img img-responsive">
                                </div>
                                <div class="panel-footer">
                                    <ul>
                                        <li>API SCORE:
                                            <span class="pull-right">
        <?php
        //total vote by speaker id
        $query = 'SELECT speaker_api_score from speaker where speaker_id = ' . $row['speaker_id'];
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchColumn();
        echo round($result, 4);
        ?>
                                            </span>
                                        </li>
                                        <li>Total Human Vote: 
                                            <span class="pull-right">
        <?php
        //total vote by speaker id
        $query_tv = 'SELECT count(rating) as count FROM rating where speaker_id = ' . $row['speaker_id'];
        $statement_tv = $connect->prepare($query_tv);
        $statement_tv->execute();
        $result_tv = $statement_tv->fetchColumn();
        echo $result_tv;
        ?>
                                            </span>
                                        </li>
                                        <li>Average Human Rating:
                                            <span class="pull-right">
        <?php
        //total vote by speaker id
        $query_avg = 'SELECT avg(rating) as avg from rating where speaker_id = ' . $row['speaker_id'];
        $statement_avg = $connect->prepare($query_avg);
        $statement_avg->execute();
        $result_avg = $statement_avg->fetchColumn();
        echo round($result_avg, 2);
        ?>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
    <?php } ?>


                </div>
            </div>
<?php endif; ?>
    </body>
</html>


