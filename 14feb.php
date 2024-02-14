<?php
$PageTitle = "Deleting";
include_once("./layout/header.php");
include($_SERVER['DOCUMENT_ROOT']. "/include/notified.php");

$id = $_GET['id'];

if(!$_SESSION['nftwallet']) {
    header("location:./login");
    die;
}

    $sql55 = "SELECT * FROM nfts WHERE nft_id=:id";
$data = $conn->prepare($sql55);
$data->execute(['id'=>$id]);

    $delete = $data->fetch(PDO::FETCH_ASSOC);
    
    

    $id = $_GET['id'];
    $sql = "DELETE FROM nfts WHERE nfts.nft_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'id'=>$id
    ]);
 

    if(true){
        // toast_alert('success','Deleted Successfully','Deleted');
      $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./my-profile';
                }
                document.write ('');
                setTimeout('Redirect()', 2000);
             
                </script>
                
        <center><img src='assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Deleted, Please Wait while we redirect you...
              </strong></center>
          </div>
        ";
    }else{
        toast_alert('danger','Sorry Something Went Wrong','Error');
    }
    
    // header('Location:./wire-trans');

    ?>



<main>
    
   <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white"></h1>

            <div class="mx-auto max-w-[48.125rem]">
            <?php if (isset($msg1)) echo $msg1; ?>
             </div>


           
        </div>
    </section>
    <!-- end create -->

    <?php
  include_once("./layout/footer.php");

  ?>
  