<?php
$PageTitle = "Edit NFT";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

$asset = $_GET['id'];

if(!$_SESSION['nftwallet']) {
    header("location:./login");
    die;
}

// NFT Items
$stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
INNER JOIN users ON nfts.username=users.username
WHERE asset='$asset'");
$stmt->execute();
$nfts = $stmt->fetch(PDO::FETCH_ASSOC);


$viesConn="SELECT * FROM users WHERE username = :username";
$stmt = $conn->prepare($viesConn);

$stmt->execute([
    'username'=>$_SESSION['nftwallet']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

 
$username = $row['username'];
$acct_status = $row['acct_status'];

if(isset($_POST['updatenft'])) {
    $nft_name = $_POST['nft_name'];
    $link = $_POST['link'];
    $tagline = $_POST['tagline'];
    $description = $_POST['description'];
    $explicit = $_POST['explicit'];
    $minted = $_POST['minted'];
    $amount = $_POST['amount'];
    $payment_id = $_POST['payment_id'];
    // $metadata = $_POST['metadata'];
    $refrence_id = uniqid();
   // $tagline = $_POST['tagline'];
   

// asset
// nft_name
// link
// tagline
// description
// collection
// explicit
// minted
// amount
// payment_id
// metadata
// username
// status = Hold
// fee
    

   // Settings Table
        $stmt = $conn->prepare("SELECT * FROM settings");
        $stmt->execute();
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        $fee = $settings['gasfee'];

    $checkUser = $conn->query("SELECT * FROM users WHERE username='$username'");
    $resultt = $checkUser->fetch(PDO::FETCH_ASSOC);

    if($fee > $resultt['balance']){
        toast_alert('error','Insufficient Balance');
    }else {

        


        $available_balance = ($resultt['balance'] - $fee);
//        $amount-=$result['acct_balance'];

            $username = userSession('username');
            $sql = "UPDATE users SET balance=:available_balance WHERE username=:username";
            $addUp = $conn->prepare($sql);
            $addUp->execute([
                'available_balance' => $available_balance,
                'username'=>$username
            ]);

      

    
        if ($acct_status === 'hold') {
            toast_alert('error', 'Account on Hold Contact Support for more info');
        } elseif ($amount < 0) {
            toast_alert('error', 'Invalid amount entered');
        } else {
            
           
            $nft_status = "sale";
            $username = userSession('username');
            $asset = $_GET['id'];
            
            
            $uploadnft = "UPDATE nfts SET nft_name=:nft_name,link=:link,tagline=:tagline,description=:description,explicit=:explicit,minted=:minted,amount=:amount,nft_status=:nft_status WHERE nfts.asset=:asset";
            $stmt = $conn->prepare($uploadnft);

            $stmt->execute([
                'nft_name' => $nft_name,
                'link' => $link,
                'tagline' => $tagline,
                'description' => $description,
                'explicit' => $explicit,
                'minted' => $minted,
                'amount' => $amount,
                'nft_status' => $nft_status,
                'asset' => $asset

            ]);

            $refrence_id = uniqid();
            $trans_type = "Nft Listing";
            $deposited = "INSERT INTO wallet (amount,username,trans_type,refrence_id)VALUES(:amount,:username,:trans_type,:refrence_id)";
            $stmt = $conn->prepare($deposited);

            $stmt->execute([
                'amount' => $amount,
                'username' => $username,
                'trans_type' => $trans_type,
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

                    $msg1 = "
                    <div class='alert alert-warning'>
                    
                    <script type='text/javascript'>
                         
                            function Redirect() {
                            window.location='./transactions';
                            }
                            document.write ('');
                            setTimeout('Redirect()', 3000);
                         
                            </script>
                            
                    <center><img src='../assets/images/loading.gif' width='180px'  /></center>
                    
                    
                    <center>	<strong style='color:black;'>NFT updated, please wait while we redirect...
                           </strong></center>
                      </div>
                    ";
                    // toast_alert("success", "Your NFT Update is pending admin approval", "Pending!");

                } else {
                    toast_alert("error", "Sorry Something Went Wrong !");
                }
            }
        }
    }


}

?>

<main>
    <!-- Create -->
    <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">Edit/Updated
                NFT</h1>

            <div class="mx-auto max-w-[48.125rem]">
            <?php if (isset($msg1)) echo $msg1; ?>

            <form method="POST" enctype=multipart/form-data>
                <!-- File Upload -->



                <!--<div class="mb-6">-->
                <!--    <label class="mb-2 block font-display text-jacarta-700 dark:text-white">JPG, PNG, GIF. Max size: 100-->
                <!--        MB<span class="text-red">*</span></label>-->
                <!--    <p class="mb-3 text-2xs dark:text-jacarta-300">Drag or choose your file to upload</p>-->
                <!--    <input type="file"  value="<?= $nfts['image'] ?>"-->
                <!--        class="group relative flex max-w-md flex-col items-center justify-center rounded-lg border-2 border-dashed border-jacarta-100 bg-white py-20 px-5 text-center dark:border-jacarta-600 dark:bg-jacarta-700"-->
                <!--        placeholder=" JPG, PNG, GIF, SVG, MP4, WEBM. Max size: 100 MB" name="image"  />-->
                <!--        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />-->
                <!--</div>-->

                <!-- Name -->
                <div class="mb-6">
                    <label for="item-name" class="mb-2 block font-display text-jacarta-700 dark:text-white">Item
                        Name<span class="text-red">*</span></label>
                    <input type="text" value="<?= $nfts['nft_name'] ?>"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        placeholder="Item name" name="nft_name"  />
                        
                        
                        <input type="file"  value="<?= $nfts['image'] ?>"
                        hidden name="image"  />
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                        
                </div>

                <!-- External Link -->
                <div class="mb-6">
                    <label for="item-external-link"
                        class="mb-2 block font-display text-jacarta-700 dark:text-white">External link</label>
                    <p class="mb-3 text-2xs dark:text-jacarta-300">
                        We will include a link to this URL on this item's detail page, so that users can click to learn
                        more
                        about it. You are welcome to link to your own webpage with more details.
                    </p>
                    <input type="url" name="link" value="<?= $nfts['link'] ?>"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        placeholder="https://yoursite.io/item/123" />
                </div>

                <!-- Description -->
                <!--<div class="mb-6">-->
                <!--    <label for="item-tagline"-->
                <!--        class="mb-2 block font-display text-jacarta-700 dark:text-white">Tagline</label>-->
                <!--    <p class="mb-3 text-2xs dark:text-jacarta-300">-->
                <!--        The tagline will be included on the item's page. Markdown syntax-->
                <!--        is-->
                <!--        supported.-->
                <!--    </p>-->
                <!--    <textarea  maxlength="100" minlength="10" name="tagline" value="<?= $nfts['tagline'] ?>"-->
                <!--        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"-->
                <!--        rows="2"  placeholder="<?= $nfts['tagline'] ?>"></textarea>-->
                <!--</div>-->
                <div class="mb-6">
                    <label for="item-description"
                        class="mb-2 block font-display text-jacarta-700 dark:text-white">Description</label>
                    <p class="mb-3 text-2xs dark:text-jacarta-300">
                        The description will be included on the item's detail page underneath its image. Markdown syntax
                        is
                        supported.
                    </p>
                    <textarea  maxlength="1500" minlength="2" name="description" value="<?= $nfts['description'] ?>"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        rows="4"  placeholder="<?= $nfts['description'] ?>"></textarea>
                </div>

              

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
                <div class="relative mb-6 border-b border-jacarta-100 py-6 dark:border-jacarta-600">
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                class="mr-2 mt-px h-4 w-4 shrink-0 fill-jacarta-700 dark:fill-white">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M12.866 3l9.526 16.5a1 1 0 0 1-.866 1.5H2.474a1 1 0 0 1-.866-1.5L11.134 3a1 1 0 0 1 1.732 0zM11 16v2h2v-2h-2zm0-7v5h2V9h-2z" />
                            </svg>

                            <div>
                                <label class="font-display text-jacarta-700 dark:text-white">Explicit & Sensitive
                                    Content</label>

                                <p class="dark:text-jacarta-300">
                                    Set this item as explicit and sensitive content.<span class="inline-block"
                                        data-tippy-content="Setting your asset as explicit and sensitive content, like pornography and other not safe for work (NSFW) content, will protect users with safe search while browsing Xhibiter.">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24"
                                            class="ml-2 -mb-[2px] h-4 w-4 fill-jacarta-500 dark:fill-jacarta-300">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z">
                                            </path>
                                        </svg>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <input type="checkbox" name="explicit" value="1" 
                            class="relative h-6 w-[2.625rem] cursor-pointer appearance-none rounded-full border-none bg-jacarta-100 after:absolute after:top-[0.1875rem] after:left-[0.1875rem] after:h-[1.125rem] after:w-[1.125rem] after:rounded-full after:bg-jacarta-400 after:transition-all checked:bg-accent checked:bg-none checked:after:left-[1.3125rem] checked:after:bg-white checked:hover:bg-accent focus:ring-transparent focus:ring-offset-0 checked:focus:bg-accent" />
                            <input type="hidden" name="explicit" value="<?= $nfts['explicit'] ?>" />

                    </div>
                </div>

                <!-- Supply -->
                <div class="mb-6">
                    <label for="item-supply"
                        class="mb-2 block font-display text-jacarta-700 dark:text-white">Supply</label>

                    <div class="mb-3 flex items-center space-x-2">
                        <p class="text-2xs dark:text-jacarta-300">
                            The number of items that can be minted. 20 Max!
                            
                        </p>
                    </div>

                    <input type="number" name="minted"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        placeholder="1" max="20"  value="<?= $nfts['minted'] ?>" />
                </div>

                <!-- Amount -->
                <div class="mb-6">
                    <label for="item-supply"  class="mb-2 block font-display text-jacarta-700 dark:text-white">Amount:
                        <?= $settings['currency'] ?>1 -
                        9,999,999<span class="text-red">*</span></label>

                    <input type="number" name="amount" required step="any"
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        placeholder="Price"  value="<?= $nfts['amount'] ?>"/>
                        <p class="text-right">Gas fee: <?=$settings['gasfee'] ?> <?=$paymentnft['short_name'] ?>
                            </p>
                </div>

                <!-- Blockchain -->
                <div class="mb-6">
                <label for="item-supply"
                        class="mb-2 block font-display text-jacarta-700 dark:text-white">Blockchain</label>

                    <input type="text" 
                        class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                        placeholder="<?= $paymentnft['payment_name'] ?>"  disabled/>

                        <input type="text" name="payment_id" value="<?= $nfts['payment_id'] ?>" value="<?= $paymentnft['payment_id'] ?>"
                        hidden />
                        
                        <p class="dark:text-jacarta-300">
                                    You will be charged a gass fee of <strong><?=$settings['gasfee'] ?> <?=$paymentnft['short_name'] ?></strong> to list/update nft.
                              </p>
                        
                        
                    


                </div>

               
                <!-- Freeze metadata -->
                <!--<div class="mb-6">-->
                <!--    <div class="flex items-center justify-between">-->
                <!--        <div class="flex">-->
                <!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"-->
                <!--                class="mr-2 mt-px h-4 w-4 shrink-0 fill-accent">-->
                <!--                <path fill="none" d="M0 0h24v24H0z" />-->
                <!--                <path-->
                <!--                    d="M7 10h13a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V11a1 1 0 0 1 1-1h1V9a7 7 0 0 1 13.262-3.131l-1.789.894A5 5 0 0 0 7 9v1zm-2 2v8h14v-8H5zm5 3h4v2h-4v-2z" />-->
                <!--            </svg>-->

                <!--            <div>-->
                <!--                <div class="mb-2 flex items-center space-x-2">-->
                <!--                    <label for="item-freeze-metadata"-->
                <!--                        class="block font-display text-jacarta-700 dark:text-white">Freeze-->
                <!--                        metadata</label>-->
                <!--                    <span class="inline-block"-->
                <!--                        data-tippy-content="Setting your asset as explicit and sensitive content, like pornography and other not safe for work (NSFW) content, will protect users with safe search while browsing Xhibiter.">-->
                <!--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"-->
                <!--                            height="24" class="mb-[2px] h-5 w-5 fill-jacarta-500 dark:fill-jacarta-300">-->
                <!--                            <path fill="none" d="M0 0h24v24H0z"></path>-->
                <!--                            <path-->
                <!--                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z">-->
                <!--                            </path>-->
                <!--                        </svg>-->
                <!--                    </span>-->
                <!--                </div>-->

                <!--                <p class="dark:text-jacarta-300">-->
                <!--                    Allow's you to permanently lock and store in-->
                <!--                    decentralized file storage.-->
                <!--                </p>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <input type="checkbox" name="metadata" value="Frozen"  name="metadata"-->
                <!--            class="relative h-6 w-[2.625rem] cursor-pointer appearance-none rounded-full border-none bg-jacarta-100 after:absolute after:top-[0.1875rem] after:left-[0.1875rem] after:h-[1.125rem] after:w-[1.125rem] after:rounded-full after:bg-jacarta-400 after:transition-all checked:bg-accent checked:bg-none checked:after:left-[1.3125rem] checked:after:bg-white checked:hover:bg-accent focus:ring-transparent focus:ring-offset-0 checked:focus:bg-accent" />-->
                <!--            <input type="hidden" name="metadata" value="<?= $nfts['metadata'] ?>" />-->

                <!--        </div>-->
                <!--</div>-->

                <!-- Submit -->
                <button type="submit" name="updatenft"
                    class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white transition-all">
                    List NFT Now
                </button>
            </div>
                                    </form>
        </div>
    </section>
    <!-- end create -->

    <?php
  include_once("./layout/footer.php");

  ?>