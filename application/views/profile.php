<?php
/**
 * Author: Yusuf Shakeel
 * Date: 13-April-2018 Fri
 * Version: 1.0
 *
 * File: profile.php
 * Description: This file contains the profile view.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo WEBSITE_TITLE; ?></title>
    <?php require_once __DIR__ . '/template/head_html_template.php'; ?>

    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <p class="pull-right"><a href="./home"><i class="fa fa-arrow-left"></i> Back to home</a></p>

            <h3>Profile Page</h3>

            <div id="result"></div>

            <h3 class="text-center">JWT lifespan is set for <?php echo WEBSITE_JWT_LIFESPAN; ?> seconds for this demo.</h3>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/template/footer.php'; ?>

<script src="./assets/js/profile.js"></script>
</body>
</html>