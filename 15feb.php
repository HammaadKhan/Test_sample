<?php

$PageTitle = "Edit Password";
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
$users = $stmt->fetch(PDO::FETCH_ASSOC);


if(isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    if (empty($old_password)) {
        toast_alert( 'danger','Enter Old Password', 'Close');
    } elseif(empty($new_password) || empty($confirm_password)) {
        toast_alert( 'danger', 'Enter New Password & Confirm Password', 'Close');
    }else{

        $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
        $verification = password_verify($old_password, $row['acct_password']);

        if ($verification === false) {
            toast_alert("error", "Incorrect Old Password", "Close");

        } else if ($new_password !== $confirm_password) {
            toast_alert("error", "Confirm Password not matched", "Close");

        } else if ($new_password === $old_password) {
            toast_alert('error', 'New Password Matched with Old Password', 'Close');
        } else {
            $sql2 = "UPDATE users SET acct_password=:acct_password WHERE username =:username";
            $passwordUpdate = $conn->prepare($sql2);
            $passwordUpdate->execute([
                'acct_password' => $new_password2,
                 ':username'=>$_SESSION['nftwallet']
            ]);

            // $full_name = $user['firstname']. " ". $user['lastname'];
            // // $APP_URL = APP_URL;
            // $APP_NAME = WEB_TITLE;
            // $APP_URL = WEB_URL;
            // $APP_EMAIL = WEB_EMAIL;
            // $user_email = $user['acct_email'];

            // $message = $sendMail->PassChange($full_name,$APP_EMAIL, $APP_NAME);


            // $subject = "Password Chnage Notification". "-". $APP_NAME;
            // $email_message->send_mail($user_email, $message, $subject);

            // $subject = "Password Chnage Notification". "-". $APP_NAME;
            // $email_message->send_mail(WEB_EMAIL, $message, $subject);


            if (true) {
                toast_alert('success', 'Your Password Change Successfully !', 'Approved');
            } else {
                toast_alert('error', 'Sorry Something Went Wrong');
            }
        }
    }
}


?>
 
<main class="pt-[5.5rem] lg:pt-24">
 
    <!-- Edit Passwordd -->
    <section class="relative py-16 dark:bg-jacarta-800">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>

        <div class="container">
            <div class="mx-auto max-w-[48.125rem] md:flex">
           
                <!-- Form -->
                <div class="mb-12 md:w-1/2 md:pr-8">
                <form method="post">
                    <div class="mb-6">
                        <label for="profile-username"
                            class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Old Password<span
                                class="text-red">*</span></label>
                        <input type="password" name="old_password"  required
                            class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                            placeholder="Enter Old Password"  />
                    </div>

                    <div class="mb-6">
                        <label for="profile-username"
                            class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">New Password<span
                                class="text-red">*</span></label>
                        <input type="password" name="new_password"  required
                            class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                            placeholder="Enter New Password" />
                    </div>
                    <div class="mb-6">
                        <label for="profile-username"
                            class="mb-1 block font-display text-sm text-jacarta-700 dark:text-white">Confirm New Password<span
                                class="text-red">*</span></label>
                        <input type="password" name="confirm_password" 
                            class="w-full rounded-lg border-jacarta-100 py-3 hover:ring-2 hover:ring-accent/10 focus:ring-accent dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                            placeholder="Confirm New Password" required />
                    </div>
                   

                    <button type="submit" name="change_password"
                        class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                        Update Password
                    </button>
                </div>

                </form>
                <!-- Avatar -->
                <div class="flex space-x-5 md:w-1/2 md:pl-8">
                    <div class="mt-4">
                    <h5>What happens after you change your password</h5><br>
                        <p class="text-sm leading-normal dark:text-jacarta-300">
                        If you change or reset your password, you’ll be signed out everywhere except:<br>
                                  1. Devices you use to verify that it's you.<br>
                                        2. Some devices with third-party apps that you've given account access.<br>
                                        3. Helpful devices that you've given account access.   <br>
                                        
                                   
                                
                                </p>
                                <br>
                                <br>
                                <p class="text-sm leading-normal dark:text-jacarta-300">
                                If you're having trouble resetting your password, <a href="./support" >get more help</a>.
                                </p>
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