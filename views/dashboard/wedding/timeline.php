<?php
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

DB::connect();
$weddings = DB::select('weddings', '*', "lang = 'en'")->fetchAll();
DB::close();

controller("Wedding");
$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);
$timeline = [];
$timeline = json_decode($weddingData['timeline'], true);
?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Events</h1>


    <form id="form" method="post">
        <?php

        if (isset($_POST['btn-submit'])) {

            $timeline = array();

            if ($_REQUEST['event'] != null) {
                for ($i = 0; $i < count($_REQUEST['event']); $i++) {
                    $timeline[$i] = [
                        'event' => $_REQUEST['event'][$i],
                        'startTime' => $_REQUEST['startTime'][$i],
                        'endTime' => $_REQUEST['endTime'][$i],
                        'locationURL' => $_REQUEST['locationURL'][$i],
                        'venue' => $_REQUEST['venue'][$i],
                        'address' => str_replace("\r\n", "<br>", $_REQUEST['address'][$i])
                    ];
                }
            }
            $_REQUEST['timeline'] = $timeline;

            $createWedding = $wedding->update($_REQUEST['id'], $_REQUEST['lang'], $_REQUEST);

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
            } else
                redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang'] . "/additional-details");

        }


        ?>
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
                                        <button class="btn btn-danger float-end" onclick="deleteRow(<?= $i ?>)"><i
                                                class="bi bi-trash-fill"></i></button>

                                        <div class="card mb-3 p-3">
                                            <div class="row">

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="event" class="form-label">Event Name</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Bride's Father Name"
                                                        value="<?= $timeline[$i]['event'] ?>" name="event[]">
                                                    <strong id="eventMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="startTime" class="form-label">Event Start Time</label>
                                                    <input type="datetime-local" class="form-control" value="<?= $timeline[$i]['startTime'] ?>" name="startTime[]">
                                                    <strong id="startTimeMsg"
                                                        class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>

                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
                                                    <label for="endTime" class="form-label">Event End Time</label>
                                                    <input type="datetime-local" class="form-control"value="<?= $timeline[$i]['endTime'] ?>"  name="endTime[]">
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
                                                    <label for="venue" class="form-label">Event Venue</label>
                                                    <input type="text" class="form-control" name="venue[]"
                                                        value="<?= $timeline[$i]['venue'] ?>">
                                                    <strong id="venueMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
                                                </div>


                                                <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
                                                    <label for="Address" class="form-label">Event Address</label>
                                                    <textarea class="form-control" name="address[]"
                                                        rows="3"><?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?></textarea>
                                                    <strong id="AddressMsg"
                                                        class="text-danger errorMsg my-2 fw-bolder"></strong>
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
              <label for="event" class="form-label">Event Name</label>
              <input type="text" class="form-control" name="event[]">
              <strong id="eventMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>
                
            <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
              <label for="startTime" class="form-label">Event Start Time</label>
              <input type="datetime-local" class="form-control" name="startTime[]">
              <strong id="startTimeMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

            <div class="mb-2 col-sm-6 col-md-4 col-lg-3">
              <label for="endTime" class="form-label">Event End Time</label>
              <input type="datetime-local" class="form-control" name="endTime[]">
              <strong id="endTimeMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

            <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
              <label for="locationURL" class="form-label">Location URL</label>
              <input type="text" class="form-control" name="locationURL[]">
              <strong id="locationURLMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

            <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
              <label for="venue" class="form-label">Event Venue</label>
              <input type="text" class="form-control" name="venue[]">
              <strong id="venueMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
            </div>

                
            <div class="mb-2 col-sm-6 col-md-4 col-lg-6">
              <label for="Address" class="form-label">Event Address</label>
              <textarea class="form-control" name="address[]" rows="3"></textarea>
              <strong id="AddressMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
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