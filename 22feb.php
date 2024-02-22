<?php
$PageTitle = "Rankings";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

?>

<main>
    <!-- Rankings -->
    <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">Rankings
            </h1>

        

            <!-- Table -->
            <div class="scrollbar-custom overflow-x-auto">
                <div role="table"
                    class="w-full min-w-[736px] border border-jacarta-100 bg-white text-sm dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white lg:rounded-2lg">
                    <div class="flex rounded-t-2lg bg-jacarta-50 dark:bg-jacarta-600" role="row">
                        <div class="w-[28%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Collection</span>
                        </div>
                        <div class="w-[28%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Volume</span>
                        </div>
                        
                        <div class="w-[12%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Minted
                        </span>
                        </div>
                        <div class="w-[28%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Owners</span>
                        </div>
                        <div class="w-[12%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Last Updated</span>
                        </div>
                    </div>
                    <?php
                                        $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
                                        INNER JOIN users ON nfts.username=users.username WHERE nft_status='active' or nft_status='sale' ORDER BY RAND() LIMIT 40 ");
                                        $stmt->execute();
                                        $sn=1;
                                        while($rankings = $stmt->fetch()){
                                          //$number_of_rows = $result->fetchColumn(); 
                                ?>

                               

                    <a href="asset?id=<?= $rankings['asset'] ?>" class="flex transition-shadow hover:shadow-lg" role="row">
                        <div class="flex w-[28%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                            <span class="mr-2 lg:mr-4"><?= $sn++ ?></span>
                            <figure class="relative mr-2 w-8 shrink-0 self-start lg:mr-5 lg:w-12">
                                <img src="./assets/front/img/products/<?= $rankings['image'] ?>" alt="avatar 1" class="rounded-2lg"
                                    loading="lazy" />
                                <div class="absolute -right-2 -bottom-1 flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-green dark:border-jacarta-600"
                                    data-tippy-content="Verified Collection">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                        class="h-[.875rem] w-[.875rem] fill-white">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z">
                                        </path>
                                    </svg>
                                </div>
                            </figure>
                            <span class="font-display text-sm font-semibold text-jacarta-700 dark:text-white">
                            <?= $rankings['nft_name'] ?>
                            </span>
                        </div>
                        <div class="flex w-[28%] items-center whitespace-nowrap border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                           
                            <span class="text-red"><?= $rankings['amount'] ?> <?= $paymentnft['short_name'] ?></span>
                        </div>
                        
                        <div class="flex w-[12%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                            
                            <span class="text-sm font-medium tracking-tight"> <?= $rankings['minted'] ?> Mints</span>
                        </div>
                        <div class="flex w-[28%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                           

                            <span> @<?= $rankings['username'] ?></span>
                        </div>
                        <div class="flex w-[12%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                            <span><?= $rankings['updatetimedAt'] ?></span>
                        </div>
                    </a>
                  

                                <?php
                                }
                                ?>

                </div>
            </div>
        </div>
    </section>
    <!-- end rankings -->

    <?php
  include_once("./layout/footer.php");

  ?>