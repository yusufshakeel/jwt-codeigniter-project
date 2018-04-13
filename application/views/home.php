<?php
/**
 * Author: Yusuf Shakeel
 * Date: 13-April-2018 Fri
 * Version: 1.0
 *
 * File: home.php
 * Description: This file contains the home view.
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
            <div class="text-center">
                <h3><a href="https://github.com/yusufshakeel/jwt-codeigniter-project">jwt-codeigniter-project</a></h3>
                <p>This is a CodeIgniter project using JWT to authenticate users.</p>

                <hr>

                <div>
                    <a href="https://github.com/yusufshakeel/jwt-codeigniter-project/releases"
                       class="btn btn-outline-primary">
                        <i class="fa fa-download"></i> Download
                    </a>
                    <a href="https://github.com/yusufshakeel/jwt-codeigniter-project"
                       class="btn btn-outline-primary">
                        <i class="fa fa-github"></i> GitHub
                    </a>
                </div>

                <br>

                <div>
                    <p>MIT License</p>
                    <p>Author: <a href="https://github.com/yusufshakeel">Yusuf Shakeel</a></p>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="text-center">
                <h3>Setup</h3>

                <p>This project will need Php v5.6+ and MariaDB/MySQL.</p>
                <p>CodeIgniter framework v3.1.8</p>

                <p>Install LAMP stack or use MAMP/XAMPP to run Php.</p>

                <p>Next download <a href="https://github.com/firebase/php-jwt">firebase/php-jwt</a> from GitHub.</p>

                <p>Use the
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample">
                        project.sql
                    </button>
                    file provided with this project to create the database and table.
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body text-left">
                        <pre><code>CREATE DATABASE mysql_proj_db;

USE mysql_proj_db;

CREATE TABLE `user` (
  `id` varchar(64) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `lastmodified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `email`, `password`, `firstname`, `lastname`, `lastmodified`, `created`) VALUES
('15236424895340', 'yusufshakeel@example.com', '$2y$12$3PfY4lNCR62/HH9aNGZFcebloX1gACQIbWeHfTwb8hKhMXfymiNLq', 'Yusuf', 'Shakeel', '2018-04-13 23:31:29', '2018-04-13 23:31:29');
</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="text-center">
                <h3>How this works?</h3>

                <p>So, you first sign up by entering an email address and setting a password.</p>

                <p>Next you log in to the application entering the email address and password.</p>

                <p>If the credentials are correct then you get the access to the <a href="./profile">profile page</a>.
                </p>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-12 col-sm-6">

            <h3 class="text-center">Sign up</h3>

            <form id="signup">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email"
                           maxlength="255"
                           class="form-control"
                           id="email"
                           required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password"
                           maxlength="32"
                           class="form-control"
                           id="password"
                           required>
                </div>
                <div class="form-group">
                    <label for="firstname">First name</label>
                    <input type="firstname"
                           maxlength="100"
                           class="form-control"
                           id="firstname"
                           required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last name</label>
                    <input type="lastname"
                           maxlength="100"
                           class="form-control"
                           id="lastname"
                           required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Sign up">
                </div>

                <div id="signup-msg"></div>
            </form>

        </div>
        <div class="col-xs-12 col-sm-6">

            <h3 class="text-center">Log in</h3>

            <form id="login">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email"
                           maxlength="255"
                           class="form-control"
                           id="login-email"
                           required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password"
                           maxlength="32"
                           class="form-control"
                           id="login-password"
                           required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Log in">
                </div>

                <div id="login-msg"></div>
            </form>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/template/footer.php'; ?>

<script src="./assets/js/script.js"></script>
</body>
</html>