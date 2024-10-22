<?php
// errors(1);

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

$currentUser=App::getUser();

// Set the theme details
$template = $weddingData['template'];
$themeName = ucwords(explode("_",$template)[2]);

$themeDetails = json_decode(file_get_contents('themes/'.$template.'/manifest.json'), true);

$themePrice = $themeDetails['themePrice'];
$totalAmount = $themePrice;


?>

<head>

    <style type="text/css">

        .invoiceBtn a:hover{
            color: var(--color-secondary-1);
        }

    </style>
    <!-- Add Razorpay script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<!-- Main Start -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1>Checkout</h1>
    
    <!-- Placeholder for Bootstrap alerts -->
    <div id="alertPlaceholder"></div>
    
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body position-relative">

                        <!-- Status Label -->
                        <span class="badge <?= $isPaymentDone ? 'bg-success' : 'bg-warning' ?>" style="position: absolute; top: 10px; right: 10px;">
                            <?= $isPaymentDone ? 'Paid' : 'Pending' ?>
                        </span>

                        <?php 
                            if($isPaymentDone){
                        ?>
                        <span class="invoiceBtn" style="position: absolute; top: 50px; right: 10px;">
                            <a target="_blank" href="<?php echo route('receipt/' . $_REQUEST['id'].'/'.$_REQUEST['lang']); ?>" class="badge bg-primary">  <i class="bi bi-download"></i> </a>
                        </span>
                        <?php
                            }
                        ?>

                        <!-- Plan Information -->
                        <div class="mb-3">
                            <h5>Selected Theme: <span class="text-primary"><?= $themeName ?></span></h5>
                            <p>Price: ₹ <?= $themePrice ?></p>
                        </div>

                        <!-- Price Summary -->
                        <div class="mb-3">
                            <h5>Summary</h5>
                            <h4 class="mt-1">Total: <b class="text-primary">₹ <?= $totalAmount ?></b></h4>
                        </div>

                        <!-- Checkout Button -->
                        <?php 
                            if($isPaymentDone){
                        ?>
                            <button id="checkoutBtn" class="btn btn-primary btn-sm btn-block" disabled>Payment Done</button>

                        <?php

                            }else{
                                if($completed == (sizeof($tracks)-1) ){
                        ?>

                            <button id="checkoutBtn" class="btn btn-primary btn-sm btn-block">Proceed to Checkout</button>

                        <?php

                                }else{

                                
                        ?>
                            <button id="" class="btn btn-primary btn-sm btn-block" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                data-bs-title="Complete all details necessary!" disabled>Proceed to Checkout</button>
                        <?php
                                }
                            }
                        ?>
                        
                    </div>

                    <!-- PAYMENT FORM (hidden) that will be submitted automatically when payment success -->
                    <form method="post" id="paymentIDForm">
                    	<input type="text" name="paymentID" id="paymentID" hidden="">
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Razorpay checkout configuration
    var options = {
        key: '<?php echo $config['RAZORPAY_API']; ?>', // should be placed in config.php
        amount: <?= $totalAmount * 100 ?>, // amount in paise
        currency: 'INR',
        name: 'Your Wedding Invitation Plan',
        description: 'Selected Plan: <?= $themeName ?>',
        handler: function (response) {
            // Insert data into the database on successful payment
            var paymentId = response.razorpay_payment_id;
            insertIntoDatabase(paymentId);	

        },
        prefill: {
            name: 'eSubhalekha',
            email: 'vaibhavidixit511@gmail.com',
            contact: '9284552192'
        },
        notes: {
            plan_id: 'YOUR_PLAN_ID'
        },
        theme: {
            color: '#3498db'
        }
    };

    var rzp = new Razorpay(options);

    // Event listener for checkout button
    document.getElementById('checkoutBtn').addEventListener('click', function () {
        rzp.open();
    });

    rzp.on('payment.failed', function (response){
		        alert("Payment Failed! "+response.error.description);
		});


    // Function to insert data into the database
    function insertIntoDatabase(paymentId) {
        
        // using AJAX

        jQuery.ajax({
        	type:'post',
        	url: 'payment',
            data: 'paymentID=' + paymentId + "&weddingID=" + '<?php echo $_REQUEST['id'];?>'+"&lang="+'<?php echo $_REQUEST['lang'];?>'+ "&userID=" + '<?php echo App::getUser()['userID'];?>',
        	success:function(result){
                // console.log(result);
                var response = JSON.parse(result);
                
               
        		  if (!response.error) {
                        // Success case: show success message or take further action
                        // alert(response.message); // Displays "Payment successful"
                        // Example: window.location.href = '/payment-confirmation';

                        displayAlert('success',response.message); 
                        setTimeout(() => {
                            location.reload(); // Refresh the page
                        }, 2000); // Adjust the delay time as needed

                  } else {
                        // Error case: display the error message
                        // alert("Error: " + response.errorMsgs.createPayment);
                        displayAlert('danger', + response.message); 
                        setTimeout(() => {
                            location.reload(); // Refresh the page
                        }, 2000); // Adjust the delay time as needed
                  }

        	}

        });
         

    }


// Function to display Bootstrap alerts
function displayAlert(type, message) {
    const alertPlaceholder = document.getElementById('alertPlaceholder');
    const alertElement = document.createElement('div');
    
    alertElement.className = `alert alert-${type} alert-dismissible fade show`; // Bootstrap alert classes
    alertElement.role = 'alert';
    alertElement.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertPlaceholder.append(alertElement); // Append the alert to the placeholder

    // Automatically remove the alert after 5 seconds
    setTimeout(() => {
        alertElement.classList.remove('show');
        alertElement.classList.add('hide');
        alertElement.remove();
    }, 20000);
}
</script>

<?php require('views/partials/dashboard/scripts.php') ?>


