<?php
$PageTitle = "NFT Marketplace";
include("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT'] . "/include/notified.php");

?>

<main>
    <!-- Hero -->
    <section class="relative pb-10 pt-20 md:pt-32 lg:h-[88vh]">
        <picture class="pointer-events-none absolute inset-x-0 top-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient.jpg" alt="gradient" />
        </picture>
        <picture class="pointer-events-none absolute inset-x-0 top-0 -z-10 hidden dark:block">
            <img src="./assets/front/img/gradient_dark.jpg" alt="gradient dark" />
        </picture>

        <div class="container h-full">
            <div class="grid h-full items-center gap-4 md:grid-cols-12">
                <div
                    class="col-span-6 flex h-full flex-col items-center justify-center py-10 md:items-start md:py-20 xl:col-span-4">
                    <h1
                        class="mb-6 text-center font-display text-5xl text-jacarta-700 dark:text-white md:text-left lg:text-6xl xl:text-7xl">
                        Buy, sell and collect NFTs.
                    </h1>
                    <p class="mb-8 text-center text-lg dark:text-jacarta-200 md:text-left">
                        The world's largest digital marketplace for crypto collectibles and non-fungible tokens
                    </p>
                    <a href="my-profile"
                        class="w-36 rounded-full bg-white py-3 px-8 text-center font-semibold text-accent shadow-white-volume transition-all hover:bg-accent-dark hover:text-white hover:shadow-accent-volume">
                        Profile
                    </a><br>
                    <div class="flex space-x-4">
                        <a href="create"
                            class="w-36 rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                            Upload
                        </a>
                        <a href="collections"
                            class="w-36 rounded-full bg-white py-3 px-8 text-center font-semibold text-accent shadow-white-volume transition-all hover:bg-accent-dark hover:text-white hover:shadow-accent-volume">
                            Explore
                        </a>

                    </div>
                </div>

                <!-- Hero image -->
                <div class="col-span-6 xl:col-span-8">
                    <div class="relative text-center md:pl-8 md:text-right">
                        <svg viewbox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"
                            class="mt-8 inline-block w-72 rotate-[8deg] sm:w-full lg:w-[24rem] xl:w-[35rem]">
                            <defs>
                                <clipPath id="clipping" clipPathUnits="userSpaceOnUse">
                                    <path d="
                    M 0, 100
                    C 0, 17.000000000000004 17.000000000000004, 0 100, 0
                    S 200, 17.000000000000004 200, 100
                        183, 200 100, 200
                        0, 183 0, 100
                " fill="#9446ED"></path>
                                </clipPath>
                            </defs>
                            <g clip-path="url(#clipping)">
                                <!-- Bg image -->
                                <image href="./assets/front/img/hero/hero.jpg" width="200" height="200"
                                    clip-path="url(#clipping)" />
                            </g>
                        </svg>
                        <img src="./assets/front/img/hero/3D_elements.png" alt=""
                            class="absolute top-0 animate-fly md:-right-[10%]" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end hero -->

    <br><br>
    <!-- Browse by Category -->
    <section class="py-24">
        <h2 class="mb-8 text-center font-display text-3xl text-jacarta-700 dark:text-white">Browse by category</h2>

        <!-- Slider -->
        <div class="relative">
            <div class="swiper centered-slider !pb-5">
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <?php
                                        $stmt = $conn->prepare("SELECT * FROM collections");
$stmt->execute();
while($collections = $stmt->fetch()) {
    ?>
                    <div class="swiper-slide">
                        <article>
                            <a href="collections?id=<?= $collections['col_id'] ?>"
                                class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                                <figure class="rounded-t-[0.625rem] bg-green">
                                    <img src="./assets/front/img/categories/<?= $collections['image'] ?>"
                                        alt="<?= $collections['col_name'] ?>" class="w-full rounded-[0.625rem]"
                                        loading="lazy" />
                                </figure>
                                <div class="mt-4 text-center">
                                    <span
                                        class="font-display text-lg text-jacarta-700 dark:text-white"><?= $collections['col_name'] ?></span>
                                </div>
                            </a>
                        </article>
                    </div>

                    <?php
}
?>
                </div>
            </div>
        </div>
    </section>
    <!-- end browse by category -->


    <!-- Trending Categories -->
    <section class="py-24">
        <div class="container">
            <h2 class="mb-8 text-center font-display text-3xl text-jacarta-700 dark:text-white">
                <span class="mr-1 inline-block h-6 w-6 bg-contain bg-center text-xl" style="
                background-image: url(https://cdn.jsdelivr.net/npm/emoji-datasource-apple@7.0.2/img/apple/64/26a1.png);
              "></span>
                Recent NFT Items
            </h2>



            <!-- Grid -->
            <div class="grid grid-cols-1 gap-[1.875rem] md:grid-cols-2 lg:grid-cols-4">
                <?php
                   // $stmt = $conn->prepare("SELECT * FROM nfts LIMIT 12");
                    // $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN payment ON nfts.payment_id=payment.payment_id
                    //        INNER JOIN users ON nfts.username=users.username WHERE nft_status='active' or nft_status='sale' LIMIT 12 ");
                        $stmt = $conn->prepare("SELECT * FROM nfts INNER JOIN users ON nfts.username=users.username WHERE nft_status='active' or nft_status='sale' LIMIT 12 ");



$stmt->execute();
while($nfts = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
                <article>
                    <div
                        class="block rounded-2.5xl border border-jacarta-100 bg-white p-[1.1875rem] transition-shadow hover:shadow-lg dark:border-jacarta-700 dark:bg-jacarta-700">
                        <figure class="relative">
                            <a href="asset?id=<?= $nfts['asset'] ?>">
                                <img src="./assets/front/img/products/<?= $nfts['image'] ?>" width="150" height="100"
                                    alt="<?= $nfts['nft_name'] ?>" class="w-full rounded-[0.625rem]" loading="lazy" />
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
                            <a href="asset?id=<?= $nfts['asset'] ?>">
                                <span
                                    class="font-display text-base text-jacarta-700 hover:text-accent dark:text-white"><?= $nfts['nft_name'] ?></span>
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
                            <span class="mr-1 text-jacarta-700 dark:text-jacarta-200">From <?= $nfts['amount']?>
                                <?=$nfts['short_name']?></span>
                            <span
                                class="text-jacarta-500 dark:text-jacarta-300"><?=$nfts['minted'] ?>/<?=$nfts['level'] ?></span>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-sm font-medium tracking-tight">
                            <div class="flex flex-wrap items-center">
                                <!--<a href="user?id=<?= $nfts['username'] ?>" class="mr-2 shrink-0">-->
                                <!--    <img src="./assets/front/img/uploads/<?= $nfts['avatar'] ?>" alt="owner"-->
                                <!--        class="h-5 w-5 rounded-full" />-->
                                <!--</a>-->
                                <span class="mr-1 dark:text-jacarta-400">Creator: </span>
                                <a href="user?id=<?= $nfts['username'] ?>" class="text-accent">
                                    <span><?= $nfts['username'] ?></span>
                                </a>
                            </div>



                            <!--<span class="text-sm dark:text-jacarta-300"><?= $nfts['nft_status'] ?></span>-->
                        </div>
                    </div>
                </article>

                <?php
}
?>
            </div>
        </div>
    </section>
    <!-- end trending categories -->

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

            <!--<p class="mx-auto mt-20 max-w-2xl text-center text-lg text-jacarta-700 dark:text-white">-->
            <!--    Join our mailing list to stay in the loop with our newest feature releases, NFT drops, and tips and-->
            <!--    tricks-->
            <!--    for navigating Xhibiter-->
            <!--</p>-->

            <!--<div class="mx-auto mt-7 max-w-md text-center">-->
            <!--    <form class="relative">-->
            <!--        <input type="email" placeholder="Email address"-->
            <!--            class="w-full rounded-full border border-jacarta-100 py-3 px-4 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder-white" />-->
            <!--        <button-->
            <!--            class="absolute top-2 right-2 rounded-full bg-accent px-6 py-2 font-display text-sm text-white hover:bg-accent-dark">-->
            <!--            Subscribe-->
            <!--        </button>-->
            <!--    </form>-->
            <!--</div>-->
        </div>
    </section>
    <!-- end process / newsletter -->



    <?php
  include("./layout/footer.php");

?>
