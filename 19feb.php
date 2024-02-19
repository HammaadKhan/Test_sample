<?php

$PageTitle = "My Profile";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");


if(!$_SESSION['nftwallet']) {
    header("location:./login");
    die;
}

// if(@!$_COOKIE['firstVisit']){
//     setcookie("firstVisit", "no", time() + 3600);
//     toast_alert('success', 'Hi '.$users['username']."!", 'Welcome Back');
// }


$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
    'username'=>$_SESSION['nftwallet']
]);
$userss = $stmt->fetch(PDO::FETCH_ASSOC);
// $Verified = VerifiedStatus($users);





?>

<main class="pt-[5.5rem] lg:pt-24">
    <!-- Banner -->
    <div class="relative">
        <!-- <img src="./assets/front/img/uploads/<?= $userss['user_cover'] ?>" alt="banner"
            class="h-[18.75rem] object-cover" /> -->
            <img src="./assets/front/img/uploads/banner.jpg" alt="banner"
            class="h-[18.75rem] object-cover" width="100%"/>

            
        
    </div>
    <!-- end banner -->

    <!-- Profile -->
    <section class="relative bg-light-base pb-12 pt-20 dark:bg-jacarta-800">
        <!-- Avatar -->
        <div class="absolute  top-0 z-10 flex -translate-x-1/2 -translate-y-1/2 items-center justify-center" style='margin-left:6.60rem;'>
            <figure class="relative">
                
                <img src="./assets/front/img/uploads/<?= $userss['avatar'] ?>" alt="Click Edit Profile to set your avatar" 
                    class=" border-[5px] border-white dark:border-jacarta-600" width="150" style=" border-radius: 50%;" />
            </figure>
        </div>
        <div style='margin-left: 2.2rem;margin-bottom: 2rem;'>
         <h2 class="mb-2 font-display text-4xl font-medium text-jacarta-700 dark:text-white">
                    <?=$userss['username'] ?></h2>
                      <p class="mx-auto mb-2 max-w-xl text-lg dark:text-jacarta-300">
                   
                    
                                                         <?php
                                                        if(empty($userss['bio'])) {
                                                            echo "<p>No Bio Available</p>"
                                                        ?>
                                                        <?php
                                                        }
                                                        ?> 
                                                        
                                                         <?= $userss['bio'];?> 
                                                        
                                                        </p>
                <span class="text-jacarta-400">Joined <?=$userss['createdAt'];?></span>
                    </div>
        <div class="container">
            <div class="text-center">
                <!--<h2 class="mb-2 font-display text-4xl font-medium text-jacarta-700 dark:text-white">-->
                <!--    <?=$userss['username'] ?></h2>-->
                     <div class="profile-stats">
                <h1 class="text-2xl font-bold text-left mx-4 py-1"></h1>
                <div style="background-color: #000; border-radius: 15px;" class="bg-green-500 p-5 rounded-[15px]">
                    <div class=" grid justify-between grid-flow-row grid-flow-col">
                        <div>
                            <p class="text-white text-xl">
                                Available Balance
                            </p>
                        </div>
                        <div
                            class="mb-8 inline-flex items-center justify-center rounded-full border border-jacarta-100 bg-white py-1.5 px-4 dark:border-jacarta-600 dark:bg-jacarta-700">
                            <span data-tippy-content="ETH">
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
                      <!---      <button
                                class="js-copy-clipboard max-w-[10rem] select-none overflow-hidden text-ellipsis whitespace-nowrap dark:text-jacarta-200"
                                data-tippy-content="Copy">
                                <span>
                                    //   <?php
                                    //                     if(empty($userss['address'])) {
                                    //                         echo "<p>Connect Wallet First</p>"
                                    //                     ?>
                                    //                     <?php
                                    //                     }
                                    //                     ?> 
                                                        
                                    //                      <?= $userss['address']?>
                                </span>
                            </button>--->
                        </div>
                        
                    </div>
                    <div class=" grid justify-between grid-flow-row grid-flow-col">
                        <div class="text-white text-xl">
                           USD <?= $users['balance']?> <?= $paymentnft['short_name'] ?>
                        </div>
                        <div>
                            <a href="./wallet">
                            <button style="background-color: #4e4f54;
    --tw-shadow: 5px 5px 10px #,inset 2px 2px 6px #4e4f54,inset -5px -5px 10px #;"
                                class="block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                                + Fund Wallet
                            </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-2 my-2 flex justify-between items-center">
                    <a href="./create">
                    <button
                        class="block rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark" style="background-color: #4e4f54;
    --tw-shadow: 5px 5px 10px #4e4f54,inset 2px 2px 6px #,inset -5px -5px 10px #;">
                        Create NFT
                    </button>
                    </a>
                    <button
                        class="block rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark" style="background-color: #4e4f54;
    --tw-shadow: 5px 5px 10px #4e4f54,inset 2px 2px 6px #,inset -5px -5px 10px #;">
                        Create Collection
                    </button>
                </div>
            </div>
              
                <!--<span class="text-jacarta-400">Joined <?=$userss['createdAt'];?></span>-->
<br>
<!--Balance:<br>-->
<!--<span class="text-lg font-bold text-green">-->
                                        <?// $users['balance']?> <?// $paymentnft['short_name'] ?>  <!-- </span> -->


  <!--<a href="./create"-->
  <!--                      class="block w-full rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark" style="background-color: #4e4f54;-->
  <!--  --tw-shadow: 5px 5px 10px #4e4f54,inset 2px 2px 6px #,inset -5px -5px 10px #;">-->
  <!--                      Upload NFTs-->
  <!--                  </a>-->
                    <br>

                    <a href="./collections"
                        class="block w-full rounded-full bg-red py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-red-dark" style="background-color: #4e4f54;
    --tw-shadow: 5px 5px 10px #,inset 2px 2px 6px #4e4f54,inset -5px -5px 10px #;">
                        Explore Our NFTs
                    </a>



            </div>
        </div>
    </section>
    <!-- end profile -->

    <!-- Collection -->
    <section class="relative py-24 pt-20">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <!-- Tabs Nav -->
            <ul class="nav nav-tabs scrollbar-custom mb-12 flex items-center justify-start overflow-x-auto overflow-y-hidden border-b border-jacarta-100 pb-px dark:border-jacarta-600 md:justify-center"
                role="tablist">
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link active relative flex items-center whitespace-nowrap py-3 px-6 text-jacarta-400 hover:text-jacarta-700 dark:hover:text-white"
                        id="on-sale-tab" data-bs-toggle="tab" data-bs-target="#on-sale" type="button" role="tab"
                        aria-controls="on-sale" aria-selected="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            class="mr-1 h-5 w-5 fill-current">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm1 2v14h16V5H4zm4.5 9H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z" />
                        </svg>
                        <?php 


        
                        $result = $conn->prepare("SELECT count(*) FROM nfts WHERE username=:username"); 
                        $result->execute([
                            ':username'=>$_SESSION['nftwallet']
                        ]);
                        $allnfts = $result->fetchColumn(); 
        
                        ?>
                        <span class="font-display text-base font-medium">Created (<?= $allnfts ?>)</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link relative flex items-center whitespace-nowrap py-3 px-6 text-jacarta-400 hover:text-jacarta-700 dark:hover:text-white"
                        id="owned-tab" data-bs-toggle="tab" data-bs-target="#owned" type="button" role="tab"
                        aria-controls="owned" aria-selected="false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            class="mr-1 h-5 w-5 fill-current">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12.414 5H21a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2zM4 5v14h16V7h-8.414l-2-2H4zm9 8h3l-4 4-4-4h3V9h2v4z" />
                        </svg>

                        <?php 

                            $result = $conn->prepare("SELECT count(*) FROM nfts WHERE username=:username and nft_status='sold' order by nfts.asset"); 
                            $result->execute([
                                ':username'=>$_SESSION['nftwallet']
                            ]);
                            $number_sold = $result->fetchColumn(); 
                        
                        ?>

                        <span class="font-display text-base font-medium">Sold (<?= $number_sold ?>)</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link relative flex items-center whitespace-nowrap py-3 px-6 text-jacarta-400 hover:text-jacarta-700 dark:hover:text-white"
                        id="created-tab" data-bs-toggle="tab" data-bs-target="#created" type="button" role="tab"
                        aria-controls="created" aria-selected="false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            class="mr-1 h-5 w-5 fill-current">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M5 5v3h14V5H5zM4 3h16a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm2 9h6a1 1 0 0 1 1 1v3h1v6h-4v-6h1v-2H5a1 1 0 0 1-1-1v-2h2v1zm11.732 1.732l1.768-1.768 1.768 1.768a2.5 2.5 0 1 1-3.536 0z" />
                        </svg>


                        <?php 
                            $result = $conn->prepare("SELECT count(*) FROM nfts WHERE username=:username and nft_status='sale' order by nfts.asset"); 
                            $result->execute([
                                ':username'=>$_SESSION['nftwallet']
                            ]);
                            $number_of_rows = $result->fetchColumn();
                        ?>
                        <span class="font-display text-base font-medium">On Sale (<?= $number_of_rows ?>)</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- On Sale Tab -->
                <div class="tab-pane fade show active" id="on-sale" role="tabpanel" aria-labelledby="on-sale-tab">

                    <!-- Grid -->
                    <div class="grid grid-cols-1 gap-[1.875rem] md:grid-cols-2 lg:grid-cols-4">
                        <?php
                                

                                $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id WHERE username=:username order by nfts.asset DESC LIMIT 24");
                            
                                                       
                            
                                $stmt->execute([
                                    'username'=>$_SESSION['nftwallet']
                                ]);

                              

                                        while($nfts = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                        <article>
                            <div
                                class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                                <figure class="relative">
                                    <a href="asset?id=<?= $nfts['asset'] ?>">
                                        <img src="./assets/front/img/products/<?= $nfts['image'] ?>"
                                            alt="<?= $nfts['nft_name'] ?>" class="w-full rounded-[0.625rem]"
                                            loading="lazy" />
                                    </a>
                                    <div
                                        class="absolute top-3 right-3 flex items-center space-x-1 rounded-md bg-white p-2 dark:bg-jacarta-700">
                                        <span
                                            class="js-likes relative cursor-pointer before:absolute before:h-4 before:w-4 before:bg-[url('../img/heart-fill.svg')] before:bg-cover before:bg-center before:bg-no-repeat before:opacity-0"
                                            data-tippy-content="Favorite">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24"
                                                class="h-4 w-4 fill-jacarta-500 hover:fill-red dark:fill-jacarta-200 dark:hover:fill-red">
                                                <path fill="none" d="M0 0H24V24H0z" />
                                                <path
                                                    d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z" />
                                            </svg>
                                        </span>
                                        <span class="text-sm dark:text-jacarta-200">15</span>
                                    </div>
                                </figure>
                                <div class="mt-7 flex items-center justify-between">
                                    <a href="asset?id=<?= $nfts['asset'] ?>">
                                        <span
                                            class="font-display text-base text-jacarta-700 hover:text-accent dark:text-white"><?= $nfts['nft_name'] ?></span>
                                    </a>
                                    <div class="dropup rounded-full hover:bg-jacarta-100 dark:hover:bg-jacarta-600">
                                        <a href="#"
                                            class="dropdown-toggle inline-flex h-8 w-8 items-center justify-center text-sm"
                                            role="button" id="itemActions" data-bs-toggle="dropdown"
                                            aria-expanded="false">
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
                                            <!-- <button
                                                                    class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                                                    New bid
                                                                </button>
                                                                <hr class="my-2 mx-4 h-px border-0 bg-jacarta-100 dark:bg-jacarta-600" />
                                                                <button
                                                                    class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                                                    Refresh Metadata
                                                                </button> -->
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
                                    <span class="mr-1 text-jacarta-700 dark:text-jacarta-200">From
                                        <?= $nfts['amount']?> <?=$nfts['short_name']?></span>
                                    <span
                                        class="text-jacarta-500 dark:text-jacarta-300"><?=$nfts['minted'] ?>/<?=$nfts['level'] ?></span>
                                </div>

                                <?php if($nfts['nft_status'] === 'hold' )
{
?>
                     <span class="text-sm dark:text-jacarta-300">Pending <?=$nfts['fee'] ?> <?=$nfts['short_name']?> Gas Fee</span>
                     <br>
                     <br>
                     <a href="./pay-gasfee.php?id=<?= $nfts['asset'] ?>" class="btn btn-primary rounded-full bg-accent py-3 px-8 font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark" >Pay <?=$nfts['fee'] ?> <?=$nfts['short_name']?> Now</a>

                    <?php }else{ ?>

                    

                    <?php } ?>

                            </div>
                        </article>

                        <?php
                                                                    }
                                            ?>
                    </div>
                    <!-- end grid -->
                </div>
                <!-- end on sale tab -->

                <!-- Owned Tab -->
                <div class="tab-pane fade" id="owned" role="tabpanel" aria-labelledby="owned-tab">

                    <!-- Grid -->
                    <div class="grid grid-cols-1 gap-[1.875rem] md:grid-cols-2 lg:grid-cols-4">
                        <?php
                                

                                $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id WHERE username=:username and nft_status='sold' order by nfts.asset DESC LIMIT 24");
        
                            
                                $stmt->execute([
                                    ':username'=>$_SESSION['nftwallet']
                                ]);
                                                                    while($nfts = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                        <article>
                            <div
                                class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                                <figure class="relative">
                                    <a href="#">
                                        <img src="./assets/front/img/products/<?= $nfts['image'] ?>" width="150px"
                                            height="100px" alt="<?= $nfts['nft_name'] ?>" class="w-full rounded-[0.625rem]"
                                            loading="lazy" />
                                    </a>
                                    <div
                                        class="absolute top-3 right-3 flex items-center space-x-1 rounded-md bg-white p-2 dark:bg-jacarta-700">
                                        <span
                                            class="js-likes relative cursor-pointer before:absolute before:h-4 before:w-4 before:bg-[url('../img/heart-fill.svg')] before:bg-cover before:bg-center before:bg-no-repeat before:opacity-0"
                                            data-tippy-content="Favorite">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24"
                                                class="h-4 w-4 fill-jacarta-500 hover:fill-red dark:fill-jacarta-200 dark:hover:fill-red">
                                                <path fill="none" d="M0 0H24V24H0z" />
                                                <path
                                                    d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z" />
                                            </svg>
                                        </span>
                                        <span class="text-sm dark:text-jacarta-200">15</span>
                                    </div>
                                </figure>
                                <div class="mt-7 flex items-center justify-between">
                                    <a href="#">
                                        <span
                                            class="font-display text-base text-jacarta-700 hover:text-accent dark:text-white"><?= $nfts['nft_name'] ?></span>
                                    </a>
                                    <div class="dropup rounded-full hover:bg-jacarta-100 dark:hover:bg-jacarta-600">
                                        <a href="#"
                                            class="dropdown-toggle inline-flex h-8 w-8 items-center justify-center text-sm"
                                            role="button" id="itemActions" data-bs-toggle="dropdown"
                                            aria-expanded="false">
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
                                            <!-- <button
                                                                    class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                                                    New bid
                                                                </button>
                                                                <hr class="my-2 mx-4 h-px border-0 bg-jacarta-100 dark:bg-jacarta-600" />
                                                                <button
                                                                    class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                                                    Refresh Metadata
                                                                </button> -->
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
                                    <span class="mr-1 text-jacarta-700 dark:text-jacarta-200">From
                                        <?= $nfts['amount']?> <?=$nfts['short_name']?></span>
                                    <span
                                        class="text-jacarta-500 dark:text-jacarta-300"><?=$nfts['minted'] ?>/<?=$nfts['level'] ?></span>
                                </div>

                            </div>
                        </article>

                        <?php
                                                                    }
                                            ?>
                    </div>
                    <!-- end grid -->
                </div>
                <!-- end owned tab -->

                <!-- Created Tab -->
                <div class="tab-pane fade" id="created" role="tabpanel" aria-labelledby="created-tab">

                    <!-- Grid -->
                    <div class="grid grid-cols-1 gap-[1.875rem] md:grid-cols-2 lg:grid-cols-4">
                        <?php
                                

                                $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id WHERE username=:username and nft_status='sale' order by nfts.asset DESC LIMIT 24");
        
                            
                           

    $stmt->execute([
        ':username'=>$_SESSION['nftwallet']
    ]);
                                        while($nfts = $stmt->fetch(PDO::FETCH_ASSOC)){
            ?>
                        <article>
                            <div
                                class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                                <figure class="relative">
                                    <a href="asset?id=<?= $nfts['asset'] ?>">
                                        <img src="./assets/front/img/products/<?= $nfts['image'] ?>" width="150px"
                                            height="100px" alt="<?= $nfts['nft_name'] ?>" class="w-full rounded-[0.625rem]"
                                            loading="lazy" />
                                    </a>
                                    <div
                                        class="absolute top-3 right-3 flex items-center space-x-1 rounded-md bg-white p-2 dark:bg-jacarta-700">
                                        <span
                                            class="js-likes relative cursor-pointer before:absolute before:h-4 before:w-4 before:bg-[url('../img/heart-fill.svg')] before:bg-cover before:bg-center before:bg-no-repeat before:opacity-0"
                                            data-tippy-content="Favorite">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24"
                                                class="h-4 w-4 fill-jacarta-500 hover:fill-red dark:fill-jacarta-200 dark:hover:fill-red">
                                                <path fill="none" d="M0 0H24V24H0z" />
                                                <path
                                                    d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z" />
                                            </svg>
                                        </span>
                                        <span class="text-sm dark:text-jacarta-200">15</span>
                                    </div>
                                </figure>
                                <div class="mt-7 flex items-center justify-between">
                                    <a href="asset?id=<?= $nfts['asset'] ?>">
                                        <span
                                            class="font-display text-base text-jacarta-700 hover:text-accent dark:text-white"><?= $nfts['nft_name'] ?></span>
                                    </a>
                                    <div class="dropup rounded-full hover:bg-jacarta-100 dark:hover:bg-jacarta-600">
                                        <a href="#"
                                            class="dropdown-toggle inline-flex h-8 w-8 items-center justify-center text-sm"
                                            role="button" id="itemActions" data-bs-toggle="dropdown"
                                            aria-expanded="false">
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
                                            <!-- <button
                                        class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                        New bid
                                    </button>
                                    <hr class="my-2 mx-4 h-px border-0 bg-jacarta-100 dark:bg-jacarta-600" />
                                    <button
                                        class="block w-full rounded-xl px-5 py-2 text-left font-display text-sm transition-colors hover:bg-jacarta-50 dark:text-white dark:hover:bg-jacarta-600">
                                        Refresh Metadata
                                    </button> -->
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
                                    <span class="mr-1 text-jacarta-700 dark:text-jacarta-200">From
                                        <?= $nfts['amount']?> <?=$nfts['short_name']?></span>
                                    <span
                                        class="text-jacarta-500 dark:text-jacarta-300"><?=$nfts['minted'] ?>/<?=$nfts['level'] ?></span>
                                </div>

                            </div>
                        </article>

                        <?php
                                        }
                ?>
                    </div>
                    
                    <!-- end grid -->
                </div>
                <!-- end created tab -->


            </div>
        </div>
    </section>
    <!-- end collection -->

    <!-- Process / Newsletter -->
    <section class="relative py-24 dark:bg-jacarta-800">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h2 class="mb-16 text-center font-display text-3xl text-jacarta-700 dark:text-white">
                Create and sell your NFTs
            </h2>
            <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">
                <div class="text-center">
                    <div class="mb-6 inline-flex rounded-full bg-[#CDBCFF] p-3">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                class="h-5 w-5 fill-white">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M22 6h-7a6 6 0 1 0 0 12h7v2a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v2zm-7 2h8v8h-8a4 4 0 1 1 0-8zm0 3v2h3v-2h-3z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="mb-4 font-display text-lg text-jacarta-700 dark:text-white">1. Set up your wallet
                    </h3>
                    <p class="dark:text-jacarta-300">
                        Once you've set up your wallet of choice, connect it to OpenSeaby clicking the NFT
                        Marketplacein the top
                        right corner.
                    </p>
                </div>
                <div class="text-center">
                    <div class="mb-6 inline-flex rounded-full bg-[#C4F2E3] p-3">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-green">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                class="h-5 w-5 fill-white">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="mb-4 font-display text-lg text-jacarta-700 dark:text-white">2. Create Your Collection
                    </h3>
                    <p class="dark:text-jacarta-300">
                        Click Create and set up your collection. Add social links, a description, profile & banner
                        images, and
                        set a secondary sales fee.
                    </p>
                </div>
                <div class="text-center">
                    <div class="mb-6 inline-flex rounded-full bg-[#CDDFFB] p-3">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                class="h-5 w-5 fill-white">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M17.409 19c-.776-2.399-2.277-3.885-4.266-5.602A10.954 10.954 0 0 1 20 11V3h1.008c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H2.992A.993.993 0 0 1 2 20.007V3.993A1 1 0 0 1 2.992 3H6V1h2v4H4v7c5.22 0 9.662 2.462 11.313 7h2.096zM18 1v4h-8V3h6V1h2zm-1.5 9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="mb-4 font-display text-lg text-jacarta-700 dark:text-white">3. Add Your NFTs</h3>
                    <p class="dark:text-jacarta-300">
                        Upload your work (image, video, audio, or 3D art), add a title and description, and
                        customize your NFTs
                        with properties, stats.
                    </p>
                </div>
                <div class="text-center">
                    <div class="mb-6 inline-flex rounded-full bg-[#FFD0D0] p-3">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-red">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                class="h-5 w-5 fill-white">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M10.9 2.1l9.899 1.415 1.414 9.9-9.192 9.192a1 1 0 0 1-1.414 0l-9.9-9.9a1 1 0 0 1 0-1.414L10.9 2.1zm2.828 8.486a2 2 0 1 0 2.828-2.829 2 2 0 0 0-2.828 2.829z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="mb-4 font-display text-lg text-jacarta-700 dark:text-white">4. List Them For Sale
                    </h3>
                    <p class="dark:text-jacarta-300">
                        Choose between auctions, fixed-price listings, and declining-price listings. You choose how
                        you want to
                        sell your NFTs!
                    </p>
                </div>
            </div>


        </div>
    </section>
    <!-- end process / newsletter -->


    <?php
  include_once("./layout/footer.php");

  ?>