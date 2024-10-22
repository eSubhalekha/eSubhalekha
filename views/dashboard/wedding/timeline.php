<?php

//errors(1);

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

DB::connect();
$weddings = DB::select('weddings', '*', "lang = 'en'")->fetchAll();
DB::close();


$required = "required";

if ($weddingData['timeline']) {
    $required = "";
}

$timeline = [];
$timeline = json_decode($weddingData['timeline'], true);



if (isset($_REQUEST['delTimeline'])) {

    controller("AWSBucket");
    $awsObj = new AWSBucket();

    $eventid = $_REQUEST['delTimeline'];
    $imgurl = getImgURL($timeline[$eventid]['type']);

    unset($timeline[$eventid]);

    $_REQUEST['timeline'] = $timeline;
    $createWedding = $wedding->update($_REQUEST['id'], $_REQUEST['lang'], $_REQUEST);


    if (!$createWedding['error']) {
        $gallery = new Gallery();
        $getrow = $gallery->deleteByURL($_REQUEST['id'], $imgurl);

        if (!$getrow['error']) {
            $awsObj = new AWSBucket();
            $awsObj->deleteFromAWS($imgurl);

            $_SESSION['alert_message'] = "Deleted Successfully";

            echo "<script> window.history.back(); window.location.reload(true); </script>";
        }
    } else {
        $_SESSION['alert_message'] = "Failed to delete";

        echo "<script> window.history.back(); window.location.reload(true);  </script>";
    }

}

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Events</h1>


    <form id="form" method="post" enctype="multipart/form-data">
        <?php

        if (isset($_SESSION['alert_message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['alert_message'] . "</div>";
            unset($_SESSION['alert_message']);
        }


        if (isset($_POST['btn-submit'])) {

            controller("AWSBucket");
            $awsObj = new AWSBucket();

            $timeline = array();
            $eventImgArray = array();

            $timeline_prev = [];
            $timeline_prev = json_decode($weddingData['timeline'], true);

            if ($_REQUEST['event'] != null) {

                for ($i = 0; $i < count($_REQUEST['event']); $i++) {

                    if (isset($_FILES['eventPic']['name'][$i]) && strlen($_FILES['eventPic']['name'][$i]) > 0) {

                        // print_r($timeline_prev);

                        // get previous image URL and delete that
                        $imgurl = getImgURL($timeline_prev[$i]['type']);
                        $awsObj->deleteFromAWS($imgurl);

                        $filearr = array();

                        $filearr['eventPic']['name'] = $_FILES['eventPic']['name'][$i];
                        $filearr['eventPic']['tmp_name'] = $_FILES['eventPic']['tmp_name'][$i];

                        $uploadedURL = $awsObj->uploadToAWS($filearr, 'eventPic');

                        if ($uploadedURL['error']) {
                            echo '<div class="alert alert-danger">' . $uploadedURL['errorMsg'] . '</div>';
                        }

                        $eventImgArray[$i] = [
                            'weddingID' => $_REQUEST['id'],
                            'imageURL' => $uploadedURL['url'],
                            'imageName' => $_REQUEST['type'][$i],
                            'type' => 'event'
                        ];
                    }

                    // $awsObj->deleteFromAWS(getImgURL($_REQUEST['event'][$i]));
        
                    $timeline[$i] = [
                        'event' => $_REQUEST['event'][$i],
                        'type' => $_REQUEST['type'][$i],
                        'startTime' => $_REQUEST['startTime'][$i],
                        'endTime' => $_REQUEST['endTime'][$i],
                        'locationURL' => $_REQUEST['locationURL'][$i],
                        'venue' => $_REQUEST['venue'][$i],
                        'address' => str_replace("\r\n", "<br>", $_REQUEST['address'][$i])
                    ];

                }

            }


            $_REQUEST['timeline'] = $timeline;

            $createWedding = $wedding->update($_REQUEST['id'], $_REQUEST['lang'], $_REQUEST,"true");

            $addToGalleryEvents = array();

            foreach ($eventImgArray as $key => $value) {
                $addToGalleryEvents = $gallery->update($eventImgArray[$key]);
            }

            if ($createWedding['error']) {
                ?>
                <div class="alert alert-danger">
                    <?php
                    foreach ($createWedding['errorMsgs'] as $msg) {
                        if (count($msg))
                            echo $msg[0] . "<br>";
                    }
                    ?>
                </div>
                <?php
            } else if ($addToGalleryEvents['error']) {
                ?>
                    <div class="alert alert-danger">
                        <?php
                        foreach ($addToGalleryEvents['errorMsgs'] as $msg) {
                            if (count($msg))
                                echo $msg[0] . "<br>";
                        }
                        ?>
                    </div>
                <?php
            } else redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang'] . "/additional-details");

        }


        ?>


        <script type="text/javascript">
            
              // display event img
            function displayEventImage(input, rowNum) {

                const file = input.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        document.getElementById('eventImg' + rowNum).src = e.target.result;
                    
                    };

                    reader.readAsDataURL(file);
                }

            }

        </script>


        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary mb-3 float-end" id="addRowBtn"><i
                        class="bi bi-plus-circle"></i>
                    Add</button>
                <table class="table table-responsive" style="vertical-align: middle;">
                    <thead>
                        <tr>
                        </tr>
                    </thead>
                    <tbody id="dynamicTableBody">
                        <!-- Rows will be added dynamically here -->
                        <?php
                        if ($timeline != null):
                            for ($i = 0; $i < count($timeline); $i++):
                            
                                ?>

                                <tr id="row<?= $i ?>" class="row">
                                    <td>

                                     <form >
                                            <button class="btn btn-danger float-end" onclick="this.form.submit();" name="delTimeline" value="<?= $i ?>"><i
                                                class="bi bi-trash-fill"> </i></button>

                                     </form>
                                    

                                        <div class="card mb-3 p-3">
                                            <div class="row">

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="type" class="form-label">Event</label>
                                                    <select class="form-select" name="type[]" required>
                                                        <option value="" disabled>Select Event Type</option>

                                                        <option value="engagement" <?php if ($timeline[$i]['type'] == 'engagement')
                                                            echo 'selected';  ?>>Engagement</option>
                                                        <option value="mehendi" <?php if ($timeline[$i]['type'] == 'mehendi')
                                                            echo 'selected'; ?>>Mehendi</option>

                                                        <option value="sangeet" <?php if ($timeline[$i]['type'] == 'sangeet')
                                                            echo 'selected';  ?>>Sangeet</option>

                                                        <option value="baraat" <?php if ($timeline[$i]['type'] == 'baraat')
                                                            echo 'selected'; ?>>Baraat</option>

                                                        <option value="haldi" <?php if ($timeline[$i]['type'] == 'haldi')
                                                            echo 'selected'; ?>>Haldi</option>

                                                        <option value="reception" <?php if ($timeline[$i]['type'] == 'reception')
                                                            echo 'selected';  ?>>Reception</option>

                                                        <option value="muhurt" <?php if ($timeline[$i]['type'] == 'muhurt')
                                                            echo 'selected';  ?>>Muhurt</option>

                                                        <option value="other" <?php if ($timeline[$i]['type'] == 'other')
                                                            echo 'selected'; ?>>Other</option>
                                                    </select>
                                                    <strong id="typeMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="event" class="form-label">Custom Name (Optional)</label>
                                                    <input type="text" class="form-control" placeholder="Enter Custom Name"
                                                        value="<?= $timeline[$i]['event'] ?>" name="event[]">
                                                    <strong id="eventMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>
                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="startTime" class="form-label">Start Time</label>
                                                    <input type="datetime-local" class="form-control"
                                                        value="<?= $timeline[$i]['startTime'] ?>" name="startTime[]">
                                                    <strong id="startTimeMsg"
                                                        class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="endTime" class="form-label">End Time (Optional)</label>
                                                    <input type="datetime-local" class="form-control"
                                                        value="<?= $timeline[$i]['endTime'] ?>" name="endTime[]">
                                                    <strong id="endTimeMsg"
                                                        class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
                                                    <label for="locationURL" class="form-label">Location URL</label>
                                                    <input type="text" class="form-control" name="locationURL[]"
                                                        value="<?= $timeline[$i]['locationURL'] ?>">
                                                    <strong id="locationURLMsg"
                                                        class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
                                                    <label for="venue" class="form-label">Venue</label>
                                                    <input type="text" class="form-control" name="venue[]"
                                                        value="<?= $timeline[$i]['venue'] ?>">
                                                    <strong id="venueMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>


                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
                                                    <label for="Address" class="form-label">Address</label>
                                                    <textarea class="form-control" name="address[]"
                                                        rows="3"><?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?></textarea>
                                                    <strong id="AddressMsg"
                                                        class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
                                                    <label for="eventPic<?php echo $i; ?>" class="form-label"
                                                        style="position: relative;">
                                                        Image <br>

                                                        <a href="<?php echo getImgURL($timeline[$i]['type']); ?>">
                                                            <img id="eventImg<?php echo $i; ?>"
                                                            src="<?php echo getImgURL($timeline[$i]['type']); ?>"
                                                            alt="Event Image" class="rounded-circle"
                                                            style="width: 150px; height: 150px;">
                                                        </a>

                                                    </label>

                                                    <input type="file" class="form-control" id="eventPic<?php echo $i; ?>"
                                                        accept="image/*" name="eventPic[]" <?= $required ?>
                                                        onchange="displayEventImage(this,<?php echo $i; ?>)">
                                                </div>


                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            endfor;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Submit Button -->
        <button type="submit" id="btn-submit" name="btn-submit" class="btn btn-primary">Save & Next</button>
    </form>


</main>

<script>

    // JavaScript code for dynamic form functionality
    $(document).ready(function () {
        // Counter to keep track of the number of rows
        var rowCount = <?php if ($timeline != null)
            echo count($timeline);
        else
            echo 0; ?>

        // Event listener for the "Add Row" button
        $("#addRowBtn").click(function () {
            rowCount++;

            // HTML for a new row with your provided structure
            var newRow = `
            <tr id="row${rowCount}" class="row">
                <td>
                <button class="btn btn-danger float-end" onclick="deleteRow(${rowCount})"><i class="bi bi-trash-fill"></i></button>
                
           <div class="card mb-3 p-3">
           <div class="row">

           
                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="type" class="form-label">Event</label>
                                                    <select class="form-select" name="type[]">
                                                        <option value="" disabled>Select Event Type</option>
                                                        <option value="engagement" <?php if ($timeline[$i]['type'] == 'engagement')
                                                            echo 'selected';  ?>>Engagement</option>
                                                        <option value="mehendi" <?php if ($timeline[$i]['type'] == 'mehendi')
                                                            echo 'selected'; ?>>Mehendi</option>
                                                        <option value="sangeet" <?php if ($timeline[$i]['type'] == 'sangeet')
                                                            echo 'selected';  ?>>Sangeet</option>
                                                        <option value="baraat" <?php if ($timeline[$i]['type'] == 'baraat')
                                                            echo 'selected';  ?>>Baraat</option>
                                                        <option value="haldi" <?php if ($timeline[$i]['type'] == 'haldi')
                                                            echo 'selected';  ?>>Haldi</option>
                                                        <option value="reception" <?php if ($timeline[$i]['type'] == 'reception')
                                                            echo 'selected'; ?>>Reception</option>
                                                        <option value="muhurt" <?php if ($timeline[$i]['type'] == 'muhurt')
                                                            echo 'selected';  ?>>Muhurt</option>
                                                        <option value="other" <?php if ($timeline[$i]['type'] == 'other')
                                                            echo 'selected'; ?>>Other</option>
                                                    </select>
                                                    <strong id="typeMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="event" class="form-label">Custom Name (Optional)</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Custom Name"
                                                        value="<?= $timeline[$i]['event'] ?>" name="event[]">
                                                    <strong id="eventMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                
            <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
              <label for="startTime" class="form-label">Start Time</label>
              <input type="datetime-local" class="form-control" name="startTime[]">
              <strong id="startTimeMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

            <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
              <label for="endTime" class="form-label">End Time (Optional)</label>
              <input type="datetime-local" class="form-control" name="endTime[]">
              <strong id="endTimeMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

            <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
              <label for="locationURL" class="form-label">Location URL</label>
              <input type="text" class="form-control" name="locationURL[]">
              <strong id="locationURLMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

            <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
              <label for="venue" class="form-label">Venue</label>
              <input type="text" class="form-control" name="venue[]">
              <strong id="venueMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

                
            <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
              <label for="Address" class="form-label">Address</label>
              <textarea class="form-control" name="address[]" rows="3"></textarea>
              <strong id="AddressMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

            <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
              <label for="eventPic${rowCount}" class="form-label" style="position: relative;">
                   Image <br>
                    <img id="eventImg${rowCount}" src="<?php assets('img/upload.png'); ?>" alt="Event Image" class="rounded-circle" style="width: 150px; height: 150px;">

                    </label>

                    <input type="file" class="form-control" id="eventPic${rowCount}" accept="image/*" name="eventPic[]" required  onchange="displayEventImage(this,${rowCount})">
            </div>


            </div>
           </div>
                </td>
            </tr>
        `;

            // Append the new row to the table body
            $("#dynamicTableBody").append(newRow);
        });

        // Function to delete a row
        window.deleteRow = function (rowId) {
            // Remove the row with the specified ID
            $("#row" + rowId).remove();
        };


    });

</script>

<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>