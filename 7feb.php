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