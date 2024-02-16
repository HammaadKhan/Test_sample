<?php

$PageTitle = "Edit Profile";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

if(!$_SESSION['nftwallet']) {
    header("location:./login");
    die;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
    ':username'=>$_SESSION['nftwallet']
]);
$usersin = $stmt->fetch(PDO::FETCH_ASSOC);



if(isset($_POST['upload_picture'])){
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "assets/front/img/uploads/";
        $n = $usersin['username'].$name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE users SET avatar=:image WHERE username =:username";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image'=>$n,
            ':username'=>$_SESSION['nftwallet']
        ]);

        if(true){
            toast_alert("success","Your Image Uploaded Successfully", "Thanks!");
        }else{
            echo "invalid";
        }


    }
}


if(isset($_POST['profile_save'])){
    $acct_fullname = $_POST['acct_fullname'];
    $acct_email = $_POST['acct_email'];
    $bio = $_POST['bio'];
    $twitter = $_POST['twitter'];


    $sql = "UPDATE users SET acct_fullname=:acct_fullname,acct_email=:acct_email,bio=:bio,twitter=:twitter  WHERE username=:username";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_fullname'=>$acct_fullname,
        'acct_email'=>$acct_email,
        'bio'=>$bio,
        'twitter'=>$twitter,
        ':username'=>$_SESSION['nftwallet']
    ]);

    if(true){
       
        toast_alert('success','Account updated successfully','Approved');
        
    }else{
        toast_alert('error','Sorry something went wrong');
        
        
    }
   

}




?>
 
<main class="pt-[5.5rem] lg:pt-24">
    <!-- Banner -->
    <!--<div class="relative">-->
    <!--    <object data="./assets/front/img/uploads/banner.jpg" type="image/png">-->
    <!--    <img src="./assets/front/img/uploads/<?= $users['user_cover'] ?>" alt="banner"-->
    <!--        class="h-[18.75rem] object-cover" />-->
    <!--        </object>-->
    <!--    <div class="container relative -translate-y-4">-->
    <!--        <div-->
    <!--            class="group absolute right-0 bottom-4 flex items-center rounded-lg bg-white py-2 px-4 font-display text-sm hover:bg-accent">-->
    <!--            <input type="file" accept="image/*" class="absolute inset-0 cursor-pointer opacity-0" />-->
    <!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"-->
    <!--                class="mr-1 h-4 w-4 fill-jacarta-400 group-hover:fill-white">-->
    <!--                <path fill="none" d="M0 0h24v24H0z"></path>-->
    <!--                <path-->
    <!--                    d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z">-->
    <!--                </path>-->
    <!--            </svg>-->
    <!--            <span class="mt-0.5 block group-hover:text-white">Edit cover photo</span>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!-- end banner -->

    <!-- Edit Profile -->
    <section class="relative py-16 dark:bg-jacarta-800">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>

        <div class="container">
            <div class="mx-auto max-w-[48.125rem] md:flex">
                <!-- Form -->
                <div class="mb-12 md:w-1/2 md:pr-8">
                    <form method="POST">
                    <div class="mb-6">
                        <label for="profile-username"
                            class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Full Name<span
                                class="text-red">*</span></label>
                        <input type="text" id="profile-username"
                            class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                            placeholder="Enter Full Name" value="<?= $usersin['acct_fullname'] ?>" required name="acct_fullname" />
                    </div>
                    <div class="mb-6">
                        <label for="profile-username"
                            class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Username<span
                                class="text-red">*</span></label>
                        <input type="text" id="profile-username"
                            class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                            placeholder="Enter username" value="<?= $usersin['username'] ?>" disabled />
                    </div>
                    <div class="mb-6">
                        <label for="profile-bio"
                            class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Bio<span
                                class="text-red">*</span></label>
                        <textarea id="profile-bio"
                            class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                             value="<?= $usersin['bio'] ?>" placeholder="Tell the world your story!" name="bio"></textarea>
                    </div>
                    <div class="mb-6">
                        <label for="profile-email"
                            class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Email address<span
                                class="text-red">*</span></label>
                        <input type="email" id="profile-email"
                            class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                            placeholder="Enter email" value="<?= $usersin['acct_email'] ?>" name="acct_email" required />
                    </div>
                    <div class="mb-6">
                        <label for="profile-twitter"
                            class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Links<span
                                class="text-red">*</span></label>
                        <div class="relative">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter"
                                class="pointer-events-none absolute top-1/2 left-4 h-4 w-4 -translate-y-1/2 fill-jacarta-300 dark:fill-jacarta-400"
                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
                                </path>
                            </svg>
                            <input type="text" id="profile-twitter"
                                class="w-full rounded-t-lg border-jacarta-100 py-3 pl-10 hover:ring-2 hover:ring-accent/10 focus:ring-inset focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                                placeholder="@twittername" name="twitter" value="<?= $usersin['twitter'] ?>" />
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Wallet
                            Address</label>
                        <button
                            class="js-copy-clipboard flex w-full select-none items-center rounded-lg border border-jacarta-100 bg-white py-3 px-4 hover:bg-jacarta-50 dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-jacarta-300"
                            data-tippy-content="Copy">
                            <span><?= $usersin['address']?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                class="ml-auto mb-px h-4 w-4 fill-jacarta-500 dark:fill-jacarta-300">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path
                                    d="M7 7V3a1 1 0 0 1 1-1h13a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-4v3.993c0 .556-.449 1.007-1.007 1.007H3.007A1.006 1.006 0 0 1 2 20.993l.003-12.986C2.003 7.451 2.452 7 3.01 7H7zm2 0h6.993C16.549 7 17 7.449 17 8.007V15h3V4H9v3zM4.003 9L4 20h11V9H4.003z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <button name="profile_save" type="submit"
                        class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                        Update Profile
                    </button>
                    
                    </form>
                </div>

                <!-- Avatar -->
                <div class="flex space-x-5 md:w-1/2 md:pl-8">
                    <form class="shrink-0" method="POST" id="general-info" enctype="multipart/form-data">
                        <figure class="relative inline-block">
                            
                            <img src="./assets/front/img/uploads/<?= $usersin['avatar'] ?>"
                                alt="collection avatar" width="150"
                                class="rounded-xl border-[5px] border-white dark:border-jacarta-600" />
                                
                            <div
                                class="group absolute -right-3 -bottom-2 h-8 w-8 overflow-hidden rounded-full border border-jacarta-100 bg-white text-center hover:border-transparent hover:bg-accent">
                                <input type="file" accept="image/*"
                                    class="absolute top-0 left-0 w-full cursor-pointer opacity-0" id="input-file-max-fs"  name="image" data-max-file-size="2M" />
                                <div class="flex h-full items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                        class="h-4 w-4 fill-jacarta-400 group-hover:fill-white">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z" />
                                    </svg>
                                </div>
                            </div>
                            <br>
                            <input type="submit" name="upload_picture" placeholder="upload now">
                        </figure>
                        
                    </form>
                    <div class="mt-4">
                        <span class="mb-3 block font-display text-sm text-jacarta-700 dark:text-white">Profile
                            Image</span>
                        <p class="text-sm leading-normal dark:text-jacarta-300">
                            We recommend an image of at least 300x300. Gifs work too. Max 5mb.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end edit profile -->

    <?php
  include_once("./layout/footer.php");

  ?>