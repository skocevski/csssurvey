<?php
//index.php
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
            .modal{
                color: white;
            }
            .modal-header, .modal-footer{
                background-color: #00a7d0 !important;
            }
            .modal-body{
                background-color: #00c0ef !important;

            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2 align="center">
                Survey on Beauty / Conference Speakers 
                <span class="pull-right" style="font-size:14px;font-weight: bold;color:red;">
                    <a href="#" data-toggle="tooltip" data-placement="bottom" style="color: red"
                       title="This survey purpose is to collect human rating in order to find out how do the self-presentation of male and female scientist differ with respect to their pictures.">
                        (?)
                    </a>
                </span>

            </h2>

            <br />
            <div class="row">
                <div id="speaker_list">

                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade modal-info" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Introduction to Survey on Beauty / Conference Speaker</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <b>Beauty / Conference Speaker</b> <br>
                            We are conducting an academic survey about Beauty / Conference Speaker. <br>The purpose of survey is to collect 
                            human rating in order to find out how do the self-presentation 
                            of male and female scientist differ with respect to their pictures.<br><br>
                            We thank you in advance for survey participation.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Start Survey</button>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>

<script>


    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        })
        load_speaker();
        function load_speaker()
        {
            $.ajax({
                url: "fetch.php",
                method: "POST",
                success: function (data)
                {
                    $('#speaker_list').html(data);
                }
            });
        }

        $(document).on('mouseenter', '.rating', function () {
            var index = $(this).data("index");
            var speaker_id = $(this).data('speaker_id');
            remove_background(speaker_id);
            for (var count = 1; count <= index; count++)
            {
                $('#' + speaker_id + '-' + count).css('color', '#ffcc00');
            }
        });

        function remove_background(speaker_id)
        {
            for (var count = 1; count <= 10; count++)
            {
                $('#' + speaker_id + '-' + count).css('color', '#ccc');
            }
        }

        $(document).on('mouseleave', '.rating', function () {
            var index = $(this).data("index");
            var speaker_id = $(this).data('speaker_id');
            var rating = $(this).data("rating");
            remove_background(speaker_id);
            //alert(rating);
            for (var count = 1; count <= rating; count++)
            {
                $('#' + speaker_id + '-' + count).css('color', '#ffcc00');
            }
        });

        //rating click
        $(document).on('click', '.rating', function () {
            var index = $(this).data("index");
            var speaker_id = $(this).data('speaker_id');
            $.ajax({
                url: "insert_rating.php",
                method: "POST",
                data: {index: index, speaker_id: speaker_id},
                success: function (data)
                {
                    if (data == 'done')
                    {
                        console.log("You have rated " + index + " out of 10.");
                        //$('.list-inline').html("<li>You have rated " + index + " out of 10.</li>");
                        $(".speaker-" + speaker_id + "").html("<li>You have rated " + index + " out of 10.</li>");
                        //alert("You have rate " + index + " out of 5");
                    } else
                    {
                        alert("There is some problem in System");
                    }
                }
            });

        });

    });
</script>
