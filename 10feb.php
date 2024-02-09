<?php
ob_start();
session_start();
require($_SERVER['DOCUMENT_ROOT']. "/include/function.php");

if(@$_SESSION['nftwallet']){
  header("Location:./");
}

// Settings Table
$stmt = $conn->prepare("SELECT * FROM settings");
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $PageTitle ?> - <?= $web_name ?></title>

    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />

    <!-- Css -->
    <link rel="stylesheet" href="./assets/front/css/style.css" />

    <!-- Dark Mode JS -->
    <!-- <script src="./assets/front/js/darkMode.bundle.js"></script> -->

    <!-- Favicons -->
    <link rel="shortcut icon" href="./assets/front/img/favicon.ico" />
    <link rel="apple-touch-icon" href="https://deothemes.com/envato/xhibiter/html/img/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="./assets/front/img/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="./assets/front/img/apple-touch-icon-114x114.png" />

    <!-- toaster -->
    <link rel="stylesheet" type="text/css" href="./assets/css/elements/alert.css">
    <!-- <link href="./plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link href="./plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" /> -->
    <link href="./plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="./plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="./plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="./assets/js/libs/jquery-3.1.1.min.js"></script>

    <style>
    /* bootstrap-tagsinput.css file - add in local */


    .bootstrap-tagsinput {
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        display: inline-block;
        padding: 4px 6px;
        color: #4a0bb0;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        line-height: 22px;
        cursor: text;
    }

    .bootstrap-tagsinput input {
        border: none;
        box-shadow: none;
        outline: none;
        background-color: transparent;
        padding: 0 6px;
        margin: 0;
        width: auto;
        max-width: inherit;
    }

    .bootstrap-tagsinput.form-control input::-moz-placeholder {
        color: #4a0bb0;
        opacity: 1;
    }

    .bootstrap-tagsinput.form-control input:-ms-input-placeholder {
        color: #4a0bb0;
    }

    .bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
        color: #4a0bb0;
    }

    .bootstrap-tagsinput input:focus {
        border: none;
        box-shadow: none;
    }

    .bootstrap-tagsinput .tag {
        background: gray;
        border: 1px solid black;
        padding: 0 6px;
        margin-right: 2px;
        color: white;
        border-radius: 4px;
    }

    .bootstrap-tagsinput .tag [data-role="remove"] {
        margin-left: 8px;
        cursor: pointer;
    }

    .bootstrap-tagsinput .tag [data-role="remove"]:after {
        content: "x";
        padding: 0px 2px;
    }

    .bootstrap-tagsinput .tag [data-role="remove"]:hover {
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    }
    </style>
    
    
<!-- livechat -->
<?= $settings['livechat'] ?>
<!-- livechat -->


</head>

<body class="dark:bg-jacarta-900 font-body text-jacarta-500 overflow-x-hidden" itemscope
    itemtype="http://schema.org/WebPage">