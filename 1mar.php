<?php
$PageTitle = "Transactions";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");


if(!$_SESSION['nftwallet']) {
  header("location:./login");
  die;
}


$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
  'username'=>$_SESSION['nftwallet']
]);
$users = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!-- <main> -->
    <!-- Rankings -->
    <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
        <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">My Transactions
            </h1>


  <!-- Table -->
            <div class="scrollbar-custom overflow-x-auto">
                <div role="table"
                    class="w-full min-w-[736px] border border-jacarta-100 bg-white text-sm dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white lg:rounded-2lg">
                    <div class="flex rounded-t-2lg bg-jacarta-50 dark:bg-jacarta-600" role="row">
                        <div class="w-[28%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Type</span>
                        </div>
                        <div class="w-[28%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Amount</span>
                        </div>
                        
                        <div class="w-[28%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Status</span>
                        </div>
                        <div class="w-[28%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">User</span>
                        </div>
                        <div class="w-[12%] py-3 px-4" role="columnheader">
                            <span
                                class="w-full overflow-hidden text-ellipsis text-jacarta-700 dark:text-jacarta-100">Date</span>
                        </div>
                    </div>

                    <?php

         $sql="SELECT * FROM wallet LEFT JOIN users ON wallet.username =users.username WHERE wallet.username =:username order by wallet.id DESC ";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':username'=>$_SESSION['nftwallet']
                ]);



                $sn=1;

                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $transStatus = transStatus($result);

                    
                

                    
                    ?>
                    <a href="support?id=<?= $result['refrence_id']?>" class="flex transition-shadow hover:shadow-lg" role="row">
                        <div class="flex w-[28%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                            <span class="mr-2 lg:mr-4"><?= $sn++ ?></span>
                            
                            <span class="font-display text-sm font-semibold text-jacarta-700 dark:text-white">
                            <?=$result['trans_type'] ?>
                            </span>
                        </div>
                        
                        <div class="flex w-[28%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                            <span class="text-red"><?= $result['amount'] ?> <?=$paymentnft['short_name'] ?></span>
                        </div>
                        <div class="flex w-[28%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                            <?= $transStatus ?>
                        </div>
                        
                        <div class="flex w-[28%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                            <span><?=$result['username'] ?></span>
                        </div>
                        <div class="flex w-[12%] items-center border-t border-jacarta-100 py-4 px-4 dark:border-jacarta-600"
                            role="cell">
                            <span><?=$result['createdAt'] ?></span>
                        </div>
                    </a>

                    <?php
                }
                ?>
                 
                </div>
            </div>


        </div>
    </section>


<?php
  include_once("./layout/footer.php");

  ?>


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









    <?php
$PageTitle = "Terms Of Service";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

?>

<main class="pt-[5.5rem] lg:pt-24">
    <!-- TOS -->
    <section class="relative py-16 dark:bg-jacarta-800 md:py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white">
                Terms Of Service
            </h1>
            <div class="article-content mx-auto max-w-[48.125rem]">
                <h2 class="text-base">Introduction</h2>
                <p>
                    These Terms of Service (“Terms”) govern your access to and use of the <?= $settings['web_name']?> website(s), our APIs,
                    mobile app (the “App”), and any other software, tools, features, or functionalities provided on or
                    in
                    connection with our services; including without limitation using our services to view, explore, and
                    create
                    NFTs and use our tools, at your own discretion, to connect directly with others to purchase, sell,
                    or
                    transfer NFTs on public blockchains (collectively, the “Service”). “NFT” in these Terms means a
                    non-fungible token or similar digital item implemented on a blockchain (such as the Ethereum
                    blockchain),
                    which uses smart contracts to link to or otherwise be associated with certain content or data. For
                    purposes of these Terms, “user”, “you”, and “your” means you as the user of the Service. If you use
                    the
                    Service on behalf of a company or other entity then “you” includes you and that entity, and you
                    represent
                    and warrant that (a) you are an authorized representative of the entity with the authority to bind
                    the
                    entity to these Terms, and (b) you agree to these Terms on the entity's behalf.
                </p>
                <p>
                    PLEASE READ THESE TERMS OF SERVICE CAREFULLY AS THEY CONTAIN IMPORTANT INFORMATION AND AFFECT YOUR
                    LEGAL
                    RIGHTS. AS OUTLINED IN SECTION 16 BELOW, THEY INCLUDE A MANDATORY ARBITRATION AGREEMENT AND CLASS
                    ACTION
                    WAIVER WHICH (WITH LIMITED EXCEPTIONS) REQUIRE ANY DISPUTES BETWEEN US TO BE RESOLVED THROUGH
                    INDIVIDUAL
                    ARBITRATION RATHER THAN BY A JUDGE OR JURY IN COURT.
                </p>
                <p>
                    BY CLICKING TO ACCEPT AND/OR USING OUR SERVICE, YOU AGREE TO BE BOUND BY THESE TERMS AND ALL OF THE
                    TERMS
                    INCORPORATED HEREIN BY REFERENCE. IF YOU DO NOT AGREE TO THESE TERMS, YOU MAY NOT ACCESS OR USE THE
                    SERVICE.
                </p>

                <p>
                    <?= $settings['web_name']?> is not a wallet provider, exchange, broker, financial institution, or creditor. <?= $settings['web_name']?>
                    provides
                    a peer-to-peer web3 service that helps users discover and directly interact with each other and NFTs
                    available on public blockchains. We do not have custody or control over the NFTs or blockchains you
                    are
                    interacting with and we do not execute or effectuate purchases, transfers, or sales of NFTs. To use
                    our
                    Service, you must use a third-party wallet which allows you to engage in transactions on
                    blockchains.
                </p>

                <p>
                    Because we have a growing number of services, we sometimes need to provide additional terms for
                    specific
                    services (and such services are deemed part of the “Service” hereunder and shall also be subject to
                    these
                    Terms). Those additional terms and conditions, which are available with the relevant service, then
                    become
                    part of your agreement with us if you use those services. In the event of a conflict between these
                    Terms
                    and any additional applicable terms we may provide for a specific service, such additional terms
                    shall
                    control for that specific service.
                </p>

                <h2>Ownership</h2>

                <p>
                    The Service, including its “look and feel” (e.g., text, graphics, images, logos, page headers,
                    button
                    icons, and scripts), proprietary content, information and other materials, and all content and other
                    materials contained therein, including, without limitation, the <?= $settings['web_name']?> logo and all designs, text,
                    graphics, pictures, data, software, sound files, other files, and the selection and arrangement
                    thereof
                    are the proprietary property of <?= $settings['web_name']?> or our affiliates, licensors, or users, as applicable, and
                    you
                    agree not to take any action(s) inconsistent with such ownership interests. We and our affiliates,
                    licensors, and users, as applicable, reserve all rights in connection with the Service and its
                    content,
                    including, without limitation, the exclusive right to create derivative works.
                </p>

                <h2>License to Access and Use Our Service and Content</h2>

                <p>
                    You are hereby granted a limited, nonexclusive, nontransferable, nonsublicensable, and personal
                    license to
                    access and use the Service provided, however, that such license is subject to your compliance with
                    these
                    Terms. If any software, content, or other materials owned by, controlled by, or licensed to us are
                    distributed or made available to you as part of your use of the Service, we hereby grant you a
                    non-commercial, personal, non-assignable, non-sublicensable, non-transferrable, and non-exclusive
                    right
                    and license to access and display such software, content, and materials provided to you as part of
                    the
                    Service (and right to download a single copy of the App onto your applicable equipment or device),
                    in each
                    case for the sole purpose of enabling you to use the Service as permitted by these Terms, provided
                    that
                    your license in any content linked to or associated with any NFTs is solely as set forth by the
                    applicable
                    seller or creator of such NFT.
                </p>

                <h2>Intellectual Property Rights</h2>

                <p>
                    You are solely responsible for your use of the Service and for any information you provide,
                    including
                    compliance with applicable laws, rules, and regulations, as well as these Terms, including the User
                    Conduct requirements outlined above.
                </p>

                <p>
                    By using the Service in conjunction with creating, submitting, posting, promoting, or displaying
                    content,
                    or by complying with OpenSea's metadata standards in your metadata API responses, you grant us a
                    worldwide, non-exclusive, sublicensable, royalty-free license to use, copy, modify, and display any
                    content, including but not limited to text, materials, images, files, communications, comments,
                    feedback,
                    suggestions, ideas, concepts, questions, data, or otherwise, that you submit or post on or through
                    the
                    Service for our current and future business purposes, including to provide, promote, and improve the
                    Service. This includes any digital file, art, or other material linked to or associated with any
                    NFTs that
                    are displayed on the Service.
                </p>

                <h2>Miscellaneous</h2>

                <p>
                    These Terms constitute the entire agreement between you and <?= $settings['web_name']?> relating to your access to and
                    use of
                    the Service. These Terms, and any rights and licenses granted hereunder, may not be transferred or
                    assigned by you without the prior written consent of <?= $settings['web_name']?>, and <?= $settings['web_name']?>’s failure to assert any
                    right
                    or provision under these Terms shall not constitute a waiver of such right or provision. No waiver
                    by
                    either party of any breach or default hereunder shall be deemed to be a waiver of any preceding or
                    subsequent breach or default. The section headings used herein are for reference only and shall not
                    be
                    read to have any legal effect.
                </p>

                <p>
                    The Service is operated by us in the United States. Those who choose to access the Service from
                    locations
                    outside the United States do so at their own initiative and are responsible for compliance with
                    applicable
                    local laws. You and <?= $settings['web_name']?> agree that the United Nations Convention on Contracts for the
                    International
                    Sale of Goods will not apply to the interpretation or construction of these Terms.
                </p>

                <p>
                    Except as otherwise provided herein, these Terms are intended solely for the benefit of the parties
                    and
                    are not intended to confer third-party beneficiary rights upon any other person or entity.
                </p>
            </div>
        </div>
    </section>
    <!-- end TOS -->

    <?php
  include_once("./layout/footer.php");

  ?>