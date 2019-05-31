<?php
$pageName = 'Wachtwoord resetten';
require $_SERVER["DOCUMENT_ROOT"]."/Init.php";
require_once DIR_INCLUDES.'functions.php';
require_once DIR_INCLUDES.'head.php';
displayHeadCSS();

PortalCMS_CSS_floatingLabels();
PortalCMS_JS_headJS();
?>
<?php PortalCMS_JS_JQuery_Simple_validator(); ?>
</head>
<body class="bg">
    <header>
        <div class="navbar navbar-dark bg-dark">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><span class="fa fa-arrow-left"></span> Inloggen</a>
                </li>
            </ul>
        </div>
    </header>
    <main>
        <div class="container col-md-6 offset-md-3 mt-5">
            <form method="post" class="form-signin shadow" validate=true>
                <div class="card">
                    <div class="card-header text-center">
                        <img src='<?php echo SiteSetting::getStaticSiteSetting('site_logo'); ?>' alt='<?php echo SiteSetting::getStaticSiteSetting('site_name'); ?>' width='200px' height='200px'/>
                        <h1 class="h3 mb-3 font-weight-normal"><?php echo SiteSetting::getStaticSiteSetting('site_name'); ?></h2>
                        <?php Alert::renderFeedbackMessages(); ?>
                    </div>
                    <div class="card-body">
                        <h2 class="h3 mb-3 font-weight-normal "><?php echo $pageName ?></h3>
                        <div class="form-label-group">
                            <input type="password" name="password" minlength="8" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" title="Use at least 8 characters. Please include at least 1 uppercase character, 1 lowercase character and 1 number."  id="inputPassword" class="form-control" placeholder="wachtwoord" autocomplete="new-password" required="" autofocus="" <?php if (empty($_GET['user_password_reset_hash'])) {echo 'disabled'; } ?>>
                            <label for="inputPassword">Wachtwoord</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" name="confirm_password" id="inputConfirmPassword" class="form-control" placeholder="Bevestig wachtwoord" data-match="wachtwoord" data-match-field="#inputPassword" autocomplete="new-password" required="" <?php if (empty($_GET['user_password_reset_hash'])) { echo 'disabled'; } ?>>
                            <label for="inputConfirmPassword">Bevestig wachtwoord</label>
                        </div>
                        <input type="text" name="username" value="<?php echo $_REQUEST['user_name']; ?>"/>
                        <input type="text" name="user_password_reset_hash" value="<?php echo $_REQUEST['user_password_reset_hash']; ?>"/>
                        <input type="submit" name="resetSubmit" value="Wachtwoord wijzigen" class="btn btn-secondary mb-sm-2" <?php if (empty($_GET['user_password_reset_hash'])) {echo 'disabled'; } ?>>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <?php View::renderFooter(); ?>
</body>
</html>
