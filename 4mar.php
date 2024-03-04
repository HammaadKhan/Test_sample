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



<?php
$PageTitle = "Collections";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

//$collections = $_GET['id'];



?>

<main>
    <!-- Collections -->
    <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">
                Explore Collections
            </h1>

            <!-- Filters -->
            <div class="mb-8 flex flex-wrap items-center justify-between">
                <ul class="flex flex-wrap items-center">
                    <li class="my-1 mr-2.5">
                        <a href="collections"
                            class="group flex h-9 items-center justify-center rounded-lg bg-jacarta-100 px-4 font-display text-sm font-semibold text-jacarta-700 transition-colors hover:border-transparent hover:bg-accent hover:text-white dark:bg-jacarta-700 dark:text-white dark:hover:bg-accent">All</a>
                    </li>

                    <?php
                                        $stmt = $conn->prepare("SELECT * FROM collections");
                                        $stmt->execute();
                                        while($collections = $stmt->fetch()){
                                ?>

                    <li class="my-1 mr-2.5">
                        <a href="collections?id=<?=$collections['col_id'] ?>"
                            class="group flex h-9 items-center rounded-lg border border-jacarta-100 bg-white px-4 font-display text-sm font-semibold text-jacarta-500 transition-colors hover:border-transparent hover:bg-accent hover:text-white dark:border-jacarta-600 dark:bg-jacarta-900 dark:text-white dark:hover:border-transparent dark:hover:bg-accent dark:hover:text-white">
                            <?= $collections['svg'] ?>
                            <span><?= $collections['col_name'] ?></span>
                        </a>
                    </li>

                    <?php
                                        }
                    ?>
                   
                </ul>


            </div>

           
            <!-- Grid -->
            <div class="grid grid-cols-1 gap-[1.875rem] md:grid-cols-3 lg:grid-cols-4">
            <?php
            if(isset($_GET['id'])){

                $collections = $_GET['id'];
            

            ?>


                <?php
         

                // $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN users ON nfts.username=users.username WHERE collection='$collections'  LIMIT 16");
                
                 // $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
                //            INNER JOIN users ON nfts.username=users.username WHERE collection='$collections' and nft_status='active' or nft_status='sale' LIMIT 12 ");
                $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN users ON nfts.username=users.username WHERE collection='$collections' and nft_status='active' or nft_status='sale' LIMIT 12 ");
                
                           $stmt->execute();
                while($collection = $stmt->fetch()){
                                            
            ?>
                <article>
                    <div
                        class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                        <figure class="relative">
                            <a href="asset?id=<?= $collection['asset'] ?>">
                                <img src="./assets/front/img/products/<?= $collection['image'] ?>" width="150px" height="100px"
                                    alt="<?= $collection['nft_name'] ?>" class="w-full rounded-[0.625rem]" loading="lazy" />
                            </a>
                            <!- <div
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
                            </div> ->
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
                            <span class="mr-1 text-jacarta-700 dark:text-jacarta-200">From <?=$collection['short_name']?><?= $collection['amount']?>
                            </span>
                            <span class="text-jacarta-500 dark:text-jacarta-300"><?=$collection['minted'] ?>/<?=$collection['level'] ?></span>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-sm font-medium tracking-tight">
                            <div class="flex flex-wrap items-center">
                                <a href="user?id=<?= $collection['username'] ?>" class="mr-2 shrink-0">
                                    <img src="./assets/front/img/uploads/<?= $collection['avatar'] ?>" alt="owner"
                                        class="h-5 w-5 rounded-full" />
                                </a>
                                <span class="mr-1 dark:text-jacarta-400">by</span>
                                <a href="user?id=<?= $collection['username'] ?>" class="text-accent">
                                    <span><?= $collection['username'] ?></span>
                                </a>
                            </div>
                            <!--<span class="text-sm dark:text-jacarta-300"><?= $collection['nft_status'] ?></span>-->
                        </div>
                    </div>
                </article>
                <?php

            }

            ?>


          

            <?php

            }else{

                // $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN users ON nfts.username=users.username LIMIT 16");

                // $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
                // INNER JOIN users ON nfts.username=users.username WHERE nft_status='active' or nft_status='sale' LIMIT 16");
                $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN users ON nfts.username=users.username WHERE nft_status='active' or nft_status='sale' LIMIT 16");
                

                $stmt->execute();
                while($collection = $stmt->fetch()){
                    

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
                            <span class="mr-1 text-jacarta-700 dark:text-jacarta-200">From <?=$collection['short_name']?><?= $collection['amount']?>
                            </span>
                            <span class="text-jacarta-500 dark:text-jacarta-300"><?=$collection['minted'] ?>/<?=$collection['level'] ?></span>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-sm font-medium tracking-tight">
                            <div class="flex flex-wrap items-center">
                                <a href="user?id=<?= $collection['username'] ?>" class="mr-2 shrink-0">
                                    <img src="./assets/front/img/uploads/<?= $collection['avatar'] ?>" alt="owner"
                                        class="h-5 w-5 rounded-full" />
                                </a>
                                <span class="mr-1 dark:text-jacarta-400">Creator:</span>
                                <a href="user?id=<?= $collection['username'] ?>" class="text-accent">
                                    <span><?= $collection['username'] ?></span>
                                </a>
                            </div>
                            <!--<span class="text-sm dark:text-jacarta-300"><?= $collection['nft_status'] ?></span>-->
                        </div>
                    </div>
                </article>

           


                <?php

                }
            

            ?>

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