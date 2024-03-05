<?php
$PageTitle = "Withdraw";
include("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

if(!$_SESSION['nftwallet']) {
  header("location:./login");
  die;
}


$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
  ':username'=>$_SESSION['nftwallet']
]);
$users = $stmt->fetch(PDO::FETCH_ASSOC);


if(isset($_POST['withdraw_wallet'])) {
    $amount = $_POST['amount'];
    $payment_id = $_POST['payment_name'];
    $wallet_address = $_POST['wallet_address'];
    // $username = userSession('username');
    $username = $_SESSION['nftwallet'];
    

   

    if (empty($amount) || empty($payment_id)) {
        toast_alert('error', 'Fill Required Form');
    
    }else{

      

            $checkUser = $conn->query("SELECT * FROM users WHERE username='$username'");
    $resultt = $checkUser->fetch(PDO::FETCH_ASSOC);


  
        if ($users['acct_status'] === 'hold') {
            toast_alert('error', 'Account on Hold Contact Support for more info');
        } elseif ($amount < 0) {
            toast_alert('error', 'Invalid amount entered');
        } elseif($amount > $resultt['balance']){
        toast_alert('error','Insufficient Balance');
        } else {
            
            $available_balance = ($resultt['balance'] - $amount);
//        $amount-=$result['acct_balance'];

            $username = userSession('username');
            $sql = "UPDATE users SET balance=:available_balance WHERE username=:username";
            $addUp = $conn->prepare($sql);
            $addUp->execute([
                'available_balance' => $available_balance,
                'username'=>$username
            ]);
            
            $reference_id = uniqid();
            $trans_type = "Withdrawal";
            $withdraw = "INSERT INTO wallet (amount,username,payment_id,wallet_address,trans_type,refrence_id)VALUES(:amount,:username,:payment_id,:wallet_address,:trans_type,:refrence_id)";
            $stmt = $conn->prepare($withdraw);

            $stmt->execute([
                'amount' => $amount,
                'username' => $username,
                'payment_id' => $payment_id,
                'wallet_address' => $wallet_address,
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
                    toast_alert("success", "Withdrawal Request Sent", "Pending!");

                } else {
                    toast_alert("error", "Sorry Something Went Wrong !");
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
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">Withdraw
                Wallet Funds
            </h1>

            <div class="mx-auto max-w-[48.125rem] md:flex">
                <!-- Form -->
                <div class="mb-12 md:w-1/2 md:pr-8">

                    <?php if (isset($msg1)) echo $msg1; ?>

                    <form method="POST" enctype=multipart/form-data>
                        <div class="mb-6">
                            <label for="profile-username" step="any"
                                class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Amount: <?= $settings['min_deposit'] ?> -
                                <?= $settings['max_deposit'] ?> <?= $paymentnft['short_name'] ?><span class="text-red">*</span></label>
                            <input type="number"
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
                                name="payment_name" data-width='100%'>
                                <option>Select Payment Type</option>
                                <?php

$stmt = $conn->prepare("SELECT * FROM payment ORDER BY payment_name");


$stmt->execute();
while($rs = $stmt->fetch(PDO::FETCH_ASSOC)){

                                   
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
                            <input type="text" placeholder="Wallet Address" name="wallet_address" 
                                class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                             />


                        </div>


                        
                        <button type="submit" name="withdraw_wallet"
                            class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                            Withdraw Funds
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
$PageTitle = "Create NFT";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

if(!$_SESSION['nftwallet']) {
    header("location:./login");
    die;
}

        // Settings Table
        $stmt = $conn->prepare("SELECT * FROM settings");
        $stmt->execute();
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

$viesConn="SELECT * FROM users WHERE username = :username";
$stmt = $conn->prepare($viesConn);

$stmt->execute([
   ':username'=>$_SESSION['nftwallet']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$acct_status = $row['acct_status'];

if(isset($_POST['nftupload'])) {
    $nft_name = $_POST['nft_name'];
    $link = $_POST['link'];
    $description = $_POST['description'];
    $collection = $_POST['collection'];
    $explicit = $_POST['explicit'];
    $minted = $_POST['minted'];
    $amount = $_POST['amount'];
    $payment_id = $_POST['payment_id'];
    $metadata = $_POST['metadata'];
    $fee = $settings['gasfee'];
   
   

    if (empty($nft_name) || empty($amount) || empty($description)) {
        toast_alert('error', 'Fill Required Form');
    } else if(empty($_FILES['image'])){
        toast_alert('error', 'Upload NFT Image');
    }else{
        
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "assets/front/img/products/";
        $n = time() . $name;

        $destination = $folder . $n;

        // Settings Table
        // $stmt = $conn->prepare("SELECT * FROM settings");
        // $stmt->execute();
        // $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        // $fee = $settings['gasfee'];

        
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        if ($acct_status === 'hold') {
            toast_alert('error', 'Account on Hold Contact Support for more info');
        } elseif ($amount < 0) {
            toast_alert('error', 'Invalid amount entered');
        // } elseif ($fee > $row['balance']) {
        //     toast_alert('error', 'Insufficient Balance For Gas Fee','Deposit First!');
        } else {
     
     
     
        // $available_balance = ($row['balance'] - $fee);


        // $sql = "UPDATE users SET balance=:available_balance WHERE username=:username";
        // $addUp = $conn->prepare($sql);
        // $addUp->execute([
        //     'available_balance' => $available_balance,
        //     'username'=>$username
        // ]);
     
 
    
    
       
       if(true){
            $username = userSession('username');
            $nft_status = "hold";
            $asset = "0x49c36afa". uniqid(43);
            $refrence_id = uniqid();

            $uploadnft = "INSERT INTO nfts (asset,nft_name,link,description,collection,explicit,minted,amount,payment_id,metadata,username,nft_status,fee,image,refrence_id)
            
            VALUES(:asset,:nft_name,:link,:description,:collection,:explicit,:minted,:amount,:payment_id,:metadata,:username,:nft_status,:fee,:image,:refrence_id)";
            $stmt = $conn->prepare($uploadnft);

            $stmt->execute([
                'asset' => $asset,
                'nft_name' => $nft_name,
                'link' => $link,
                'description' => $description,
                'collection' => $collection,
                'explicit' => $explicit,
                'minted' => $minted,
                'amount' => $amount,
                'payment_id' => $payment_id,
                'metadata' => $metadata,
                'username' => $username,
                'nft_status' => $nft_status,
                'fee' => $fee,
                'image' => $n,
                'refrence_id' => $refrence_id

            ]);

         
            if (true) {
                $sql = "SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
                INNER JOIN users ON nfts.username=users.username ORDER BY asset DESC LIMIT 1";
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
                    toast_alert("success", "Your NFT upload is pending approval", "Pending!");

                } else {
                    toast_alert("error", "Sorry Something Went Wrong !");
                }
            }
        }
    }
}}}
    


?>

<main>
    <!-- Create -->
    <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">Upload
                NFT's</h1>

            <div class="mx-auto max-w-[48.125rem]">

            <form method="POST" enctype=multipart/form-data>
                <!-- File Upload -->




 <?php
                
                    
                       $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
  ':username'=>$_SESSION['nftwallet']
]);
$users = $stmt->fetch(PDO::FETCH_ASSOC);

if($users['wallkeys'] == ''){

                ?>
                <!-- Submit -->
                <!--<center><a href="#" data-bs-toggle="modal" data-bs-target="#importwallet"-->
                <!--    class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white transition-all">-->
                <!--    Connect Wallet First-->
                <!--</a></center>-->
                
                 <?php
             }else{
                 ?>
                
                
                <!--<div class="mb-6">-->
                <!--    <label class="mb-2 block font-display text-jacarta-700 dark:text-white">JPG, PNG, GIF. Max size: 100-->
                <!--        MB<span class="text-red">*</span></label>-->
                <!--    <p class="mb-3 text-2xs dark:text-jacarta-300">Drag or choose your file to upload</p>-->
                <!--    <input type="file" -->
                <!--        class="group relative flex max-w-md flex-col items-center justify-center rounded-lg border-2 border-dashed border-jacarta-100 bg-white py-20 px-5 text-center dark:border-jacarta-600 dark:bg-jacarta-700"-->
                <!--        placeholder=" JPG, PNG, GIF, SVG, MP4, WEBM. Max size: 100 MB" name="image" required />-->
                <!--        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />-->
                <!--</div>-->

                <!-- Name -->
                <div class="mb-6">
                    <label for="item-name" class="mb-2 block font-display text-jacarta-700 dark:text-white">Item
                        Name<span class="text-red">*</span></label>
                    <input type="text" maxlength="50" minlength="2"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        placeholder="Item name" name="nft_name" required />
                </div>
                
                
                <!-- Amount -->
                <div class="mb-6">
                    <!--<label for="item-supply" class="mb-2 block font-display text-jacarta-700 dark:text-white">Amount:-->
                    <!--     0.00001 Min --->
                    <!--    5 Max <?= $paymentnft['short_name'] ?><span class="text-red">*</span></label>-->


                    <label for="item-supply" class="mb-2 block font-display text-jacarta-700 dark:text-white">Price($)<span class="text-red">*</span></label>

                    <input type="number" name="amount" step="any"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        placeholder="Price" />
                        <!--<p class="text-right">Gas fee: $<?=$settings['gasfee'] ?> <?= $paymentnft['short_name'] ?>-->
                        <!--    </p>-->
                </div>
                

                <!-- External Link --
              <!--  <div class="mb-6">
                    <!--<label for="item-external-link"-->
                    <!--    class="mb-2 block font-display text-jacarta-700 dark:text-white">External link</label>-->
                    <!--<p class="mb-3 text-2xs dark:text-jacarta-300">-->
                <!--        We will include a link to this URL on this item's detail page, so that users can click to learn-->
                <!--        more-->
                <!--        about it. You are welcome to link to your own webpage with more details.-->
                <!--    </p>-->
                <!--    <input type="url" name="link"-->
                <!--        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"-->
                <!--        placeholder="https://yoursite.io/item/123" />-->
                <!--</div>-->

                <!-- Description -->
                
                <!--<div class="mb-6">-->
                <!--    <label for="item-description"-->
                <!--        class="mb-2 block font-display text-jacarta-700 dark:text-white">Description</label>-->
                <!--    <p class="mb-3 text-2xs dark:text-jacarta-300">-->
                <!--        The description will be included on the item's detail page underneath its image. Markdown syntax-->
                <!--        is-->
                <!--        supported.-->
                <!--    </p>-->
                <!--    <textarea  maxlength="1500" name="description"-->
                <!--        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"-->
                <!--        rows="4" required placeholder="Provide a detailed description of your item."></textarea>-->
                <!--</div>-->

        



                <!-- Unlockable Content -->
                <!-- <div class="relative border-b border-jacarta-100 py-6 dark:border-jacarta-600">
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                class="mr-2 mt-px h-4 w-4 shrink-0 fill-accent">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M7 10h13a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V11a1 1 0 0 1 1-1h1V9a7 7 0 0 1 13.262-3.131l-1.789.894A5 5 0 0 0 7 9v1zm-2 2v8h14v-8H5zm5 3h4v2h-4v-2z" />
                            </svg>

                            <div>
                                <label class="block font-display text-jacarta-700 dark:text-white">Unlockable
                                    Content</label>
                                <p class="dark:text-jacarta-300">
                                    Include unlockable content that can only be revealed by the owner of the item.
                                </p>
                            </div>
                        </div>
                        <input type="checkbox" value="checkbox" name="check"
                            class="relative h-6 w-[2.625rem] cursor-pointer appearance-none rounded-full border-none bg-jacarta-100 after:absolute after:top-[0.1875rem] after:left-[0.1875rem] after:h-[1.125rem] after:w-[1.125rem] after:rounded-full after:bg-jacarta-400 after:transition-all checked:bg-accent checked:bg-none checked:after:left-[1.3125rem] checked:after:bg-white checked:hover:bg-accent focus:ring-transparent focus:ring-offset-0 checked:focus:bg-accent" />
                    </div>
                </div> -->

                <!-- Explicit & Sensitive Content -->
                <!--<div class="relative mb-6 border-b border-jacarta-100 py-6 dark:border-jacarta-600">-->
                <!--    <div class="flex items-center justify-between">-->
                <!--        <div class="flex">-->
                <!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"-->
                <!--                class="mr-2 mt-px h-4 w-4 shrink-0 fill-jacarta-700 dark:fill-white">-->
                <!--                <path fill="none" d="M0 0h24v24H0z" />-->
                <!--                <path-->
                <!--                    d="M12.866 3l9.526 16.5a1 1 0 0 1-.866 1.5H2.474a1 1 0 0 1-.866-1.5L11.134 3a1 1 0 0 1 1.732 0zM11 16v2h2v-2h-2zm0-7v5h2V9h-2z" />-->
                <!--            </svg>-->

                <!--            <div>-->
                <!--                <label class="font-display text-jacarta-700 dark:text-white">Explicit & Sensitive-->
                <!--                    Content</label>-->

                <!--                <p class="dark:text-jacarta-300">-->
                <!--                    Set this item as explicit and sensitive content.<span class="inline-block"-->
                <!--                        data-tippy-content="Setting your asset as explicit and sensitive content, like pornography and other not safe for work (NSFW) content, will protect users with safe search while browsing Xhibiter.">-->
                <!--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"-->
                <!--                            height="24"-->
                <!--                            class="ml-2 -mb-[2px] h-4 w-4 fill-jacarta-500 dark:fill-jacarta-300">-->
                <!--                            <path fill="none" d="M0 0h24v24H0z"></path>-->
                <!--                            <path-->
                <!--                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z">-->
                <!--                            </path>-->
                <!--                        </svg>-->
                <!--                    </span>-->
                <!--                </p>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <input type="checkbox" name="explicit" value="1"-->
                <!--            class="relative h-6 w-[2.625rem] cursor-pointer appearance-none rounded-full border-none bg-jacarta-100 after:absolute after:top-[0.1875rem] after:left-[0.1875rem] after:h-[1.125rem] after:w-[1.125rem] after:rounded-full after:bg-jacarta-400 after:transition-all checked:bg-accent checked:bg-none checked:after:left-[1.3125rem] checked:after:bg-white checked:hover:bg-accent focus:ring-transparent focus:ring-offset-0 checked:focus:bg-accent" />-->
                <!--            <input type="hidden" name="explicit" value="0" />-->

                <!--    </div>-->
                <!--</div>-->

                <!-- Supply -->
                <div class="mb-6">
                    <label for="item-supply"
                        class="mb-2 block font-display text-jacarta-700 dark:text-white">Unit supply</label>

                    <div class="mb-3 flex items-center space-x-2">
                        <p class="text-2xs dark:text-jacarta-300">
                            The number of items that can be minted. 20 Max!
                            
                        </p>
                    </div>

                    <input type="number" name="minted"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        placeholder="1-20" min="1" max="20" />
                </div>
                
                <!--desc-->
                        <div class="mb-6">
                    <label for="item-description"
                        class="mb-2 block font-display text-jacarta-700 dark:text-white">Description</label>
                    <!--<p class="mb-3 text-2xs dark:text-jacarta-300">-->
                        <!--The description will be included on the item's detail page underneath its image. Markdown syntax-->
                        <!--is-->
                        <!--supported.-->
                    <!--</p>-->
                    <textarea  maxlength="1500" name="description"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        rows="4" required placeholder="Provide a detailed description of your item."></textarea>
                </div>
                
                    <!-- Collection -->
                <div class="relative">
                    <div>
                        <label class="mb-2 block font-display text-jacarta-700 dark:text-white">Choose collection</label>
                        <div class="mb-3 flex items-center space-x-2">
                            <p class="text-2xs dark:text-jacarta-300">
                                <!--This is the collection where your item will appear.-->
                                <span class="inline-block"
                                    data-tippy-content="Moving items to a different collection may take up to 30 minutes.">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                        class="ml-1 -mb-[3px] h-4 w-4 fill-jacarta-500 dark:fill-jacarta-300">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z">
                                        </path>
                                    </svg>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="dropdown my-1 cursor-pointer">


                        <select
                            class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                            name="collection">
                            <?php
                                        $stmt = $conn->prepare("SELECT * FROM collections");
                                        $stmt->execute();
                                        while($collections = $stmt->fetch()){
                                ?>
                            <option value="<?= $collections['col_id'] ?>"><?= $collections['col_name'] ?></option>


                            <?php
                                        }
                                        ?>
                        </select>


                    </div>
                </div>
                
                   <div class="mb-6">
                    <label class="mb-2 block font-display text-jacarta-700 dark:text-white">JPG, PNG, GIF. Max size: 100
                        MB<span class="text-red">*</span></label>
                    <p class="mb-3 text-2xs dark:text-jacarta-300">Drag or choose your file to upload</p>
                    <input type="file" 
                        class="group relative flex max-w-md flex-col items-center justify-center rounded-lg border-2 border-dashed border-jacarta-100 bg-white py-20 px-5 text-center dark:border-jacarta-600 dark:bg-jacarta-700"
                        placeholder=" JPG, PNG, GIF, SVG, MP4, WEBM. Max size: 100 MB" name="image" required />
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                </div>
                
                

                <!-- Amount -->
                <!--<div class="mb-6">-->
                <!--    <label for="item-supply" class="mb-2 block font-display text-jacarta-700 dark:text-white">Amount:-->
                <!--         0.00001 Min --->
                <!--        5 Max <?= $paymentnft['short_name'] ?><span class="text-red">*</span></label>-->

                <!--    <input type="number" name="amount" step="any"-->
                <!--        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"-->
                <!--        placeholder="Price" />-->
                <!--        <p class="text-right">Gas fee: $<?=$settings['gasfee'] ?> <?= $paymentnft['short_name'] ?>-->
                <!--            </p>-->
                <!--</div>-->

                <!-- Blockchain -->
                <!--<div class="mb-6">-->
                <!--<label for="item-supply"-->
                <!--        class="mb-2 block font-display text-jacarta-700 dark:text-white">Blockchain</label>-->

                <!--    <input type="text" -->
                <!--        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"-->
                <!--        placeholder="<?= $paymentnft['payment_name'] ?>"  disabled/>-->

                <!--        <input type="text" name="payment_id" value="<?= $paymentnft['payment_id'] ?>"-->
                <!--        hidden />-->
                <!--</div>-->

               
                <!-- Freeze metadata --
                <!--<div class="mb-6">-->
                <!--    <div class="flex items-center justify-between">-->
                <!--        <div class="flex">-->
                <!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"-->
                               <!-- class="mr-2 mt-px h-4 w-4 shrink-0 fill-accent">
                                <!--<path fill="none" d="M0 0h24v24H0z" />-->
                                <!--<path-->
                                <!--    d="M7 10h13a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V11a1 1 0 0 1 1-1h1V9a7 7 0 0 1 13.262-3.131l-1.789.894A5 5 0 0 0 7 9v1zm-2 2v8h14v-8H5zm5 3h4v2h-4v-2z" />
                            </svg>

                            <div>
                                <div class="mb-2 flex items-center space-x-2">
                                    <label for="item-freeze-metadata"
                                        class="block font-display text-jacarta-700 dark:text-white">Freeze
                                        metadata</label>
                                    <span class="inline-block"
                                        data-tippy-content="Setting your asset as explicit and sensitive content, like pornography and other not safe for work (NSFW) content, will protect users with safe search while browsing Xhibiter.">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="mb-[2px] h-5 w-5 fill-jacarta-500 dark:fill-jacarta-300">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z">
                                            </path>
                                        </svg>
                                    </span>
                                </div>

                                <p class="dark:text-jacarta-300">
                                    Allow's you to permanently lock and store in
                                    decentralized file storage.
                                </p>
                                <br><br>
                                
                                <input
                type="text" step="any"
                disabled
                class="w-full rounded-lg border-jacarta-100 bg-jacarta-50 py-3 dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                placeholder="You will be charged a <?=$settings['gasfee'] ?> <?= $paymentnft['short_name'] ?> Gas Fee to create your NFT item."
              />
                            </div>
                        </div>
                        <input type="checkbox" name="metadata" value="Frozen"  name="metadata"
                            class="relative h-6 w-[2.625rem] cursor-pointer appearance-none rounded-full border-none bg-jacarta-100 after:absolute after:top-[0.1875rem] after:left-[0.1875rem] after:h-[1.125rem] after:w-[1.125rem] after:rounded-full after:bg-jacarta-400 after:transition-all checked:bg-accent checked:bg-none checked:after:left-[1.3125rem] checked:after:bg-white checked:hover:bg-accent focus:ring-transparent focus:ring-offset-0 checked:focus:bg-accent" />
                            <input type="hidden" name="metadata" value="0" />

                        </div>
                </div>-->
                
                <!-- Submit -->
                <button type="submit" name="nftupload"
                    class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white transition-all" style="background-color: #4e4f54;
    --tw-shadow: 5px 5px 10px #4e4f54,inset 2px 2px 6px #,inset -5px -5px 10px #;">
                    Create NFT
                </button>
                
                <?php
                
                }
                ?>
            </div>
                                    </form>
        </div>
    </section>
    <!-- end create -->

