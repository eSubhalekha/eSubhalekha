<?php
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

DB::connect();
$weddings = DB::select('weddings', '*', "lang = 'en'")->fetchAll();
DB::close();
?>

<head>
    <style type="text/css">
        th {
            text-transform: capitalize;
        }

        .action-btn {
            margin-right: 5px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
        }

        small kbd {
            vertical-align: middle;
            padding: 2px 6px;
            user-select: none !important;
            font-size: 16px;
            font-weight: bold;
            background: white;
            color: black;
            border: 1px solid black;
        }

        .table-responsive::-webkit-scrollbar {
            height: 12px !important;
            cursor: pointer !important;
        }
    </style>
</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">All Weddings</h1>
    <div class="text-end"><a class="btn btn-primary btn-sm" href="<?php echo route('wedding/new'); ?>?back=dashboard">
            Add Wedding <i class="bi bi-plus-circle"></i></a></div>
    <div class="table-responsive mb-5">
        <table id="myTable" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th class="text-center">Action</th>
                    <th class="text-nowrap">Wedding ID</th>
                    <th class="text-nowrap">Wedding Name</th>
                    <th>Host</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($weddings as $wedding) {
                    ?>
                    <tr>
                        <td class="Action text-center text-nowrap">

                            <a class="btn btn-sm btn-primary  action-btn"
                                href="<?php echo route('wedding/' . $wedding['weddingID'] . "/" . $wedding['lang']); ?>?back=dashboard"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                data-bs-title="Edit Wedding"> <i class="bi bi-pencil-square"></i></a>
                        </td>
                        <td>
                            <?= $wedding['weddingID'] ?>
                        </td>
                        <td>
                            <?= $wedding['weddingName'] ?>
                        </td>
                        <td>
                            <?= Auth::getUser($wedding['host'])['name']; ?>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

</main>


<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            language: {
                search: ""
            }
        })
        let search = document.querySelector("#myTable_filter input")
        search.placeholder = "Search"
        search.classList.remove("form-control-sm")
        search.style.width = "350px"
    })


</script>

<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>