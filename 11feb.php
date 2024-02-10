<?php
$PageTitle = "View";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

$asset = $_GET['id'];

if(empty($asset = $_GET['id'])){
    header("Location:./404");
    exit;
} 



    





// NFT Items
$stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
INNER JOIN users ON nfts.username=users.username
WHERE asset='$asset'");
$stmt->execute();
$nfts = $stmt->fetch(PDO::FETCH_ASSOC);



$Totalamount = $nfts['fee'] + $nfts['amount'];



if(isset($_POST['checkoutnft'])){
    $username = userSession('username');
    $amount = $_POST['amount'];

    

    
    $checkUser = $conn->query("SELECT * FROM users WHERE username='$username'");
    $resultt = $checkUser->fetch(PDO::FETCH_ASSOC);


    if($amount > $resultt['balance']){
        toast_alert('error','Insufficient Balance');
    }else {


        // $Totalamount = $nfts['fee'] + $nfts['amount'];


        $available_balance = ($resultt['balance'] - $amount);
//        $amount-=$result['acct_balance'];

            $username = userSession('username');
            $sql = "UPDATE users SET balance=:available_balance WHERE username=:username";
            $addUp = $conn->prepare($sql);
            $addUp->execute([
                'available_balance' => $available_balance,
                'username'=>$username
            ]);
            
            // Change to sold back
            
            $nft_status = "sold";
            $asset = $_GET['id'];
            $sql9 = "UPDATE nfts SET nft_status=:nft_status WHERE asset=:asset";
            $addUpnft = $conn->prepare($sql9);
            $addUpnft->execute([
                'nft_status'=>$nft_status,
                'asset' => $asset
                
            ]);



// test
            
            $stmt = $conn->prepare("SELECT * FROM nfts WHERE asset='$asset'");
            $stmt->execute();
            $nfts = $stmt->fetch(PDO::FETCH_ASSOC);

                
                //  Nft Data
            $assett = "0x49c36afa". uniqid(43);
            $nft_namee = $nfts['nft_name'];
            $linkk = $nfts['link'];
            $descriptionn = $nfts['description'];
            $collectionn = $nfts['collection'];
            $explicitt = $nfts['explicit'];
            $mintedd = $nfts['minted'];
            $amountt = $nfts['amount'];
            $payment_idd = $nfts['payment_id'];
            $metadataa = $nfts['metadata'];
            $usernamee = userSession('username');
            $nft_statuss = "active";
            
            $imagee = $nfts['image'];
            $refrence_idd = uniqid();

            $uploadnft = "INSERT INTO nfts (asset,nft_name,link,description,collection,explicit,minted,amount,payment_id,metadata,username,nft_status,image,refrence_id) VALUES(:asset,:nft_name,:link,:description,:collection,:explicit,:minted,:amount,:payment_id,:metadata,:username,:nft_status,:image,:refrence_id)";
            $stmt8 = $conn->prepare($uploadnft);

            $stmt8->execute([
                'asset' => $assett,
                'nft_name' => $nft_namee,
                'link' => $linkk,
                'description' => $descriptionn,
                'collection' => $collectionn,
                'explicit' => $explicitt,
                'minted' => $mintedd,
                'amount' => $amountt,
                'payment_id' => $payment_idd,
                'metadata' => $metadataa,
                'username' => $usernamee,
                'nft_status' => $nft_statuss,
                'image' => $imagee,
                'refrence_id' => $refrence_idd

            ]);


            
            $username = userSession('username');
            $refrence_id = uniqid();
            $trans_type = "NFT Purchase";
            $deposited = "INSERT INTO wallet (amount,username,trans_type,refrence_id)VALUES(:amount,:username,:trans_type,:refrence_id)";
            $stmt = $conn->prepare($deposited);

            $stmt->execute([
                'amount' => $amount,
                'username' => $username,
                'trans_type' => $trans_type,
                'refrence_id' => $refrence_id

            ]);

         
            if (true) {
                $sql = "SELECT d.*, c.payment_name FROM wallet d INNER JOIN payment c ON d.payment_id = c.id WHERE d.username =:username ORDER BY d.id DESC LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'username' => $username
                ]);

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                
                
                   

            // $full_name = $user['firstname']. " ". $user['lastname'];
            //             // $APP_URL = APP_URL;
            //             $APP_NAME = WEB_TITLE;
            //             $APP_URL = WEB_URL;
            //  $user_email = $user['acct_email'];

            //  $message = $sendMail->WithdrawMsg($currency, $full_name, $amount, $withdraw_method, $wallet_address, $APP_NAME);


            //  $subject = "Withdrawal Notification". "-". $APP_NAME;
            //  $email_message->send_mail($user_email, $message, $subject);

            //  $subject = "User Withdrawal Notification". "-". $APP_NAME;
            //  $email_message->send_mail(WEB_EMAIL, $message, $subject);

        if (true) {
            toast_alert('success', 'NFT Purchased Successfully', 'Approved');
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
        
            // header("Location:./withdrawal-transaction.php");
            // exit;
        
    }
}
}


// $sql = "SELECT nfts.asset, payment.name, nfts.payment_id FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $nft = $stmt->fetch(PDO::FETCH_ASSOC);




?>


<main class="mt-24">
    <!-- Item -->
    <section class="relative pt-12 pb-24 lg:py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <!-- Item -->
            <div class="md:flex md:flex-wrap">
                <!-- Image -->
                <!-- Image -->
            <figure class="mb-8 md:w-2/5 md:flex-shrink-0 md:flex-grow-0 md:basis-auto lg:w-1/2">
              <img
                src="./assets/front/img/products/<?= $nfts['image'] ?>" width="520px" height="200px"
                alt="item"
                class="cursor-pointer rounded-2.5xl"
                data-bs-toggle="modal"
                data-bs-target="#imageModal"
              />

              <!-- Modal -->
              <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog !my-0 flex h-full items-center justify-center p-4">
                  <img src="./assets/front/img/products/<?= $nfts['image'] ?>" alt="item" />
                </div>

                <button
                  type="button"
                  class="btn-close absolute top-6 right-6"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="24"
                    height="24"
                    class="h-6 w-6 fill-white"
                  >
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"
                    />
                  </svg>
                </button>
              </div>
              <!-- end modal -->
            </figure>
            
               

                <!-- Details -->
                <div class="md:w-3/5 md:basis-auto md:pl-8 lg:w-1/2 lg:pl-[3.75rem]">
                    <!-- Collection / Likes / Actions -->
                    <div class="mb-3 flex">
                        <!-- Collection -->
                        <div class="flex items-center">
                            <a href="user?id=<?= $nfts['username'] ?>"
                                class="mr-2 text-sm font-bold text-accent"><?= $nfts['username'] ?></a>
                            <span
                                class="inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-green dark:border-jacarta-600"
                                data-tippy-content="Verified Collection">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                    class="h-[.875rem] w-[.875rem] fill-white">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
                                </svg>
                            </span>
                        </div>

                        <!-- Likes / Actions -->
                        <div class="ml-auto flex space-x-2">
                            <div
                                class="flex items-center space-x-1 rounded-xl border border-jacarta-100 bg-white py-2 px-4 dark:border-jacarta-600 dark:bg-jacarta-700">
                                <span
                                    class="js-likes relative cursor-pointer before:absolute before:h-4 before:w-4 before:bg-[url('../img/heart-fill.svg')] before:bg-cover before:bg-center before:bg-no-repeat before:opacity-0"
                                    data-tippy-content="Favorite">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                        class="h-4 w-4 fill-jacarta-500 hover:fill-red dark:fill-jacarta-200 dark:hover:fill-red">
                                        <path fill="none" d="M0 0H24V24H0z"></path>
                                        <path
                                            d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="text-sm dark:text-jacarta-200"></span>
                            </div>

                            <!-- Actions -->
                            <div
                                class="dropdown rounded-xl border border-jacarta-100 bg-white hover:bg-jacarta-100 dark:border-jacarta-600 dark:bg-jacarta-700 dark:hover:bg-jacarta-600">
                                <a href="#"
                                    class="dropdown-toggle inline-flex h-10 w-10 items-center justify-center text-sm"
                                    role="button" id="collectionActions" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <svg width="16" height="4" viewBox="0 0 16 4" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="fill-jacarta-500 dark:fill-jacarta-200">
                                        <circle cx="2" cy="2" r="2"></circle>
                                        <circle cx="8" cy="2" r="2"></circle>
                                        <circle cx="14" cy="2" r="2"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end z-10 hidden min-w-[200px] whitespace-nowrap rounded-xl bg-white py-4 px-2 text-left shadow-xl dark:bg-jacarta-800"
                                    aria-labelledby="collectionActions">
                                    <button
                                        class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                        Share
                                    </button>
                                    <a href="#"
                                        class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                        Report
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1 class="mb-4 font-display text-4xl font-semibold text-jacarta-700 dark:text-white">
                        <?= $nfts['nft_name'] ?></h1>

                       



                        
                    <div class="mb-8 flex items-center space-x-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <?= $nfts['svg'] ?>
                            <span
                                class="text-sm font-medium tracking-tight text-green"><?= $nfts['amount'] ?> <?=$nfts['short_name']?></span>
                        </div>
                        <span class="text-sm text-jacarta-400 dark:text-jacarta-300">Highest bid</span>
                        <span
                            class="text-sm text-jacarta-400 dark:text-jacarta-300"><?=$nfts['minted'] ?>/<?=$nfts['level'] ?>
                            available</span>
                    </div>

                    <p class="mb-10 dark:text-jacarta-300">
                        <?= $nfts['tagline'] ?>
                    </p>

                    <!-- Creator / Owner -->
                    <div class="mb-8 flex flex-wrap">
                        <div class="mr-8 mb-4 flex">
                            <figure class="mr-4 shrink-0">
                                <a href="#" class="relative block">
                                    <img src="./assets/front/img/uploads/<?=$admin['admin_image'] ?>" alt="avatar 7"
                                        class="rounded-2lg" loading="lazy" width="50" />
                                    <div class="absolute -right-3 top-[60%] flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-green dark:border-jacarta-600"
                                        data-tippy-content="Verified Collection">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="h-[.875rem] w-[.875rem] fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z">
                                            </path>
                                        </svg>
                                    </div>
                                </a>
                            </figure>
                            <div class="flex flex-col justify-center">
                                <span class="block text-sm text-jacarta-400 dark:text-white">Creator
                                    <strong><?=$settings['royalties']?>%
                                        royalties</strong></span>
                                <a href="#" class="block text-accent">
                                    <span class="text-sm font-bold">@<?= $admin['name'] ?></span>
                                </a>
                            </div>
                        </div>

                        <div class="mb-4 flex">
                            <figure class="mr-4 shrink-0">
                                <a href="user?id=<?= $nfts['username'] ?>" class="relative block">
                                    <img src="./assets/front/img/uploads/<?= $nfts['avatar'] ?>" alt="avatar 1"
                                        class="rounded-2lg" loading="lazy" width="50" />
                                    <div class="absolute -right-3 top-[60%] flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-green dark:border-jacarta-600"
                                        data-tippy-content="Verified Collection">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="h-[.875rem] w-[.875rem] fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z">
                                            </path>
                                        </svg>
                                    </div>
                                </a>
                            </figure>
                            <div class="flex flex-col justify-center">
                                <span class="block text-sm text-jacarta-400 dark:text-white">Owned by</span>
                                <a href="user?id=<?= $nfts['username'] ?>" class="block text-accent">
                                    <span class="text-sm font-bold">@<?= $nfts['username'] ?></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bid -->
                    <div
                        class="rounded-2lg border border-jacarta-100 bg-white p-8 dark:border-jacarta-600 dark:bg-jacarta-700">
                        <div class="mb-8 sm:flex sm:flex-wrap">
                            <!-- Highest bid -->
                            <div class="sm:w-1/2 sm:pr-4 lg:pr-8">
                                <div class="mt-3 flex">
                                    <figure class="mr-4 shrink-0">
                                        <a href="user?id=<?= $nfts['username']?>" class="relative block">
                                            <img src="./assets/front/img/avatars/avatar_4.jpg" alt="avatar"
                                                class="rounded-2lg" loading="lazy" />
                                        </a>
                                    </figure>
                                    <div>
                                        <div class="flex items-center whitespace-nowrap">
                                            <?= $nfts['svg']?>
                                            <span
                                                class="text-lg font-medium leading-tight tracking-tight text-green"><?= $nfts['amount']?> <?= $nfts['short_name']?></span>
                                        </div>
                                        <span class="text-sm text-jacarta-400 dark:text-jacarta-300">Current
                                            Price</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Countdown -->
                            <div
                                class="mt-4 dark:border-jacarta-600 sm:mt-0 sm:w-1/2 sm:border-l sm:border-jacarta-100 sm:pl-4 lg:pl-8">
                                <span
                                    class="js-countdown-ends-label text-sm text-jacarta-400 dark:text-jacarta-300">Auction
                                    ends in</span>
                                <div class="js-countdown-single-timer mt-3 flex space-x-4"
                                    data-countdown="2023-01-07T19:40:30" data-expired="This auction has ended">
                                    <span class="countdown-days text-jacarta-700 dark:text-white">
                                        <span
                                            class="js-countdown-days-number text-lg font-medium lg:text-[1.5rem]"><?= $nfts['createdAt']?></span>

                                    </span>

                                </div>
                            </div>
                        </div>

<?php if( isset($_SESSION['nftwallet']) && !empty($_SESSION['nftwallet']) && $nfts['username'] == userSession('username') )
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
  ':username'=>$_SESSION['nftwallet']
]);
$users = $stmt->fetch(PDO::FETCH_ASSOC);
?>

                        <a href="edit-nft?id=<?= $nfts['asset'] ?>"
                            class="inline-block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">Edit
                            NFT </a>

                             <br>

                        <br>
                            
                            <a href="delete-nft?id=<?= $nfts['nft_id'] ?>"
                            class="inline-block w-full rounded-full bg-primary py-3 px-8 text-center font-semibold text-accent shadow-accent-volume transition-all hover:bg-primary-dark">Delete
                            NFT </a>


                        <?php }else{ ?>

                        <?php 
                        if ($nfts['nft_status'] == 'hold' or $nfts['nft_status'] == 'sold'){
                        
                        ?>
                        <a href="#" disabled
                            class="inline-block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">Not
                            Available </a>

                        <?php
                        }else{
                        ?>
                         <?php if( isset($_SESSION['nftwallet']) && !empty($_SESSION['nftwallet']) )
{
?>
<a href="#" data-bs-toggle="modal" data-bs-target="#buyNowModal"
                            class="inline-block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">Add
                            to cart </a>
                        <br>

                        <br>


                        <!--<a href="#" data-bs-toggle="modal" data-bs-target="#placeBidModal"-->
                        <!--    class="inline-block w-full rounded-full bg-primary py-3 px-8 text-center font-semibold text-accent shadow-accent-volume transition-all hover:bg-primary-dark">Make-->
                        <!--    offer </a>-->
                            <?php }else{ ?>
                            
                            <a href="login" 
                            class="inline-block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">Add
                            to cart </a>
                        <br>

                        <br>


                        <!--<a href="login" -->
                        <!--    class="inline-block w-full rounded-full bg-primary py-3 px-8 text-center font-semibold text-accent shadow-accent-volume transition-all hover:bg-primary-dark">Make-->
                        <!--    offer </a>-->

                            <?php } ?>
                        

                        <?php
                        }
                        ?>

                        <?php } ?>



                    </div>
                    <!-- end bid -->
                </div>
                <!-- end details -->
            </div>

            <!-- Tabs -->
            <div class="scrollbar-custom mt-14 overflow-x-auto rounded-lg">
                <div class="min-w-fit">
                    <!-- Tabs Nav -->
                    <ul class="nav nav-tabs flex items-center" role="tablist">

                        <!-- Properties -->


                        <!-- Details -->
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link active relative flex items-center whitespace-nowrap py-3 px-6 text-jacarta-400 hover:text-jacarta-700 dark:hover:text-white"
                                id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab"
                                aria-controls="details" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                    class="mr-1 h-5 w-5 fill-current">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1zm-1-2V4H5v16h14zM7 6h4v4H7V6zm0 6h10v2H7v-2zm0 4h10v2H7v-2zm6-9h4v2h-4V7z" />
                                </svg>
                                <span class="font-display text-base font-medium">Details</span>
                            </button>
                        </li>

                        <!-- Activity -->
                        <!--<li class="nav-item" role="presentation">-->
                        <!--    <button-->
                        <!--        class="nav-link relative flex items-center whitespace-nowrap py-3 px-6 text-jacarta-400 hover:text-jacarta-700 dark:hover:text-white"-->
                        <!--        id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button"-->
                        <!--        role="tab" aria-controls="activity" aria-selected="false">-->
                        <!--        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"-->
                        <!--            class="mr-1 h-5 w-5 fill-current">-->
                        <!--            <path fill="none" d="M0 0h24v24H0z" />-->
                        <!--            <path-->
                        <!--                d="M11.95 7.95l-1.414 1.414L8 6.828 8 20H6V6.828L3.465 9.364 2.05 7.95 7 3l4.95 4.95zm10 8.1L17 21l-4.95-4.95 1.414-1.414 2.537 2.536L16 4h2v13.172l2.536-2.536 1.414 1.414z" />-->
                        <!--        </svg>-->
                        <!--        <span class="font-display text-base font-medium">Activity</span>-->
                        <!--    </button>-->
                        <!--</li>-->


                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">



                        <!-- Details -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            <div
                                class="rounded-t-2lg rounded-b-2lg rounded-tl-none border border-jacarta-100 bg-white p-6 dark:border-jacarta-600 dark:bg-jacarta-700 md:p-10">
                                <div class="mb-2 flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Contract Address:</span>
                                    <a href="<?= $nfts['link'] ?>" target="_blank" class="text-accent"><?= $nfts['asset']?> </a>
                                </div>
                                <div class="mb-2 flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Token ID:</span>
                                    <span
                                        class="js-copy-clipboard cursor-pointer select-none text-jacarta-700 dark:text-white"
                                        data-tippy-content="Copy">7714<?=$nfts['id'] ?></span>
                                </div>
                                <div class="mb-2 flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Token Standard:</span>
                                    <span class="text-jacarta-700 dark:text-white">ERC-721</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Blockchain:</span>
                                    <span class="text-jacarta-700 dark:text-white"><?= $nfts['payment_name']?></span>
                                </div>

                                <?php if( $nfts['metadata'] === "Frozen")
{
?>
                                <div class="flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Metadata:</span>
                                    <span class="text-jacarta-700 dark:text-white"><?= $nfts['metadata']?></span> &nbsp;
                                    <span class="inline-block"
                                        data-tippy-content="This item's metadata was permanently locked and stored in decentralized file storage on <?= $nfts['createdAt']?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="mb-[2px] h-5 w-5 fill-jacarta-500 dark:fill-jacarta-300">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z">
                                            </path>
                                        </svg>
                                    </span>
                                </div>

                                <?php }else{ ?>

                                <?php } ?>


                                <div class="flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Last updated:</span>
                                    <span class="text-jacarta-700 dark:text-white"><?=$nfts['updatetimedAt'] ?></span>
                                </div>


                                <div class="flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Creator Earnings:</span>
                                    <span class="text-jacarta-700 dark:text-white"><?=$settings['royalties'] ?>%</span>
                                </div>

                                <br>

                                <hr>
                                <br>

                                <p><?= $nfts['description']?></p>
                            </div>
                        </div>

                        <!-- Activity -->
                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">


                            <div role="table"
                                class="scrollbar-custom max-h-72 w-full overflow-y-auto rounded-lg rounded-tl-none border border-jacarta-100 bg-white text-sm dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white">
                                <div class="sticky top-0 flex bg-light-base dark:bg-jacarta-600" role="row">
                                    <div class="w-[17%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Event</span>
                                    </div>
                                    <div class="w-[17%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Price</span>
                                    </div>
                                    <div class="w-[22%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">From</span>
                                    </div>
                                    <div class="w-[22%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">To</span>
                                    </div>
                                    <div class="w-[22%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Date</span>
                                    </div>
                                </div>
                                <div class="flex" role="row">
                                    <div class="flex w-[17%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24"
                                            class="mr-2 h-4 w-4 fill-jacarta-700 group-hover:fill-white dark:fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M14 20v2H2v-2h12zM14.586.686l7.778 7.778L20.95 9.88l-1.06-.354L17.413 12l5.657 5.657-1.414 1.414L16 13.414l-2.404 2.404.283 1.132-1.415 1.414-7.778-7.778 1.415-1.414 1.13.282 6.294-6.293-.353-1.06L14.586.686zm.707 3.536l-7.071 7.07 3.535 3.536 7.071-7.07-3.535-3.536z">
                                            </path>
                                        </svg>
                                        Bid
                                    </div>
                                    <div class="flex w-[17%] items-center whitespace-nowrap border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <span class="-ml-1" data-tippy-content="ETH">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                viewBox="0 0 1920 1920" xml:space="preserve" class="mr-1 h-4 w-4">
                                                <path fill="#8A92B2" d="M959.8 80.7L420.1 976.3 959.8 731z"></path>
                                                <path fill="#62688F"
                                                    d="M959.8 731L420.1 976.3l539.7 319.1zm539.8 245.3L959.8 80.7V731z">
                                                </path>
                                                <path fill="#454A75" d="M959.8 1295.4l539.8-319.1L959.8 731z"></path>
                                                <path fill="#8A92B2" d="M420.1 1078.7l539.7 760.6v-441.7z"></path>
                                                <path fill="#62688F" d="M959.8 1397.6v441.7l540.1-760.6z"></path>
                                            </svg>
                                        </span>
                                        <span class="text-sm font-medium tracking-tight text-green">30 ETH</span>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">AD496A</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">Polymorph: MORPH Token</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="#" class="flex flex-wrap items-center text-accent" target="_blank"
                                            rel="nofollow noopener" title="Opens in a  window"
                                            data-tippy-content="March 13 2022, 2:32 pm">
                                            <span class="mr-1">19 days ago</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24" class="h-4 w-4 fill-current">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M10 6v2H5v11h11v-5h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6zm11-3v8h-2V6.413l-7.793 7.794-1.414-1.414L17.585 5H13V3h8z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex" role="row">
                                    <div class="flex w-[17%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24"
                                            class="mr-2 h-4 w-4 fill-jacarta-700 group-hover:fill-white dark:fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M16.05 12.05L21 17l-4.95 4.95-1.414-1.414 2.536-2.537L4 18v-2h13.172l-2.536-2.536 1.414-1.414zm-8.1-10l1.414 1.414L6.828 6 20 6v2H6.828l2.536 2.536L7.95 11.95 3 7l4.95-4.95z">
                                            </path>
                                        </svg>
                                        Transfer
                                    </div>
                                    <div class="flex w-[17%] items-center whitespace-nowrap border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <span class="-ml-1" data-tippy-content="ETH">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                viewBox="0 0 1920 1920" xml:space="preserve" class="mr-1 h-4 w-4">
                                                <path fill="#8A92B2" d="M959.8 80.7L420.1 976.3 959.8 731z"></path>
                                                <path fill="#62688F"
                                                    d="M959.8 731L420.1 976.3l539.7 319.1zm539.8 245.3L959.8 80.7V731z">
                                                </path>
                                                <path fill="#454A75" d="M959.8 1295.4l539.8-319.1L959.8 731z"></path>
                                                <path fill="#8A92B2" d="M420.1 1078.7l539.7 760.6v-441.7z"></path>
                                                <path fill="#62688F" d="M959.8 1397.6v441.7l540.1-760.6z"></path>
                                            </svg>
                                        </span>
                                        <span class="text-sm font-medium tracking-tight text-green">.00510 ETH</span>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">The_vikk</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">Polymorph: MORPH Token</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <span class="mr-1 dark:text-jacarta-300">16 days ago</span>
                                    </div>
                                </div>
                                <div class="flex" role="row">
                                    <div class="flex w-[17%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24"
                                            class="mr-2 h-4 w-4 fill-jacarta-700 group-hover:fill-white dark:fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M6.5 2h11a1 1 0 0 1 .8.4L21 6v15a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6l2.7-3.6a1 1 0 0 1 .8-.4zM19 8H5v12h14V8zm-.5-2L17 4H7L5.5 6h13zM9 10v2a3 3 0 0 0 6 0v-2h2v2a5 5 0 0 1-10 0v-2h2z">
                                            </path>
                                        </svg>
                                        Sale
                                    </div>
                                    <div class="flex w-[17%] items-center whitespace-nowrap border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <span class="-ml-1" data-tippy-content="ETH">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                viewBox="0 0 1920 1920" xml:space="preserve" class="mr-1 h-4 w-4">
                                                <path fill="#8A92B2" d="M959.8 80.7L420.1 976.3 959.8 731z"></path>
                                                <path fill="#62688F"
                                                    d="M959.8 731L420.1 976.3l539.7 319.1zm539.8 245.3L959.8 80.7V731z">
                                                </path>
                                                <path fill="#454A75" d="M959.8 1295.4l539.8-319.1L959.8 731z"></path>
                                                <path fill="#8A92B2" d="M420.1 1078.7l539.7 760.6v-441.7z"></path>
                                                <path fill="#62688F" d="M959.8 1397.6v441.7l540.1-760.6z"></path>
                                            </svg>
                                        </span>
                                        <span class="text-sm font-medium tracking-tight text-green">1.50 ETH</span>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">CryptoGuysNFT</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">Polymorph: MORPH Token</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="#" class="flex flex-wrap items-center text-accent" target="_blank"
                                            rel="nofollow noopener" title="Opens in a  window"
                                            data-tippy-content="March 13 2022, 2:32 pm">
                                            <span class="mr-1">19 days ago</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24" class="h-4 w-4 fill-current">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M10 6v2H5v11h11v-5h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6zm11-3v8h-2V6.413l-7.793 7.794-1.414-1.414L17.585 5H13V3h8z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- end tab content -->
                </div>
            </div>
            <!-- end tabs -->
        </div>
    </section>
    <!-- end item -->

    <!-- Related -->
    <section class="bg-light-base py-24 dark:bg-jacarta-800">
        <div class="container">
            <h2 class="mb-8 text-center font-display text-3xl text-jacarta-700 dark:text-white">
                More from this collection
            </h2>

            <div class="relative">
                <!-- Slider -->
                <div class="swiper card-slider-4-columns !py-5">
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
                                        INNER JOIN users ON nfts.username=users.username WHERE nft_status='active' ORDER BY RAND()
                                        LIMIT 8");
                                        $stmt->execute();
                                        while($related = $stmt->fetch()){
                                ?>

                        <div class="swiper-slide">
                            <article>
                                <div
                                    class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                                    <figure>
                                        <a href="asset?id=<?= $related['asset'] ?>">
                                            <img src="./assets/front/img/products/<?= $related['image'] ?>" alt="item 1"
                                                width="230" height="230" class="w-full rounded-[0.625rem]"
                                                loading="lazy" />
                                        </a>
                                    </figure>
                                    <div class="mt-4 flex items-center justify-between">
                                        <a href="asset?id=<?= $related['asset'] ?>">
                                            <span
                                                class="font-display text-base text-jacarta-700 hover:text-accent dark:text-white"><?= $related['nft_name'] ?></span>
                                        </a>
                                        <span
                                            class="flex items-center whitespace-nowrap rounded-md border border-jacarta-100 py-1 px-2 dark:border-jacarta-600">


                                            <span
                                                class="text-sm font-medium tracking-tight text-green"><?= $related['amount'] ?> <?=$related['short_name'] ?></span>
                                        </span>
                                    </div>

                                </div>
                            </article>
                        </div>

                        <?php
                                        }
                        ?>

                    </div>
                </div>

                <!-- Slider Navigation -->
                <div
                    class="swiper-button-prev group absolute top-1/2 -left-4 z-10 -mt-6 flex h-12 w-12 cursor-pointer items-center justify-center rounded-full bg-white p-3 text-base shadow-white-volume sm:-left-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        class="fill-jacarta-700 group-hover:fill-accent">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z" />
                    </svg>
                </div>
                <div
                    class="swiper-button-next group absolute top-1/2 -right-4 z-10 -mt-6 flex h-12 w-12 cursor-pointer items-center justify-center rounded-full bg-white p-3 text-base shadow-white-volume sm:-right-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        class="fill-jacarta-700 group-hover:fill-accent">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- end related -->




    <!-- Buy Now Modal -->
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
        <div class="modal-dialog max-w-2xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buyNowModalLabel">Complete checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            class="h-6 w-6 fill-jacarta-700 dark:fill-white">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <form method="POST">
                    <div class="modal-body p-6">
                        <div class="mb-2 flex items-center justify-between">
                            <span
                                class="font-display text-sm font-semibold text-jacarta-700 dark:text-white">Item</span>
                            <span
                                class="font-display text-sm font-semibold text-jacarta-700 dark:text-white">Subtotal</span>
                        </div>

                        <div
                            class="relative flex items-center border-t border-b border-jacarta-100 py-4 dark:border-jacarta-600">
                            <figure class="mr-5 self-start">
                                <img src="./assets/front/img/avatars/avatar_2.jpg" alt="avatar 2" class="rounded-2lg"
                                    loading="lazy" />
                            </figure>

                            <div>
                                <a href="collection.html" class="text-sm text-accent"><?= $nfts['nft_name'] ?></a>
                                <h3 class="mb-1 font-display text-base font-semibold text-jacarta-700 dark:text-white">
                                    @<?= $nfts['username'] ?>
                                </h3>
                                <div class="flex flex-wrap items-center">
                                    <span class="mr-1 block text-sm text-jacarta-500 dark:text-jacarta-300">Creator
                                        Earnings: <?=$settings['royalties'] ?>%</span>
                                    <span
                                        data-tippy-content="The creator of this collection will receive <?=$settings['royalties'] ?>% of the sale total from future sales of this item.">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="h-4 w-4 fill-jacarta-700 dark:fill-jacarta-300">
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path
                                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="ml-auto">
                                <span class="mb-1 flex items-center whitespace-nowrap">
                                    <span
                                        class="text-sm font-medium tracking-tight dark:text-jacarta-100"><?=$nfts['amount']?>
                                        <?=$nfts['short_name'] ?></span>
                                </span>
                                <div class="text-right text-sm dark:text-jacarta-300">Gas Fee:
                                    <?=$nfts['fee'] ?> <?=$nfts['short_name'] ?>

                                    
                                 

                     

                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div
                            class="mb-2 flex items-center justify-between border-b border-jacarta-100 py-2.5 dark:border-jacarta-600">
                            <span
                                class="font-display font-semibold text-jacarta-700 hover:text-accent dark:text-white">Total</span>
                            <div class="ml-auto">
                                <span class="flex items-center whitespace-nowrap">
                                    <span class="font-medium tracking-tight text-green"><?= $Totalamount; ?> <?=$nfts['short_name'] ?></span>
                                </span>

                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="mt-4 flex items-center space-x-2">
                            <input type="checkbox" required
                                class="h-5 w-5 self-start rounded border-jacarta-200 text-accent checked:bg-accent focus:ring-accent/20 focus:ring-offset-0 dark:border-jacarta-500 dark:bg-jacarta-600" />

                            <input name="amount" value="<?= $Totalamount; ?>" hidden />
                            <label for="buyNowTerms" class="text-sm dark:text-jacarta-200">By checking this box, I agree
                                to
                                Xhibiter's <a href="#" class="text-accent">Terms of Service</a></label>
                        </div>
                    </div>
                    <!-- end body -->

                    <div class="modal-footer">
                        <div class="flex items-center justify-center space-x-4">
                            <button type="submit" name="checkoutnft"
                                class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                                Confirm Checkout
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Place Bid Modal -->
    <div class="modal fade" id="placeBidModal" tabindex="-1" aria-labelledby="placeBidLabel" aria-hidden="true">
        <div class="modal-dialog max-w-2xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="placeBidLabel">Place a bid</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            class="h-6 w-6 fill-jacarta-700 dark:fill-white">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body p-6">
                    <div class="mb-2 flex items-center justify-between">
                        <span class="font-display text-sm font-semibold text-jacarta-700 dark:text-white">Price</span>
                    </div>

                    <div
                        class="relative mb-2 flex items-center overflow-hidden rounded-lg border border-jacarta-100 dark:border-jacarta-600">
                        <div
                            class="flex flex-1 items-center self-stretch border-r border-jacarta-100 bg-jacarta-50 px-2">
                            <span>
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                    viewBox="0 0 1920 1920" xml:space="preserve" class="mr-1 h-5 w-5">
                                    <path fill="#8A92B2" d="M959.8 80.7L420.1 976.3 959.8 731z"></path>
                                    <path fill="#62688F"
                                        d="M959.8 731L420.1 976.3l539.7 319.1zm539.8 245.3L959.8 80.7V731z"></path>
                                    <path fill="#454A75" d="M959.8 1295.4l539.8-319.1L959.8 731z"></path>
                                    <path fill="#8A92B2" d="M420.1 1078.7l539.7 760.6v-441.7z"></path>
                                    <path fill="#62688F" d="M959.8 1397.6v441.7l540.1-760.6z"></path>
                                </svg>
                            </span>
                            <span class="font-display text-sm text-jacarta-700">ETH</span>
                        </div>

                        <input type="text" class="h-12 w-full flex-[3] border-0 focus:ring-inset focus:ring-accent"
                            placeholder="Amount" value="0.05" />

                        <div class="flex flex-1 justify-end self-stretch border-l border-jacarta-100 bg-jacarta-50">
                            <span class="self-center px-2 text-sm">$130.82</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="text-sm dark:text-jacarta-400">Balance: 0.0000 WETH</span>
                    </div>

                    <!-- Terms -->
                    <div class="mt-4 flex items-center space-x-2">
                        <input type="checkbox" id="terms"
                            class="h-5 w-5 self-start rounded border-jacarta-200 text-accent checked:bg-accent focus:ring-accent/20 focus:ring-offset-0 dark:border-jacarta-500 dark:bg-jacarta-600" />
                        <label for="terms" class="text-sm dark:text-jacarta-200">By checking this box, I agree to
                            Xhibiter's <a href="#" class="text-accent">Terms of Service</a></label>
                    </div>
                </div>
                <!-- end body -->

                <div class="modal-footer">
                    <div class="flex items-center justify-center space-x-4">
                        <button type="button"
                            class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                            Place Bid
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
  include_once("./layout/footer.php");

  ?>


<?php
$PageTitle = "View";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

$asset = $_GET['id'];

if(empty($asset = $_GET['id'])){
    header("Location:./404");
    exit;
} 



    





// NFT Items
$stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
INNER JOIN users ON nfts.username=users.username
WHERE asset='$asset'");
$stmt->execute();
$nfts = $stmt->fetch(PDO::FETCH_ASSOC);



$Totalamount = $nfts['fee'] + $nfts['amount'];



if(isset($_POST['checkoutnft'])){
    $username = userSession('username');
    $amount = $_POST['amount'];

    

    
    $checkUser = $conn->query("SELECT * FROM users WHERE username='$username'");
    $resultt = $checkUser->fetch(PDO::FETCH_ASSOC);


    if($amount > $resultt['balance']){
        toast_alert('error','Insufficient Balance');
    }else {


        // $Totalamount = $nfts['fee'] + $nfts['amount'];


        $available_balance = ($resultt['balance'] - $amount);
//        $amount-=$result['acct_balance'];

            $username = userSession('username');
            $sql = "UPDATE users SET balance=:available_balance WHERE username=:username";
            $addUp = $conn->prepare($sql);
            $addUp->execute([
                'available_balance' => $available_balance,
                'username'=>$username
            ]);
            
            // Change to sold back
            
            $nft_status = "sold";
            $asset = $_GET['id'];
            $sql9 = "UPDATE nfts SET nft_status=:nft_status WHERE asset=:asset";
            $addUpnft = $conn->prepare($sql9);
            $addUpnft->execute([
                'nft_status'=>$nft_status,
                'asset' => $asset
                
            ]);



// test
            
            $stmt = $conn->prepare("SELECT * FROM nfts WHERE asset='$asset'");
            $stmt->execute();
            $nfts = $stmt->fetch(PDO::FETCH_ASSOC);

                
                //  Nft Data
            $assett = "0x49c36afa". uniqid(43);
            $nft_namee = $nfts['nft_name'];
            $linkk = $nfts['link'];
            $descriptionn = $nfts['description'];
            $collectionn = $nfts['collection'];
            $explicitt = $nfts['explicit'];
            $mintedd = $nfts['minted'];
            $amountt = $nfts['amount'];
            $payment_idd = $nfts['payment_id'];
            $metadataa = $nfts['metadata'];
            $usernamee = userSession('username');
            $nft_statuss = "active";
            
            $imagee = $nfts['image'];
            $refrence_idd = uniqid();

            $uploadnft = "INSERT INTO nfts (asset,nft_name,link,description,collection,explicit,minted,amount,payment_id,metadata,username,nft_status,image,refrence_id) VALUES(:asset,:nft_name,:link,:description,:collection,:explicit,:minted,:amount,:payment_id,:metadata,:username,:nft_status,:image,:refrence_id)";
            $stmt8 = $conn->prepare($uploadnft);

            $stmt8->execute([
                'asset' => $assett,
                'nft_name' => $nft_namee,
                'link' => $linkk,
                'description' => $descriptionn,
                'collection' => $collectionn,
                'explicit' => $explicitt,
                'minted' => $mintedd,
                'amount' => $amountt,
                'payment_id' => $payment_idd,
                'metadata' => $metadataa,
                'username' => $usernamee,
                'nft_status' => $nft_statuss,
                'image' => $imagee,
                'refrence_id' => $refrence_idd

            ]);


            
            $username = userSession('username');
            $refrence_id = uniqid();
            $trans_type = "NFT Purchase";
            $deposited = "INSERT INTO wallet (amount,username,trans_type,refrence_id)VALUES(:amount,:username,:trans_type,:refrence_id)";
            $stmt = $conn->prepare($deposited);

            $stmt->execute([
                'amount' => $amount,
                'username' => $username,
                'trans_type' => $trans_type,
                'refrence_id' => $refrence_id

            ]);

         
            if (true) {
                $sql = "SELECT d.*, c.payment_name FROM wallet d INNER JOIN payment c ON d.payment_id = c.id WHERE d.username =:username ORDER BY d.id DESC LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'username' => $username
                ]);

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                
                
                   

            // $full_name = $user['firstname']. " ". $user['lastname'];
            //             // $APP_URL = APP_URL;
            //             $APP_NAME = WEB_TITLE;
            //             $APP_URL = WEB_URL;
            //  $user_email = $user['acct_email'];

            //  $message = $sendMail->WithdrawMsg($currency, $full_name, $amount, $withdraw_method, $wallet_address, $APP_NAME);


            //  $subject = "Withdrawal Notification". "-". $APP_NAME;
            //  $email_message->send_mail($user_email, $message, $subject);

            //  $subject = "User Withdrawal Notification". "-". $APP_NAME;
            //  $email_message->send_mail(WEB_EMAIL, $message, $subject);

        if (true) {
            toast_alert('success', 'NFT Purchased Successfully', 'Approved');
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
        
            // header("Location:./withdrawal-transaction.php");
            // exit;
        
    }
}
}


// $sql = "SELECT nfts.asset, payment.name, nfts.payment_id FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $nft = $stmt->fetch(PDO::FETCH_ASSOC);




?>


<main class="mt-24">
    <!-- Item -->
    <section class="relative pt-12 pb-24 lg:py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <!-- Item -->
            <div class="md:flex md:flex-wrap">
                <!-- Image -->
                <!-- Image -->
            <figure class="mb-8 md:w-2/5 md:flex-shrink-0 md:flex-grow-0 md:basis-auto lg:w-1/2">
              <img
                src="./assets/front/img/products/<?= $nfts['image'] ?>" width="520px" height="200px"
                alt="item"
                class="cursor-pointer rounded-2.5xl"
                data-bs-toggle="modal"
                data-bs-target="#imageModal"
              />

              <!-- Modal -->
              <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog !my-0 flex h-full items-center justify-center p-4">
                  <img src="./assets/front/img/products/<?= $nfts['image'] ?>" alt="item" />
                </div>

                <button
                  type="button"
                  class="btn-close absolute top-6 right-6"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="24"
                    height="24"
                    class="h-6 w-6 fill-white"
                  >
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"
                    />
                  </svg>
                </button>
              </div>
              <!-- end modal -->
            </figure>
            
               

                <!-- Details -->
                <div class="md:w-3/5 md:basis-auto md:pl-8 lg:w-1/2 lg:pl-[3.75rem]">
                    <!-- Collection / Likes / Actions -->
                    <div class="mb-3 flex">
                        <!-- Collection -->
                        <div class="flex items-center">
                            <a href="user?id=<?= $nfts['username'] ?>"
                                class="mr-2 text-sm font-bold text-accent"><?= $nfts['username'] ?></a>
                            <span
                                class="inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-green dark:border-jacarta-600"
                                data-tippy-content="Verified Collection">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                    class="h-[.875rem] w-[.875rem] fill-white">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
                                </svg>
                            </span>
                        </div>

                        <!-- Likes / Actions -->
                        <div class="ml-auto flex space-x-2">
                            <div
                                class="flex items-center space-x-1 rounded-xl border border-jacarta-100 bg-white py-2 px-4 dark:border-jacarta-600 dark:bg-jacarta-700">
                                <span
                                    class="js-likes relative cursor-pointer before:absolute before:h-4 before:w-4 before:bg-[url('../img/heart-fill.svg')] before:bg-cover before:bg-center before:bg-no-repeat before:opacity-0"
                                    data-tippy-content="Favorite">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                        class="h-4 w-4 fill-jacarta-500 hover:fill-red dark:fill-jacarta-200 dark:hover:fill-red">
                                        <path fill="none" d="M0 0H24V24H0z"></path>
                                        <path
                                            d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="text-sm dark:text-jacarta-200"></span>
                            </div>

                            <!-- Actions -->
                            <div
                                class="dropdown rounded-xl border border-jacarta-100 bg-white hover:bg-jacarta-100 dark:border-jacarta-600 dark:bg-jacarta-700 dark:hover:bg-jacarta-600">
                                <a href="#"
                                    class="dropdown-toggle inline-flex h-10 w-10 items-center justify-center text-sm"
                                    role="button" id="collectionActions" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <svg width="16" height="4" viewBox="0 0 16 4" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="fill-jacarta-500 dark:fill-jacarta-200">
                                        <circle cx="2" cy="2" r="2"></circle>
                                        <circle cx="8" cy="2" r="2"></circle>
                                        <circle cx="14" cy="2" r="2"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end z-10 hidden min-w-[200px] whitespace-nowrap rounded-xl bg-white py-4 px-2 text-left shadow-xl dark:bg-jacarta-800"
                                    aria-labelledby="collectionActions">
                                    <button
                                        class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                        Share
                                    </button>
                                    <a href="#"
                                        class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                        Report
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1 class="mb-4 font-display text-4xl font-semibold text-jacarta-700 dark:text-white">
                        <?= $nfts['nft_name'] ?></h1>

                       



                        
                    <div class="mb-8 flex items-center space-x-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <?= $nfts['svg'] ?>
                            <span
                                class="text-sm font-medium tracking-tight text-green"><?= $nfts['amount'] ?> <?=$nfts['short_name']?></span>
                        </div>
                        <span class="text-sm text-jacarta-400 dark:text-jacarta-300">Highest bid</span>
                        <span
                            class="text-sm text-jacarta-400 dark:text-jacarta-300"><?=$nfts['minted'] ?>/<?=$nfts['level'] ?>
                            available</span>
                    </div>

                    <p class="mb-10 dark:text-jacarta-300">
                        <?= $nfts['tagline'] ?>
                    </p>

                    <!-- Creator / Owner -->
                    <div class="mb-8 flex flex-wrap">
                        <div class="mr-8 mb-4 flex">
                            <figure class="mr-4 shrink-0">
                                <a href="#" class="relative block">
                                    <img src="./assets/front/img/uploads/<?=$admin['admin_image'] ?>" alt="avatar 7"
                                        class="rounded-2lg" loading="lazy" width="50" />
                                    <div class="absolute -right-3 top-[60%] flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-green dark:border-jacarta-600"
                                        data-tippy-content="Verified Collection">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="h-[.875rem] w-[.875rem] fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z">
                                            </path>
                                        </svg>
                                    </div>
                                </a>
                            </figure>
                            <div class="flex flex-col justify-center">
                                <span class="block text-sm text-jacarta-400 dark:text-white">Creator
                                    <strong><?=$settings['royalties']?>%
                                        royalties</strong></span>
                                <a href="#" class="block text-accent">
                                    <span class="text-sm font-bold">@<?= $admin['name'] ?></span>
                                </a>
                            </div>
                        </div>

                        <div class="mb-4 flex">
                            <figure class="mr-4 shrink-0">
                                <a href="user?id=<?= $nfts['username'] ?>" class="relative block">
                                    <img src="./assets/front/img/uploads/<?= $nfts['avatar'] ?>" alt="avatar 1"
                                        class="rounded-2lg" loading="lazy" width="50" />
                                    <div class="absolute -right-3 top-[60%] flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-green dark:border-jacarta-600"
                                        data-tippy-content="Verified Collection">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="h-[.875rem] w-[.875rem] fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z">
                                            </path>
                                        </svg>
                                    </div>
                                </a>
                            </figure>
                            <div class="flex flex-col justify-center">
                                <span class="block text-sm text-jacarta-400 dark:text-white">Owned by</span>
                                <a href="user?id=<?= $nfts['username'] ?>" class="block text-accent">
                                    <span class="text-sm font-bold">@<?= $nfts['username'] ?></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bid -->
                    <div
                        class="rounded-2lg border border-jacarta-100 bg-white p-8 dark:border-jacarta-600 dark:bg-jacarta-700">
                        <div class="mb-8 sm:flex sm:flex-wrap">
                            <!-- Highest bid -->
                            <div class="sm:w-1/2 sm:pr-4 lg:pr-8">
                                <div class="mt-3 flex">
                                    <figure class="mr-4 shrink-0">
                                        <a href="user?id=<?= $nfts['username']?>" class="relative block">
                                            <img src="./assets/front/img/avatars/avatar_4.jpg" alt="avatar"
                                                class="rounded-2lg" loading="lazy" />
                                        </a>
                                    </figure>
                                    <div>
                                        <div class="flex items-center whitespace-nowrap">
                                            <?= $nfts['svg']?>
                                            <span
                                                class="text-lg font-medium leading-tight tracking-tight text-green"><?= $nfts['amount']?> <?= $nfts['short_name']?></span>
                                        </div>
                                        <span class="text-sm text-jacarta-400 dark:text-jacarta-300">Current
                                            Price</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Countdown -->
                            <div
                                class="mt-4 dark:border-jacarta-600 sm:mt-0 sm:w-1/2 sm:border-l sm:border-jacarta-100 sm:pl-4 lg:pl-8">
                                <span
                                    class="js-countdown-ends-label text-sm text-jacarta-400 dark:text-jacarta-300">Auction
                                    ends in</span>
                                <div class="js-countdown-single-timer mt-3 flex space-x-4"
                                    data-countdown="2023-01-07T19:40:30" data-expired="This auction has ended">
                                    <span class="countdown-days text-jacarta-700 dark:text-white">
                                        <span
                                            class="js-countdown-days-number text-lg font-medium lg:text-[1.5rem]"><?= $nfts['createdAt']?></span>

                                    </span>

                                </div>
                            </div>
                        </div>

<?php if( isset($_SESSION['nftwallet']) && !empty($_SESSION['nftwallet']) && $nfts['username'] == userSession('username') )
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
  ':username'=>$_SESSION['nftwallet']
]);
$users = $stmt->fetch(PDO::FETCH_ASSOC);
?>

                        <a href="edit-nft?id=<?= $nfts['asset'] ?>"
                            class="inline-block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">Edit
                            NFT </a>

                             <br>

                        <br>
                            
                            <a href="delete-nft?id=<?= $nfts['nft_id'] ?>"
                            class="inline-block w-full rounded-full bg-primary py-3 px-8 text-center font-semibold text-accent shadow-accent-volume transition-all hover:bg-primary-dark">Delete
                            NFT </a>


                        <?php }else{ ?>

                        <?php 
                        if ($nfts['nft_status'] == 'hold' or $nfts['nft_status'] == 'sold'){
                        
                        ?>
                        <a href="#" disabled
                            class="inline-block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">Not
                            Available </a>

                        <?php
                        }else{
                        ?>
                         <?php if( isset($_SESSION['nftwallet']) && !empty($_SESSION['nftwallet']) )
{
?>
<a href="#" data-bs-toggle="modal" data-bs-target="#buyNowModal"
                            class="inline-block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">Add
                            to cart </a>
                        <br>

                        <br>


                        <!--<a href="#" data-bs-toggle="modal" data-bs-target="#placeBidModal"-->
                        <!--    class="inline-block w-full rounded-full bg-primary py-3 px-8 text-center font-semibold text-accent shadow-accent-volume transition-all hover:bg-primary-dark">Make-->
                        <!--    offer </a>-->
                            <?php }else{ ?>
                            
                            <a href="login" 
                            class="inline-block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">Add
                            to cart </a>
                        <br>

                        <br>


                        <!--<a href="login" -->
                        <!--    class="inline-block w-full rounded-full bg-primary py-3 px-8 text-center font-semibold text-accent shadow-accent-volume transition-all hover:bg-primary-dark">Make-->
                        <!--    offer </a>-->

                            <?php } ?>
                        

                        <?php
                        }
                        ?>

                        <?php } ?>



                    </div>
                    <!-- end bid -->
                </div>
                <!-- end details -->
            </div>

            <!-- Tabs -->
            <div class="scrollbar-custom mt-14 overflow-x-auto rounded-lg">
                <div class="min-w-fit">
                    <!-- Tabs Nav -->
                    <ul class="nav nav-tabs flex items-center" role="tablist">

                        <!-- Properties -->


                        <!-- Details -->
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link active relative flex items-center whitespace-nowrap py-3 px-6 text-jacarta-400 hover:text-jacarta-700 dark:hover:text-white"
                                id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab"
                                aria-controls="details" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                    class="mr-1 h-5 w-5 fill-current">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1zm-1-2V4H5v16h14zM7 6h4v4H7V6zm0 6h10v2H7v-2zm0 4h10v2H7v-2zm6-9h4v2h-4V7z" />
                                </svg>
                                <span class="font-display text-base font-medium">Details</span>
                            </button>
                        </li>

                        <!-- Activity -->
                        <!--<li class="nav-item" role="presentation">-->
                        <!--    <button-->
                        <!--        class="nav-link relative flex items-center whitespace-nowrap py-3 px-6 text-jacarta-400 hover:text-jacarta-700 dark:hover:text-white"-->
                        <!--        id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button"-->
                        <!--        role="tab" aria-controls="activity" aria-selected="false">-->
                        <!--        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"-->
                        <!--            class="mr-1 h-5 w-5 fill-current">-->
                        <!--            <path fill="none" d="M0 0h24v24H0z" />-->
                        <!--            <path-->
                        <!--                d="M11.95 7.95l-1.414 1.414L8 6.828 8 20H6V6.828L3.465 9.364 2.05 7.95 7 3l4.95 4.95zm10 8.1L17 21l-4.95-4.95 1.414-1.414 2.537 2.536L16 4h2v13.172l2.536-2.536 1.414 1.414z" />-->
                        <!--        </svg>-->
                        <!--        <span class="font-display text-base font-medium">Activity</span>-->
                        <!--    </button>-->
                        <!--</li>-->


                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">



                        <!-- Details -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            <div
                                class="rounded-t-2lg rounded-b-2lg rounded-tl-none border border-jacarta-100 bg-white p-6 dark:border-jacarta-600 dark:bg-jacarta-700 md:p-10">
                                <div class="mb-2 flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Contract Address:</span>
                                    <a href="<?= $nfts['link'] ?>" target="_blank" class="text-accent"><?= $nfts['asset']?> </a>
                                </div>
                                <div class="mb-2 flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Token ID:</span>
                                    <span
                                        class="js-copy-clipboard cursor-pointer select-none text-jacarta-700 dark:text-white"
                                        data-tippy-content="Copy">7714<?=$nfts['id'] ?></span>
                                </div>
                                <div class="mb-2 flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Token Standard:</span>
                                    <span class="text-jacarta-700 dark:text-white">ERC-721</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Blockchain:</span>
                                    <span class="text-jacarta-700 dark:text-white"><?= $nfts['payment_name']?></span>
                                </div>

                                <?php if( $nfts['metadata'] === "Frozen")
{
?>
                                <div class="flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Metadata:</span>
                                    <span class="text-jacarta-700 dark:text-white"><?= $nfts['metadata']?></span> &nbsp;
                                    <span class="inline-block"
                                        data-tippy-content="This item's metadata was permanently locked and stored in decentralized file storage on <?= $nfts['createdAt']?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="mb-[2px] h-5 w-5 fill-jacarta-500 dark:fill-jacarta-300">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z">
                                            </path>
                                        </svg>
                                    </span>
                                </div>

                                <?php }else{ ?>

                                <?php } ?>


                                <div class="flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Last updated:</span>
                                    <span class="text-jacarta-700 dark:text-white"><?=$nfts['updatetimedAt'] ?></span>
                                </div>


                                <div class="flex items-center">
                                    <span class="mr-2 min-w-[9rem] dark:text-jacarta-300">Creator Earnings:</span>
                                    <span class="text-jacarta-700 dark:text-white"><?=$settings['royalties'] ?>%</span>
                                </div>

                                <br>

                                <hr>
                                <br>

                                <p><?= $nfts['description']?></p>
                            </div>
                        </div>

                        <!-- Activity -->
                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">


                            <div role="table"
                                class="scrollbar-custom max-h-72 w-full overflow-y-auto rounded-lg rounded-tl-none border border-jacarta-100 bg-white text-sm dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white">
                                <div class="sticky top-0 flex bg-light-base dark:bg-jacarta-600" role="row">
                                    <div class="w-[17%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Event</span>
                                    </div>
                                    <div class="w-[17%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Price</span>
                                    </div>
                                    <div class="w-[22%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">From</span>
                                    </div>
                                    <div class="w-[22%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">To</span>
                                    </div>
                                    <div class="w-[22%] py-2 px-4" role="columnheader">
                                        <span
                                            class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Date</span>
                                    </div>
                                </div>
                                <div class="flex" role="row">
                                    <div class="flex w-[17%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24"
                                            class="mr-2 h-4 w-4 fill-jacarta-700 group-hover:fill-white dark:fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M14 20v2H2v-2h12zM14.586.686l7.778 7.778L20.95 9.88l-1.06-.354L17.413 12l5.657 5.657-1.414 1.414L16 13.414l-2.404 2.404.283 1.132-1.415 1.414-7.778-7.778 1.415-1.414 1.13.282 6.294-6.293-.353-1.06L14.586.686zm.707 3.536l-7.071 7.07 3.535 3.536 7.071-7.07-3.535-3.536z">
                                            </path>
                                        </svg>
                                        Bid
                                    </div>
                                    <div class="flex w-[17%] items-center whitespace-nowrap border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <span class="-ml-1" data-tippy-content="ETH">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                viewBox="0 0 1920 1920" xml:space="preserve" class="mr-1 h-4 w-4">
                                                <path fill="#8A92B2" d="M959.8 80.7L420.1 976.3 959.8 731z"></path>
                                                <path fill="#62688F"
                                                    d="M959.8 731L420.1 976.3l539.7 319.1zm539.8 245.3L959.8 80.7V731z">
                                                </path>
                                                <path fill="#454A75" d="M959.8 1295.4l539.8-319.1L959.8 731z"></path>
                                                <path fill="#8A92B2" d="M420.1 1078.7l539.7 760.6v-441.7z"></path>
                                                <path fill="#62688F" d="M959.8 1397.6v441.7l540.1-760.6z"></path>
                                            </svg>
                                        </span>
                                        <span class="text-sm font-medium tracking-tight text-green">30 ETH</span>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">AD496A</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">Polymorph: MORPH Token</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="#" class="flex flex-wrap items-center text-accent" target="_blank"
                                            rel="nofollow noopener" title="Opens in a  window"
                                            data-tippy-content="March 13 2022, 2:32 pm">
                                            <span class="mr-1">19 days ago</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24" class="h-4 w-4 fill-current">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M10 6v2H5v11h11v-5h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6zm11-3v8h-2V6.413l-7.793 7.794-1.414-1.414L17.585 5H13V3h8z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex" role="row">
                                    <div class="flex w-[17%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24"
                                            class="mr-2 h-4 w-4 fill-jacarta-700 group-hover:fill-white dark:fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M16.05 12.05L21 17l-4.95 4.95-1.414-1.414 2.536-2.537L4 18v-2h13.172l-2.536-2.536 1.414-1.414zm-8.1-10l1.414 1.414L6.828 6 20 6v2H6.828l2.536 2.536L7.95 11.95 3 7l4.95-4.95z">
                                            </path>
                                        </svg>
                                        Transfer
                                    </div>
                                    <div class="flex w-[17%] items-center whitespace-nowrap border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <span class="-ml-1" data-tippy-content="ETH">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                viewBox="0 0 1920 1920" xml:space="preserve" class="mr-1 h-4 w-4">
                                                <path fill="#8A92B2" d="M959.8 80.7L420.1 976.3 959.8 731z"></path>
                                                <path fill="#62688F"
                                                    d="M959.8 731L420.1 976.3l539.7 319.1zm539.8 245.3L959.8 80.7V731z">
                                                </path>
                                                <path fill="#454A75" d="M959.8 1295.4l539.8-319.1L959.8 731z"></path>
                                                <path fill="#8A92B2" d="M420.1 1078.7l539.7 760.6v-441.7z"></path>
                                                <path fill="#62688F" d="M959.8 1397.6v441.7l540.1-760.6z"></path>
                                            </svg>
                                        </span>
                                        <span class="text-sm font-medium tracking-tight text-green">.00510 ETH</span>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">The_vikk</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">Polymorph: MORPH Token</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <span class="mr-1 dark:text-jacarta-300">16 days ago</span>
                                    </div>
                                </div>
                                <div class="flex" role="row">
                                    <div class="flex w-[17%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24"
                                            class="mr-2 h-4 w-4 fill-jacarta-700 group-hover:fill-white dark:fill-white">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path
                                                d="M6.5 2h11a1 1 0 0 1 .8.4L21 6v15a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6l2.7-3.6a1 1 0 0 1 .8-.4zM19 8H5v12h14V8zm-.5-2L17 4H7L5.5 6h13zM9 10v2a3 3 0 0 0 6 0v-2h2v2a5 5 0 0 1-10 0v-2h2z">
                                            </path>
                                        </svg>
                                        Sale
                                    </div>
                                    <div class="flex w-[17%] items-center whitespace-nowrap border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <span class="-ml-1" data-tippy-content="ETH">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                viewBox="0 0 1920 1920" xml:space="preserve" class="mr-1 h-4 w-4">
                                                <path fill="#8A92B2" d="M959.8 80.7L420.1 976.3 959.8 731z"></path>
                                                <path fill="#62688F"
                                                    d="M959.8 731L420.1 976.3l539.7 319.1zm539.8 245.3L959.8 80.7V731z">
                                                </path>
                                                <path fill="#454A75" d="M959.8 1295.4l539.8-319.1L959.8 731z"></path>
                                                <path fill="#8A92B2" d="M420.1 1078.7l539.7 760.6v-441.7z"></path>
                                                <path fill="#62688F" d="M959.8 1397.6v441.7l540.1-760.6z"></path>
                                            </svg>
                                        </span>
                                        <span class="text-sm font-medium tracking-tight text-green">1.50 ETH</span>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">CryptoGuysNFT</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="user.html" class="text-accent">Polymorph: MORPH Token</a>
                                    </div>
                                    <div class="flex w-[22%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                                        role="cell">
                                        <a href="#" class="flex flex-wrap items-center text-accent" target="_blank"
                                            rel="nofollow noopener" title="Opens in a  window"
                                            data-tippy-content="March 13 2022, 2:32 pm">
                                            <span class="mr-1">19 days ago</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24" class="h-4 w-4 fill-current">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M10 6v2H5v11h11v-5h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6zm11-3v8h-2V6.413l-7.793 7.794-1.414-1.414L17.585 5H13V3h8z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- end tab content -->
                </div>
            </div>
            <!-- end tabs -->
        </div>
    </section>
    <!-- end item -->

    <!-- Related -->
    <section class="bg-light-base py-24 dark:bg-jacarta-800">
        <div class="container">
            <h2 class="mb-8 text-center font-display text-3xl text-jacarta-700 dark:text-white">
                More from this collection
            </h2>

            <div class="relative">
                <!-- Slider -->
                <div class="swiper card-slider-4-columns !py-5">
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
                                        INNER JOIN users ON nfts.username=users.username WHERE nft_status='active' ORDER BY RAND()
                                        LIMIT 8");
                                        $stmt->execute();
                                        while($related = $stmt->fetch()){
                                ?>

                        <div class="swiper-slide">
                            <article>
                                <div
                                    class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                                    <figure>
                                        <a href="asset?id=<?= $related['asset'] ?>">
                                            <img src="./assets/front/img/products/<?= $related['image'] ?>" alt="item 1"
                                                width="230" height="230" class="w-full rounded-[0.625rem]"
                                                loading="lazy" />
                                        </a>
                                    </figure>
                                    <div class="mt-4 flex items-center justify-between">
                                        <a href="asset?id=<?= $related['asset'] ?>">
                                            <span
                                                class="font-display text-base text-jacarta-700 hover:text-accent dark:text-white"><?= $related['nft_name'] ?></span>
                                        </a>
                                        <span
                                            class="flex items-center whitespace-nowrap rounded-md border border-jacarta-100 py-1 px-2 dark:border-jacarta-600">


                                            <span
                                                class="text-sm font-medium tracking-tight text-green"><?= $related['amount'] ?> <?=$related['short_name'] ?></span>
                                        </span>
                                    </div>

                                </div>
                            </article>
                        </div>

                        <?php
                                        }
                        ?>

                    </div>
                </div>

                <!-- Slider Navigation -->
                <div
                    class="swiper-button-prev group absolute top-1/2 -left-4 z-10 -mt-6 flex h-12 w-12 cursor-pointer items-center justify-center rounded-full bg-white p-3 text-base shadow-white-volume sm:-left-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        class="fill-jacarta-700 group-hover:fill-accent">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z" />
                    </svg>
                </div>
                <div
                    class="swiper-button-next group absolute top-1/2 -right-4 z-10 -mt-6 flex h-12 w-12 cursor-pointer items-center justify-center rounded-full bg-white p-3 text-base shadow-white-volume sm:-right-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        class="fill-jacarta-700 group-hover:fill-accent">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- end related -->




    <!-- Buy Now Modal -->
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
        <div class="modal-dialog max-w-2xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buyNowModalLabel">Complete checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            class="h-6 w-6 fill-jacarta-700 dark:fill-white">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <form method="POST">
                    <div class="modal-body p-6">
                        <div class="mb-2 flex items-center justify-between">
                            <span
                                class="font-display text-sm font-semibold text-jacarta-700 dark:text-white">Item</span>
                            <span
                                class="font-display text-sm font-semibold text-jacarta-700 dark:text-white">Subtotal</span>
                        </div>

                        <div
                            class="relative flex items-center border-t border-b border-jacarta-100 py-4 dark:border-jacarta-600">
                            <figure class="mr-5 self-start">
                                <img src="./assets/front/img/avatars/avatar_2.jpg" alt="avatar 2" class="rounded-2lg"
                                    loading="lazy" />
                            </figure>

                            <div>
                                <a href="collection.html" class="text-sm text-accent"><?= $nfts['nft_name'] ?></a>
                                <h3 class="mb-1 font-display text-base font-semibold text-jacarta-700 dark:text-white">
                                    @<?= $nfts['username'] ?>
                                </h3>
                                <div class="flex flex-wrap items-center">
                                    <span class="mr-1 block text-sm text-jacarta-500 dark:text-jacarta-300">Creator
                                        Earnings: <?=$settings['royalties'] ?>%</span>
                                    <span
                                        data-tippy-content="The creator of this collection will receive <?=$settings['royalties'] ?>% of the sale total from future sales of this item.">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" class="h-4 w-4 fill-jacarta-700 dark:fill-jacarta-300">
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path
                                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="ml-auto">
                                <span class="mb-1 flex items-center whitespace-nowrap">
                                    <span
                                        class="text-sm font-medium tracking-tight dark:text-jacarta-100"><?=$nfts['amount']?>
                                        <?=$nfts['short_name'] ?></span>
                                </span>
                                <div class="text-right text-sm dark:text-jacarta-300">Gas Fee:
                                    <?=$nfts['fee'] ?> <?=$nfts['short_name'] ?>

                                    
                                 

                     

                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div
                            class="mb-2 flex items-center justify-between border-b border-jacarta-100 py-2.5 dark:border-jacarta-600">
                            <span
                                class="font-display font-semibold text-jacarta-700 hover:text-accent dark:text-white">Total</span>
                            <div class="ml-auto">
                                <span class="flex items-center whitespace-nowrap">
                                    <span class="font-medium tracking-tight text-green"><?= $Totalamount; ?> <?=$nfts['short_name'] ?></span>
                                </span>

                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="mt-4 flex items-center space-x-2">
                            <input type="checkbox" required
                                class="h-5 w-5 self-start rounded border-jacarta-200 text-accent checked:bg-accent focus:ring-accent/20 focus:ring-offset-0 dark:border-jacarta-500 dark:bg-jacarta-600" />

                            <input name="amount" value="<?= $Totalamount; ?>" hidden />
                            <label for="buyNowTerms" class="text-sm dark:text-jacarta-200">By checking this box, I agree
                                to
                                Xhibiter's <a href="#" class="text-accent">Terms of Service</a></label>
                        </div>
                    </div>
                    <!-- end body -->

                    <div class="modal-footer">
                        <div class="flex items-center justify-center space-x-4">
                            <button type="submit" name="checkoutnft"
                                class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                                Confirm Checkout
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Place Bid Modal -->
    <div class="modal fade" id="placeBidModal" tabindex="-1" aria-labelledby="placeBidLabel" aria-hidden="true">
        <div class="modal-dialog max-w-2xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="placeBidLabel">Place a bid</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            class="h-6 w-6 fill-jacarta-700 dark:fill-white">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body p-6">
                    <div class="mb-2 flex items-center justify-between">
                        <span class="font-display text-sm font-semibold text-jacarta-700 dark:text-white">Price</span>
                    </div>

                    <div
                        class="relative mb-2 flex items-center overflow-hidden rounded-lg border border-jacarta-100 dark:border-jacarta-600">
                        <div
                            class="flex flex-1 items-center self-stretch border-r border-jacarta-100 bg-jacarta-50 px-2">
                            <span>
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                    viewBox="0 0 1920 1920" xml:space="preserve" class="mr-1 h-5 w-5">
                                    <path fill="#8A92B2" d="M959.8 80.7L420.1 976.3 959.8 731z"></path>
                                    <path fill="#62688F"
                                        d="M959.8 731L420.1 976.3l539.7 319.1zm539.8 245.3L959.8 80.7V731z"></path>
                                    <path fill="#454A75" d="M959.8 1295.4l539.8-319.1L959.8 731z"></path>
                                    <path fill="#8A92B2" d="M420.1 1078.7l539.7 760.6v-441.7z"></path>
                                    <path fill="#62688F" d="M959.8 1397.6v441.7l540.1-760.6z"></path>
                                </svg>
                            </span>
                            <span class="font-display text-sm text-jacarta-700">ETH</span>
                        </div>

                        <input type="text" class="h-12 w-full flex-[3] border-0 focus:ring-inset focus:ring-accent"
                            placeholder="Amount" value="0.05" />

                        <div class="flex flex-1 justify-end self-stretch border-l border-jacarta-100 bg-jacarta-50">
                            <span class="self-center px-2 text-sm">$130.82</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="text-sm dark:text-jacarta-400">Balance: 0.0000 WETH</span>
                    </div>

                    <!-- Terms -->
                    <div class="mt-4 flex items-center space-x-2">
                        <input type="checkbox" id="terms"
                            class="h-5 w-5 self-start rounded border-jacarta-200 text-accent checked:bg-accent focus:ring-accent/20 focus:ring-offset-0 dark:border-jacarta-500 dark:bg-jacarta-600" />
                        <label for="terms" class="text-sm dark:text-jacarta-200">By checking this box, I agree to
                            Xhibiter's <a href="#" class="text-accent">Terms of Service</a></label>
                    </div>
                </div>
                <!-- end body -->

                <div class="modal-footer">
                    <div class="flex items-center justify-center space-x-4">
                        <button type="button"
                            class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                            Place Bid
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
  include_once("./layout/footer.php");

  ?>