<?php
$refrence_id = $_GET['id'];
$PageTitle = "TK$refrence_id";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

if(!$_SESSION['nftwallet']) {
    header("location:./login");
    die;
  }


if(empty($refrence_id = $_GET['id'])){
    header("Location:./404");
    exit;
} 



// $stmt = $conn->prepare("SELECT * FROM wallet WHERE refrence_id='$refrence_id'");
$stmt = $conn->prepare("SELECT * FROM wallet WHERE refrence_id='$refrence_id'");

// SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id WHERE username='$id' and status='sold' order by nfts.asset DESC LIMIT 24"


$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$transStatus = transStatus($result);


if(isset($_POST['openticket'])){
    $username = userSession('username');
    $messageid = $_POST['messageid'];
    $payment_name = $_POST['payment_name'];
    $amount = $_POST['amount'];
    $wallet_address = $_POST['wallet_address'];
    $acct_email = $_POST['acct_email'];
    $trans_type = $_POST['trans_type'];

    
    

    if (empty($messageid)) {
        toast_alert('error', 'Fill Required Form');
    }else{

            $ticket_type = "Opened";
            $ticket_id = uniqid();
            $reference_id = uniqid();
            $sql32 = "INSERT INTO ticket (ticket_id,username,messageid,payment_name,amount,wallet_address,acct_email,trans_type,ticket_type,reference_id) VALUES(:ticket_id,:username,:messageid,:payment_name,:amount,:wallet_address,:acct_email,:trans_type,:ticket_type,:reference_id)";
            $stmt = $conn->prepare($sql32);
            $stmt->execute([
                'ticket_id' => $ticket_id,
                'username'=>$username,
                'messageid' => $messageid,
                'payment_name' => $payment_name,
                'amount' => $amount,
                'wallet_address'=>$wallet_address,
                'acct_email' => $acct_email,
                'trans_type' => $trans_type,
                'ticket_type' => $ticket_type,
                'reference_id' => $reference_id
                
            ]);

           
            // // $APP_URL = APP_URL;
            // $APP_NAME = WEB_TITLE;
            // $APP_URL = WEB_URL;
            //  $user_email = $user['acct_email'];

            //  $message = $sendMail->WithdrawMsg($currency, $full_name, $amount, $withdraw_method, $wallet_address, $APP_NAME);


            //  $subject = "Withdrawal Notification". "-". $APP_NAME;
            //  $email_message->send_mail($user_email, $message, $subject);

            //  $subject = "User Withdrawal Notification". "-". $APP_NAME;
            //  $email_message->send_mail(WEB_EMAIL, $message, $subject);

        if (true) {
            toast_alert('success', 'Your Ticket is Sent', 'Awaiting Response');
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
        
            // header("Location:./withdrawal-transaction.php");
            // exit;
        
    }
}

?>

<main class="pt-[5.5rem] lg:pt-24">


    <!-- Contact -->
    <section class="relative py-24 dark:bg-jacarta-800">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <div class="lg:flex">
                <!-- Contact Form -->
                <div class="mb-12 lg:mb-0 lg:w-2/3 lg:pr-12">
                    <h2 class="mb-4 font-display text-xl text-jacarta-700 dark:text-white">Open Ticket ID: TK<?= $result['refrence_id'] ?></h2>
                    <p class="mb-16 text-lg leading-normal dark:text-jacarta-300">
                    Provide a message that best describes your issue. To browse other resources search our Help Center. <a href="help" target="_blank" class="text-red">click here</a>
                    </p>
                    <form method="post">
                        <div class="mb-4">
                            <label for="message"
                                class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Message<span
                                    class="text-red">*</span></label>
                            <textarea name="messageid"
                                class="contact-form-input w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                                required name="message" rows="5"></textarea>

                                <input name="amount" type="text" value="<?= $result['amount'] ?>" hidden />
                                <input name="acct_email" type="text" value="<?= $result['acct_email'] ?>" hidden />
                                <input name="wallet_address" type="text" value="<?= $result['wallet_address'] ?>" hidden />
                                <input name="payment_name" type="text" value="<?= $result['payment_name'] ?>" hidden />
                                <input name="trans_type" type="text" hidden value="<?= $result['trans_type'] ?>"/>
                                
                                <!-- <input name="email" type="text" hidden />
                                <input name="email" type="text" hidden />
                                <input name="email" type="text" hidden />
                                <input name="email" type="text" hidden /> -->
                        </div>

                        <div class="mb-6 flex items-center space-x-2">
                            <input type="checkbox" required 
                                class="h-5 w-5 self-start rounded border-jacarta-200 text-accent checked:bg-accent focus:ring-accent/20 focus:ring-offset-0 dark:border-jacarta-500 dark:bg-jacarta-600" />
                            <label for="contact-form-consent-input" class="text-sm dark:text-jacarta-200">I agree to the
                                <a href="tos" class="text-accent">Terms of Service</a></label>
                        </div>

                        <button type="submit" name="openticket"
                            class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark"
                            >
                            Submit
                        </button>

                        
                    </form>
                </div>

                <!-- Info -->
                <div class="lg:w-1/3 lg:pl-5">
                    <h2 class="mb-4 font-display text-xl text-jacarta-700 dark:text-white">Information</h2>
                    <p class="mb-6 text-lg leading-normal dark:text-jacarta-300">
                      
                       <strong>Amount:</strong> <?= $result['amount'] ?> <?=$paymentnft['short_name'] ?><br>
                       <!-- <strong>Wallet Address:</strong><br> <?= $result['wallet_address'] ?><br> -->
                      <!-- <strong>Email:</strong> <?= $result['acct_email'] ?><br> -->
                       <strong>Transaction type:</strong> <?= $result['trans_type'] ?><br>
                       <strong>Status:</strong> <?= $transStatus ?><br>
                       <strong>Created:</strong> <?= $result['createdAt'] ?><br>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end contact -->

    <?php
  include_once("./layout/footer.php");

  ?>