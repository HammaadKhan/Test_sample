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








<?php
$search = $_GET['id'];  
$PageTitle = "$search";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");





?>

<main>
    <!-- Collections -->
    <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">
                Search Result's For "<?= $search ?>"
            </h1>

         

            <!-- Grid -->
            <div class="grid grid-cols-1 gap-[1.875rem] md:grid-cols-3 lg:grid-cols-4">
          <?php
          
                $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
                INNER JOIN users ON nfts.username=users.username WHERE nft_name LIKE '%$search%'ORDER BY 'nft_name' or nft_status='active' or nft_status='sale' LIMIT 16");
                $stmt->execute();
                while($collection = $stmt->fetch()){

                    // WHERE `title` LIKE '%$keyword%' ORDER BY `title`"
                                            
            ?>
                <article>
                    <div
                        class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                        <figure class="relative">
                            <a href="asset?id=<?= $collection['asset'] ?>">
                                <img src="./assets/front/img/products/<?= $collection['image'] ?>" width="150px" height="100px"
                                    alt="<?= $collection['nft_name'] ?>" class="w-full rounded-[0.625rem]" loading="lazy" />
                            </a>
                            <!-- <div
                                class="absolute top-3 right-3 flex items-center space-x-1 rounded-md bg-white p-2 dark:bg-jacarta-700">
                                <span
                                    class="js-likes relative cursor-pointer before:absolute before:h-4 before:w-4 before:bg-[url('../img/heart-fill.svg')] before:bg-cover before:bg-center before:bg-no-repeat before:opacity-0"
                                    data-tippy-content="Favorite">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                        class="h-4 w-4 fill-jacarta-500 hover:fill-red dark:fill-jacarta-200 dark:hover:fill-red">
                                        <path fill="none" d="M0 0H24V24H0z" />
                                        <path
                                            d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z" />
                                    </svg>
                                </span>
                                <span class="text-sm dark:text-jacarta-200">15</span>
                            </div> -->
                        </figure>
                        <div class="mt-7 flex items-center justify-between">
                            <a href="asset?id=<?= $collection['asset'] ?>">
                                <span
                                    class="font-display text-base text-jacarta-700 hover:text-accent dark:text-white"><?= $collection['nft_name'] ?></span>
                            </a>
                            <div class="dropup rounded-full hover:bg-jacarta-100 dark:hover:bg-jacarta-600">
                                <a href="#"
                                    class="dropdown-toggle inline-flex h-8 w-8 items-center justify-center text-sm"
                                    role="button" id="itemActions" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg width="16" height="4" viewBox="0 0 16 4" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="fill-jacarta-500 dark:fill-jacarta-200">
                                        <circle cx="2" cy="2" r="2" />
                                        <circle cx="8" cy="2" r="2" />
                                        <circle cx="14" cy="2" r="2" />
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end z-10 hidden min-w-[200px] whitespace-nowrap rounded-xl bg-white py-4 px-2 text-left shadow-xl dark:bg-jacarta-800"
                                    aria-labelledby="itemActions">
                                    <button
                                        class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                        Share
                                    </button>
                                    <button
                                        class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                        Report
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-sm">
                            <span class="mr-1 text-jacarta-700 dark:text-jacarta-200">From <?= $collection['amount']?>
                                <?=$collection['short_name'] ?></span>
                            <span
                                class="text-jacarta-500 dark:text-jacarta-300"><?=$collection['minted'] ?>/<?=$collection['level'] ?></span>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-sm font-medium tracking-tight">
                            <div class="flex flex-wrap items-center">
                                <a href="user?id=<?= $collection['username'] ?>" class="mr-2 shrink-0">
                                    <img src="./assets/front/img/uploads/<?= $collection['user_cover'] ?>" alt="owner"
                                        class="h-5 w-5 rounded-full" />
                                </a>
                                <span class="mr-1 dark:text-jacarta-400">by</span>
                                <a href="user?id=<?= $collection['username'] ?>" class="text-accent">
                                    <span><?= $collection['username'] ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                <?php

            }

            ?>




            </div>

        </div>


        </div>
    </section>
    <!-- end collections -->


    <?php
  include_once("./layout/footer.php");

  ?>