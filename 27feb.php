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


<section class="relative h-screen">
        <div class="lg:flex lg:h-full">
            <!-- Left -->
            <div class="relative text-center lg:w-1/2">
                <a href="/">
                    <img src="assets/front/img/login.jpg" alt="login" class="absolute h-full w-full object-cover" />
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
                    <h1 class="text-jacarta-700 font-display mb-6 text-4xl dark:text-white">Login or Register</h1>
                    <p class="dark:text-jacarta-300 mb-10 text-lg leading-normal">
                        Login with your existing account or create a new account.
                        <!--<a href="blog" target="_blank" class="text-accent">More</a>-->
                    </p>



                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Ethereum -->
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="ethereum-tab">
                            <button class="js-wallet bg-accent hover:bg-accent-dark mb-4 flex w-full items-center justify-center rounded-full border-2 border-transparent py-4 px-8 text-center font-semibold text-white transition-all" data-bs-toggle="modal" data-bs-target="#walletConnect" style="background-color: #4e4f54;
    --tw-shadow: 5px 5px 10px #000000,inset 2px 2px 6px #000000,inset -5px -5px 10px #4e4f54;">
                                <img src="https://deothemes.com/envato/xhibiter/html/img/wallets/wallet_connect_24.svg" class="mr-2.5 inline-block h-6 w-6" alt="" />
                                <span>Login Username/Password</span>
                            </button>

                            <button class="dark:bg-jacarta-700 dark:border-jacarta-600 border-jacarta-100 dark:hover:bg-accent hover:bg-accent text-jacarta-700 mb-4 flex w-full items-center justify-center rounded-full border-2 bg-white py-4 px-8 text-center font-semibold transition-all hover:border-transparent hover:text-white dark:text-white dark:hover:border-transparent" data-bs-toggle="modal" data-bs-target="#walletCreate">
                                <img src="https://deothemes.com/envato/xhibiter/html/img/wallets/wallet_connect_24.svg" class="mr-2.5 inline-block h-6 w-6" alt="" />
                                <span>Create New Account</span>
                            </button>


                        </div>
                        <!-- end ethereum -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end login -->


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