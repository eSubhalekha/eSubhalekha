<?php

// errors(1);

$config['APP_TITLE'] = "Login | ".$config['APP_TITLE'];

$roleLogin = "user";

if(isset($_REQUEST['role'])){
  $roleLogin = $_REQUEST['role'];
}


DB::connect();
$customers = DB::select('users', '*', "status <> 'deleted'")->fetchAll();
DB::close();

if (App::getSession())
  redirect('/');

controller("Auth");
$user = new Auth();

$loginMsg=array();
  
?>

<?php
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["action"] == "verifyUser") {
        // send otp to user
        $phone = $_POST["phone"];

        $sendOTP=$user->sendOTP($phone,$roleLogin);

       if(!$sendOTP['error']){

            $register = $user->register($phone,$otp,$roleLogin);

            if($register){
                $loginMsg['msg']="OTP Sent Successfully!";
                $loginMsg['class']="success";
            } 
        }else{
          $loginMsg['msg']="Unable to send OTP!";
          $loginMsg['class']="danger";
        }
        
    } elseif ($_POST["action"] == "registerUser") {
        // verify OTP and then register

        $phone = $_POST["phone"];

        $otp1 = $_POST['otp1'];
        $otp2 = $_POST['otp2'];
        $otp3 = $_POST['otp3'];
        $otp4 = $_POST['otp4'];

        // Combine the digits into a full OTP
        $otp = $otp1 . $otp2 . $otp3 . $otp4;

        $register=$user->verifyOTP($phone,$otp);


         if( (isset($register['status']) && $register['status']=="verified") || (isset($register['error']) && !$register['error'])){

            $login=$user->login($phone);
            $loginMsg['msg']="Login Successful!";
            $loginMsg['class']="success";
            
        }
        else{
            $loginMsg['msg']=$register['errorMsgs']['otp'];
            $loginMsg['class']="danger";
        }


    }
}

?>

<!doctype html>
<html lang="en">
<?php include("views/partials/head.php"); ?>

<style>
  .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin-top: 2vh !important;
    margin: auto;
  }

  .form-signin .checkbox {
    font-weight: 400;
  }

  .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
  }

  .form-signin .form-control:focus {
    z-index: 2;
  }

  .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }

  #eye {
    cursor: pointer;
  }

  .logo img {
    max-height: 12vh;
  }
</style>

<body class="text-center">
  <?php require('views/partials/nav.php'); ?>
  <div class="logo mt-5 pt-5">
    <a href="<?php echo home() ?>"><img src="<?php echo home() . $config['APP_ICON']; ?>" alt="graphene"
        class="img-fluid"></a>
  </div>
  <form  method="POST" name="Login" class="form-signin" id="loginForm">

    <h2 class="mb-3 fw-bolder">Log In</h1>
      <?php if ($_GET['loggedout'] && !isset($loginMsg['msg'])) { ?>
        <div class="alert alert-success" role="alert">
          <?php echo "Logged Out Successfully"; ?>
        </div>
      <?php } ?>
      <?php if (isset($loginMsg['msg'])) { ?>
        <div class="alert alert-<?php echo $loginMsg['class']; ?>" role="alert">
          <?php echo $loginMsg['msg']; ?>
        </div>
      <?php } ?>

      <?php csrf() ?>
      
      <label for="phone">Phone Number</label>
        
        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?php echo (!empty($_REQUEST['phone'])) ? $_REQUEST['phone'] : ''; ?>" required <?php if(!empty($_REQUEST['phone'])){echo "readonly";}else{echo ""; } ?> >

        <strong id="phoneMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>

        <?php if((isset($_POST["action"]) && $_POST["action"] == "verifyUser") || $register['errorMsgs']['otp'] ){ ?>
        
          <div id="otpInput">
              <label for="otp">OTP</label>
              <div style="display: flex; gap: 10px;">
                  <input type="number" name="otp1" maxlength="1" class="form-control otp-input" required>
                  <input type="number" name="otp2" maxlength="1" class="form-control otp-input" required>
                  <input type="number" name="otp3" maxlength="1" class="form-control otp-input" required>
                  <input type="number" name="otp4" maxlength="1" class="form-control otp-input" required>
              </div>

              <strong id="otpMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
              <br>
          </div>



        <button class="btn btn-lg btn-primary rounded-pill" type="submit" name="action" value="registerUser">Login</button>
        <?php }else{ ?>

        <button class="btn btn-lg btn-primary rounded-pill" id="btn-register" type="submit" name="action" value="verifyUser">Verify</button>
      <?php } ?>


      <p class="mt-3">Don't Have an account? <a href="<?php echo route('register').queryString(); ?>">Create Account</a></p>
  </form>




  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/core.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
  
  <script>


    // for OTP block focus, prev-next 
    const otpInputs = document.querySelectorAll('.otp-input');
    
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            // Move to the next field on number input
            if (e.key >= 0 && e.key <= 9 && input.value.length === 1) {
                e.preventDefault();
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            }
            // Backspace key functionality to move to the previous field
            else if (e.key === 'Backspace' && input.value === '') {
                if (index > 0) {
                    otpInputs[index - 1].focus();
                }
            }
        });

        // Automatically focus the next input after typing
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

    });

    let phoneError = true;
    let phone = document.querySelector("#phone");

    let phones = []

    <?php
    foreach ($customers as $email) {
      echo "phones.push('" . md5($email['phone']) . "')\n";
    }
    ?>

    checkErrors();

    function validateMobile(mobilenumber) {
      var regmm = "^([6-9][0-9]{9})$";
      var regmob = new RegExp(regmm);
      if (regmob.test(mobilenumber)) {
        return true;
      } else {
        return false;
      }
    }

    function validatephone() {
      let phoneValue = phone.value.trim();
      let phoneMsg = document.querySelector("#phoneMsg")
      if (phone.value.trim() == "") {
        phoneError = true;
        checkErrors();
        phoneMsg.innerText = "Mobile number can't be empty";
        phone.classList.add("is-invalid");
      }
      else if (!validateMobile(phoneValue)) {
        phoneError = true;
        checkErrors();
        phoneMsg.innerText =
          "Mobile number is invalid (10 digits only)";
        phone.classList.add("is-invalid");
      } else if (!phones.includes(CryptoJS.MD5(phoneValue).toString())) {
        phoneError = true
        checkErrors()
        phoneMsg.innerText = "Phone does not exists!"
        phone.classList.add("is-invalid")
      } else {
        phoneError = false;
        checkErrors();
        phone.classList.remove("is-invalid");
        phone.classList.add("is-valid");
        phoneMsg.innerText = "";
      }
    }

    phone.addEventListener("focusout", function () {
      validatephone();
    });
    phone.addEventListener("keyup", function () {
      validatephone();
    });

   
    function checkErrors() {
      errors = phoneError
      if (errors) {
        document.querySelector("#btn-register").disabled = true;
      } else {
        
        document.querySelector("#btn-register").disabled = false;
        // document.getElementById("phone").disabled = true;
        // document.getElementById("otpInput").style.display = "block";
        
      }
    }
     
  </script>

</body>

</html>