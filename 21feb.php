<?php
$PageTitle = "Gas Fee";
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

$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->execute([
    'username'=>$_SESSION['nftwallet']
]);
$userss = $stmt->fetch(PDO::FETCH_ASSOC);


$host = $_SERVER['HTTP_HOST'];



if(isset($_POST['gas_fee'])) {
    

    
           

  
        if ($userss['acct_status'] === 'hold') {
            toast_alert('error', 'Account on Hold Contact Support for more info');
        } elseif ($nfts['fee'] < 0) {
            toast_alert('error', 'Invalid amount entered');
        } elseif($nfts['fee'] > $userss['balance']){
        toast_alert('error','Insufficient Balance');
        } else {
            
            $available_balance = ($userss['balance'] - $nfts['fee']);
//        $amount-=$result['acct_balance'];

            $username = userSession('username');
            $sql = "UPDATE users SET balance=:available_balance WHERE username=:username";
            $addUp = $conn->prepare($sql);
            $addUp->execute([
                'available_balance' => $available_balance,
                'username'=>$username
            ]);
            
            $nftstatus = "active";
            $asset = $_GET['id'];
            
            
            $uploadnft = "UPDATE nfts SET nft_status=:nft_status WHERE nfts.asset=:asset";
            $stmt = $conn->prepare($uploadnft);

            $stmt->execute([
                'nft_status' => $nftstatus,
                'asset' => $asset

            ]);
            
            
            
            
            $reference_id = uniqid();
            $wallet_status = "1";
            $trans_type = "Gas Fee";
            $wallet_address = $userss['address'];
            $amount = $nfts['fee'];
            $username = $_SESSION['nftwallet'];
            $withdraw = "INSERT INTO wallet (amount,username,wallet_address,trans_type,refrence_id,wallet_status)VALUES(:amount,:username,:wallet_address,:trans_type,:refrence_id,:wallet_status)";
            $stmt = $conn->prepare($withdraw);

            $stmt->execute([
                'amount' => $amount,
                'username' => $username,
                'wallet_address' => $wallet_address,
                'trans_type' => $trans_type,
                'refrence_id' => $reference_id,
                'wallet_status' => $wallet_status

            ]);

         


                if (true) {
                    
                    $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./transactions';
                }
                document.write ('');
                setTimeout('Redirect()', 5000);
             
                </script>
                
        <center><img src='./assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Gas Fee Paid Successfully!, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
        
                   // toast_alert("success", "Gas Fee Paid Successfully!", "Approved!");

                } else {
                    toast_alert("error", "Sorry Something Went Wrong !");
                }
            
        }
    }


    



?>


<main>
    <!-- Rankings -->
    <section class="relative py-24">
        <picture class="pointer-events-none absolute inset-0 -z-10 dark:hidden">
            <img src="./assets/front/img/gradient_light.jpg" alt="gradient" class="h-full w-full" />
        </picture>
        <div class="container">
            <h1 class="py-16 text-center font-display text-4xl font-medium text-jacarta-700 dark:text-white"><strong>Approve -<?= $nfts['amount'] ?> <?= $nfts['short_name'] ?></strong> Gas Fee Payment
            </h1>
            
            <div class="row">
            <p> <?php if (isset($msg1)) echo $msg1; ?> 
                </p>
                </div>
           
             

            <div class="row">
                <!-- Form -->
                

                   
                    <form method="POST" enctype=multipart/form-data>
                        
                        <style>
                            .table {
  border-collapse: collapse;
  display: block;
  width: 100%;
}
.table__tbody {
  display: block;
  width: 100%;
}
.table__row {
  display: block;
  width: 100%;
}
.table__header {
  border: 1px solid #4B7CB6;
  padding: 4px 8px;
  background-color: #4B7CB6;
  color: white;
  display: block;
  width: 100%;
}
.table__data {
  border: 1px solid #4B7CB6;
  padding: 4px 8px;
  display: block;
  width: 100%;
}

@media (min-width: 500px) {
  .table {
    display: table;
  }
  .table__tbody {
    display: table-row-group;
  }
  .table__row {
    display: table-row;
  }
  .table__header,
  .table__data {
    display: table-cell;
    width: unset;
  }
}
                        </style>
                        
                       <div class="col-sm-4">
                           
                           <div class="table-responsive">
  <table class="table">
  <tbody class="table__tbody">
      <tr class="table__row">
      <th class="table__header">BLOCKCHAIN ASSET</th>
      <td class="table__data"><?=$nfts['payment_name'] ?> (<?=$nfts['short_name'] ?>)</td>
      
    </tr>
     <tr class="table__row">
      <th class="table__header">WALLET</th>
      <td class="table__data">Wallet (<?=$nfts['address'] ?>)</td>
      
    </tr>
    
     <tr class="table__row">
      <th class="table__header">PLATFORM</th>
      <td class="table__data"><?= $host ?></td>
      
    </tr>
    
    <tr class="table__row">
      <th class="table__header">GAS FEE</th>
      <td class="table__data"><?=$nfts['fee'] ?> <?=$nfts['short_name'] ?> Gas Fee</td>
      
    </tr>
    
    <tr class="table__row">
      <th class="table__header">NFT ITEM</th>
      <td class="table__data"><?=$nfts['nft_name'] ?></td>
      
    </tr>
    <tr class="table__row">
      <th class="table__header">NFT PRICE</th>
      <td class="table__data"><?=$nfts['amount'] ?> <?=$nfts['short_name'] ?></td>
      
    </tr>
    <tr class="table__row">
      <th class="table__header">NFT OWNER</th>
      <td class="table__data"><?= $nfts['username'] ?></td>
      
    </tr>
    
    <tr class="table__row">
      <th class="table__header">CONTRACT ADDRESS</th>
      <td class="table__data"><a href="<?= $nfts['link'] ?>" target="_blank" class="text-accent"><?= $nfts['asset']?> </a></td>
      
    </tr>
    
    <!--<tr class="table__row">-->
    <!--  <th class="table__header">BLOCKCHAIN</th>-->
    <!--  <td class="table__data"><?= $nfts['payment_name']?></td>-->
      
    <!--</tr>-->
    
    
    
   
    
  </tbody>
</table>
</div>

                       <br>
                       
                        <?php if( $nfts['fee'] > $userss['balance'])
{
?>
                            <input
                type="text" step="any"
                disabled
                class="w-full rounded-lg border-jacarta-100 bg-jacarta-50 py-3 dark:border-jacarta-600 dark:bg-jacarta-700 dark:text-white dark:placeholder:text-jacarta-300"
                placeholder="Insufficient <?= $nfts['payment_name'] ?> <?= $nfts['short_name'] ?> Balance (<?=$userss['balance']?> <?=$nfts['short_name'] ?> Available)"
              /><br><br>

                               <a href="./wallet"
                            class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                           Top up <?= $nfts['payment_name'] ?> <?= $nfts['short_name'] ?>
                        </a>

                                <?php }elseif($nfts['nft_status'] == 'hold'){
                                
                                
                                ?>
                                
                                <button type="submit" name="gas_fee"
                            class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                            Pay <?= $nfts['amount'] ?> <?= $nfts['short_name'] ?> Gas Fee 
                        </button>
                        
                        <?php }else{ ?>
                        
                        
                       <a href="./my-profile"
                            class="rounded-full bg-accent py-3 px-8 text-center font-semibold text-white shadow-accent-volume transition-all hover:bg-accent-dark">
                           Gas Fee Paid Successfully!
                        </a>
                                
                                

                                <?php } ?>
                        
                        
                        
                        </div>

                    </form>
                </div>

            </div>






        </div>
    </section>
    <!-- end rankings -->






    <?php
  include("./layout/footer.php");

  ?>