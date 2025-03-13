<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <?php 
    $is_admin = isset($_GET['a']) && (strpos($_GET['a'], 'admin') !== false);
    if($is_admin): 
    ?>
    <link rel="stylesheet" href="/assets/css/style_admin.css">
    <?php endif; ?>
    <link rel="shortcut icon" href="favicon.ico" type="../../../public/assets/images/logo-w.png">
</head>
<body<?php echo $is_admin ? ' class="admin-page"' : ''; ?>>
    
