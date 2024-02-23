<?php
$PageTitle = "Connect";
include_once("./layout/headerlogin.php");
require_once("./include/userClass.php");
require_once("./include/loginFunction.php");




if(isset($_POST['loginuser'])){
    $username = inputValidation($_POST['username']);
    $acct_password = inputValidation($_POST['acct_password']);



    $log = "SELECT * FROM users WHERE username =:username";
    $stmt = $conn->prepare($log);
    $stmt->execute([
        'username'=>$username
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $username = $user['username'];


    if($stmt->rowCount() === 0){
    toast_alert("error","Invalid login details");

    }else{
        $validPassword = password_verify($acct_password, $user['acct_password']);

        if ($validPassword === false){
          
      toast_alert("error","Invalid login details");
        }else{

            if($user['acct_status'] === 'hold'){
                toast_alert("error","Account on Hold, Kindly contact support to activate your account");
            }else {

                        
                        // $full_name = $users['username'];
                        // // $APP_URL = APP_URL;
                        // $APP_NAME = WEB_TITLE;
                        // $APP_URL = WEB_URL;
                        // $user_email = $user['acct_email'];

                        // $message = $sendMail->LoginMsg($full_name, $device, $ipAddress, $nowDate, $APP_NAME, $APP_URL, $BANK_PHONE);

                        // // User Email
                        // $subject = "Login Notification". "-". $APP_NAME;
                        // $email_message->send_mail($user_email, $message, $subject);
                        // // Admin Email
                        // $subject = "User Login Notification". "-". $APP_NAME;
                        // $email_message->send_mail(WEB_EMAIL, $message, $subject);
                    }
                    
                    if (true) {
                        session_start();
                      // $_SESSION['nftwallet'] = $user['username'];
                      $_SESSION['nftwallet']  = $user['username'];
                      $_COOKIE['firstVisit'] = $acct_no;
                      
                      header("Location:./my-profile");
                      exit;
                  }

                  else {
                    toast_alert('error', 'Sorry something went wrong');
                
            } 
                
            }

        }
    }



  if(isset($_POST['createAccount'])){
    $user_id = "0".(substr(number_format(time() * rand(), 0, '', ''), 0, 2));
    $username = $_POST['username'];
    $acct_email = $_POST['acct_email'];
    $acct_password = $_POST['acct_password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    // $secretkey = $_POST['secretkey'];

    if($acct_password !== $confirmPassword){
        toast_alert('error', 'Password not matched');
    
    }else {
        //checking exiting email
        $usersVerified = "SELECT * FROM users WHERE username=:username or acct_email=:acct_email";
        $stmt = $conn->prepare($usersVerified);
        $stmt->execute([
            'username' => $username,
            // 'secretkey' => $secretkey,
            'acct_email' => $acct_email
        ]);

        
        if ($stmt->rowCount() > 0) {
        
            toast_alert('error', 'Email or Phone Number Already Exit');
        } else {
        
                    //INSERT INTO DATABASE
                    $acct_status = "active";
                    $registered = "INSERT INTO users (user_id,username,acct_email,acct_password,acct_status) VALUES(:user_id,:username,:acct_email,:acct_password,:acct_status)";
                    $reg = $conn->prepare($registered);
                    $reg->execute([
                        'user_id' => $user_id,
                        'username' => $username,
                        'acct_email' => $acct_email,
                        'acct_password' => password_hash((string)$acct_password, PASSWORD_BCRYPT),
                        'acct_status' => $acct_status
                        
                        //'secretkey' => $secretkey
                        ]);

                        // $sql2 = "SELECT username FROM users WHERE username ='$username' AND $acct_password = '$acct_password' ";

                        // // $user['user_id'] = $sql2;
                        //  $brukerid = $sql2;
                        
     

                  
                    
                    // $fullName = $firstname . " " . $lastname;
                    // //EMAIL SENDING
                    // $email = $acct_email;
                    // $APP_NAME = $pageTitle;
                    // $APP_URL = WEB_URL;
                    // $message = $sendMail->regMsgUser($fullName,$acct_no,$acct_status,$acct_email,$acct_phone,$acct_type,$acct_pin,$APP_NAME,$APP_URL);
                    // //User Email
                    // $subject = "Welcome - $APP_NAME";
                    // $email_message->send_mail($email, $message, $subject);
                    // // Admin Email
                    // $subject = "User Register - $APP_NAME";
                    // $email_message->send_mail(WEB_EMAIL, $message, $subject);
            

                // if ($registered and $sql2) {
                if (true) {
                    // session_start();
                   // $_SESSION['nftwallet'] = $brukerid && $user['username'];
                    //  $_SESSION['nftwallet'] = $user['username'];
                        // header("Location:./my-profile");
                        // exit;

                        
                      // $_SESSION['nftwallet'] = $user['username'];
                      
                    // session_start();
                    //   //$_SESSION['nftwallet'] = $brukerid;
                    //   $_SESSION['nftwallet'] = $user['username'];
                    //   header("Location:./my-profile");
                      // $_COOKIE['firstVisit'] = $acct_no;

                         toast_alert("success", "Account registered, Login Now!", "Successfully!");


                
                }
                else {
                    toast_alert('error', 'Sorry something went wrong');
                
            }
        }
    }
                
    

  }


?>

<main>
    <!-- Login -->
    <section class="relative h-screen">
        <div class="lg:flex lg:h-full">
            <!-- Left -->
            <div class="relative text-center lg:w-1/2">
                 <a href="/">
                <img src="assets/front/img/login.jpg" alt="login"
                    class="absolute h-full w-full object-cover" />
                    </a>
                <!-- Logo -->
                <!--<a href="/" class="relative inline-block py-36">-->
                <!--    <img src="./assets/front/img/<?= $settings['image'] ?>" class="inline-block max-h-7"-->
                <!--        alt="Xhibiter | NFT Marketplace" />-->
                <!--</a>-->
            </div>

            <!-- Right -->
            <div class="relative flex items-center justify-center p-[10%] lg:w-1/2">
                <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
                    <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
                </picture>

                <div class="w-full max-w-[25.625rem] text-center">
                    <h1 class="text-jacarta-700 font-display mb-6 text-4xl dark:text-white">Reset Password</h1>
                    <p class="dark:text-jacarta-300 mb-10 text-lg leading-normal">
                        Make a Strong Password.
                        <!--<a href="blog" target="_blank" class="text-accent">More</a>-->
                    </p>

                 

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Ethereum -->
                        <div class="tab-pane fade show active" role="tabpanel"
                            aria-labelledby="ethereum-tab">
                        
                    

        <form action="">             
            <div class="mb-6">
                <input type="password" class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300" name="new_password" required placeholder="New Password" autocomplete="off">
            </div>

            
            <div class="mb-6">
                <input type="password" class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300" name="confirm_password" required placeholder="Confirm Password" autocomplete="off">
            </div>
            <button type="submit" class="bg-accent shadow-accent-volume hover:bg-accent-dark rounded-full py-3 px-8 text-center font-semibold text-white transition-all" name="update" style="background-color: #4e4f54;
    --tw-shadow: 5px 5px 10px # ,inset 2px 2px 6px # ,inset -5px -5px 10px #4e4f54;">Update</button>
        </form>
                            
                        </div>
                        <!-- end ethereum -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end login -->

    <?php
  include_once("./layout/footerlogin.php");

  ?>
