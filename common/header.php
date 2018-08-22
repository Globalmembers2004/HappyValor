<?php require 'common/init_session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3F51B5">
    <title>HAPPYLAND </title>
    <link rel="icon" sizes="192x192" type="image/ico" href="images/favicon.ico" />
    <link rel="stylesheet" href="plugins/materialize/css/materialize.min.css"/>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/extend-material.min.css"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles/metro-lite.min.css"/>
    <link rel="stylesheet" href="styles/metro-lite-responsive.min.css"/>
    <link rel="stylesheet" href="styles/custombox-modal.min.css"/>
    <link rel="stylesheet" href="styles/slideshow.min.css"/>
    <link rel="stylesheet" href="plugins/snackbar/css/snackbar.min.css"/>
    <link rel="stylesheet" href="plugins/taggle/css/taggle.min.css">
    
    <?php if (($pag == 'reports') || ($subpag == 'cliente')): ?>
    <link rel="stylesheet" href="plugins/jquery-ui/css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="plugins/jquery-ui/css/jquery-ui.structure.min.css"/>
    <link rel="stylesheet" href="plugins/jquery-ui/css/jquery-ui.theme.min.css"/>
    <?php else: ?>
    <link rel="stylesheet" href="plugins/datetimepicker/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="plugins/easy-autocomplete/css/easy-autocomplete.min.css"/>
    <link rel="stylesheet" href="plugins/easy-autocomplete/css/easy-autocomplete.themes.min.css"/>
    <?php endif; ?>

    <link rel="stylesheet" href="styles/cart.min.css"/>
    <link rel="stylesheet" href="styles/list-special.min.css"/>
    <link rel="stylesheet" href="styles/coolprofile.min.css"/>
    <link rel="stylesheet" href="styles/opticon.v3.beautified.min.css">

    <link rel="stylesheet" href="styles/elegant-calendar.min.css"/>
    <link rel="stylesheet" href="styles/mdl-selectfield.min.css"/>
    <link rel="stylesheet" href="styles/mfb.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css"/>
    <link rel="stylesheet" href="styles/impresion-venta.css" type="text/css" media="print" />
</head>