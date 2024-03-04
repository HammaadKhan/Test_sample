<?php
$PageTitle = "Wallet";
include("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");
 //require($_SERVER['DOCUMENT_ROOT']. "/include/function.php");

if(!$_SESSION['nftwallet']) {
  header("location:./login");
  die;
}


$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
  'username'=>$_SESSION['nftwallet']
]);
$users = $stmt->fetch(PDO::FETCH_ASSOC);


if(isset($_POST['deposit_wallet'])) {
    $amount = $_POST['amount'];
    $payment_id = $_POST['payment_name'];
    $wallet_address = $_POST['wallet_address'];
    $username = userSession('username');
    // $username = $_SESSION['nftwallet'];
    

   

    if (empty($amount) || empty($payment_id)) {
        toast_alert('error', 'Fill Required Form');
    } else if(empty($_FILES['image'])){
        toast_alert('error', 'Upload Payment Screenshot');
    }else{

      

    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "assets/front/img/uploads/";
        $n = time() . $name;

        $destination = $folder . $n;

        // Settings Table
        $stmt = $conn->prepare("SELECT * FROM settings");
        $stmt->execute();
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        $trans_limit_min = $settings['min_deposit'];
        $trans_limit_max = $settings['max_deposit'];

        
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        if ($users['acct_status'] === 'hold') {
            toast_alert('error', 'Account on Hold Contact Support for more info');
        } elseif ($amount < 0) {
            toast_alert('error', 'Invalid amount entered');
        } elseif ($amount < $trans_limit_min) {
            toast_alert('error', 'Amount Less than Deposit Limit');
        } elseif ($amount > $trans_limit_max) {
            toast_alert('error', 'Amount greater than than Deposit Limit');
        } else {
            
            $reference_id = uniqid();
            $trans_type = "Funding";
            $deposited = "INSERT INTO wallet (amount,username,payment_id,image,trans_type,refrence_id)VALUES(:amount,:username,:payment_id,:image,:trans_type,:refrence_id)";
            $stmt = $conn->prepare($deposited);

            $stmt->execute([
                'amount' => $amount,
                'username' => $username,
                'payment_id' => $payment_id,
                'image' => $n,
                'trans_type' => $trans_type,
                'refrence_id' => $reference_id

            ]);

         
            if (true) {
                $sql = "SELECT d.*, c.payment_name FROM wallet d INNER JOIN payment c ON d.payment_id = c.id WHERE d.username =:username ORDER BY d.id DESC LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'username' => $username
                ]);

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                // $refrence_id = $result['refrence_id'];
                // $payment_name = $result['payment_name'];


                // $APP_NAME = $pageTitle;
                // $message = $sendMail->depositMsg($currency, $amount, $crypto_name, $fullName, $trans_id, $APP_NAME);
                // $subject = "My Wallet Topup - $APP_NAME";
                // $email_message->send_mail($email, $message, $subject);

                // $subject = "Pending Wallet Deposit - $APP_NAME";
                // $email_message->send_mail(WEB_EMAIL, $message, $subject);
                


                if (true) {

                    // $msg1 = "
                    // <div class='alert alert-warning'>
                    
                    // <script type='text/javascript'>
                         
                    //         function Redirect() {
                    //         window.location='./wallet';
                    //         }
                    //         document.write ('');
                    //         setTimeout('Redirect()', 3000);
                         
                    //         </script>
                            
                    // <center><img src='../assets/images/loading.gif' width='180px'  /></center>
                    
                    
                    // <center>	<strong style='color:black;'>Please Wait while we validate Deposit request...
                    //        </strong></center>
                    //   </div>
                    // ";
                    toast_alert("success", "Deposit Request Sent", "Pending!");

                } else {
                    toast_alert("error", "Sorry Something Went Wrong !");
                }
            }
        }
    }


    }
}

?>

<main>
    <!-- Rankings -->
    <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">Fund My
                Wallet
            </h1>

            <div class="mx-auto max-w-[48.125rem] md:flex">
                <!-- Form -->
                <div class="mb-12 md:w-1/2 md:pr-8">

                    <?php if (isset($msg1)) echo $msg1; ?>

                    <form method="POST" enctype=multipart/form-data>
                        <div class="mb-6">
                            <label for="profile-username"
                                class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Min Amount: <?= $settings['min_deposit'] ?> -
                                <?= $settings['max_deposit'] ?> <?= $paymentnft['short_name'] ?> <span class="text-red">*</span></label>
                            <input type="number" step="any"
                                class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                                placeholder="Enter Amount" name="amount" required />
                            <p class="text-right"><strong>Balance: <?=$users['balance'] ?> <?= $paymentnft['short_name'] ?></strong>
                            </p>
                        </div>


                        <div class="mb-6">
                            <label for="profile-username"
                                class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Select Payment
                                Type<span class="text-red">*</span></label>

                            <select required
                                class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                                name="payment_name" id="crypto-wallet" data-width='100%'>
                                <option>Select Payment Type</option>
                                <?php

$stmt = $conn->prepare("SELECT * FROM payment ORDER BY payment_name");


$stmt->execute();
while($rs = $stmt->fetch(PDO::FETCH_ASSOC)){
    $data[] = array(
                                                                        'payment_id'=>$rs['payment_id'],
                                                                        'wallet_address'=>$rs['wallet_address']
                                                                );

                                   
                                ?>
                                <option value="<?= $rs['payment_id'] ?>"> <?= ucwords($rs['payment_name']) ?>
                                </option>

                                <?php
                                        }
                              ?>


                            </select>
                        </div>
                        <div class="mb-6">
                            <label for="profile-username"
                                class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Wallet
                                Address<span class="text-red">*</span></label>
                                
                                
                            <input type="text" placeholder="Select Payment First" name="wallet_address" id="wallet_address"
                                class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                                readonly />


                        </div>


                        <div class="mb-6">
                            <label for="profile-payment"
                                class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Payment
                                Proof<span class="text-red">*</span></label>
                            <input type="file" placeholder="Payment Screenshot" required name="image"
                                class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300" />
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />


                        </div>
                        
                        <button type="submit" name="deposit_wallet"
                            class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                            Make Deposit
                        </button>
                    </form>
                </div>

                <!-- Avatar -->
                <div class="mb-12 md:w-1/2 md:pr-8">
                    <div class="mt-4">

                        <script type="text/javascript"
                            src="https://files.coinmarketcap.com/static/widget/coinPriceBlock.js"></script>
                        <div id="coinmarketcap-widget-coin-price-block" coins="1,1027,825" currency="USD" theme="light"
                            transparent="false" show-symbol-logo="true" data-width="100%"></div>
                    </div>
                </div>
            </div>






        </div>
    </section>
    <!-- end rankings -->






    <?php
  include("./layout/footer.php");

  ?>