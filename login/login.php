<?php

require $_SERVER["DOCUMENT_ROOT"]."/Init.php";



$pageName = 'Login';
require_once DIR_INCLUDES.'functions.php';
require_once DIR_INCLUDES.'head.php';
require $_SERVER["DOCUMENT_ROOT"]."/login/ext/fb/config.php";
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl(FB_LOGIN_URL, $permissions);
displayHeadCSS();
PortalCMS_CSS_loadingAnimation();
PortalCMS_CSS_floatingLabels();

?>
<link rel="stylesheet" type="text/css" href="/includes/css/newlogin.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<?php PortalCMS_JS_headJS(); ?>
</head>
<body class='bg'>
    <?php require DIR_INCLUDES.'loadingAnimation.php'; ?>
  <nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo SiteSetting::getStaticSiteSetting('site_url'); ?>"><?php echo SiteSetting::getStaticSiteSetting('site_name'); ?></a>
        <?php Alert::renderFeedbackMessages(); ?>
  </nav>
  <main>
    <div class="content">
      <div class="container-fluid">
        <section class="bglogin">
          <div class="user_options-container">
            <div class="user_options-text">
              <div class="user_options-unregistered">
                <h2 class="user_unregistered-title">Nog geen account?</h2>
                <p class="user_unregistered-text">Klik op Registreren en maak direct een account aan.</p>
                <button class="btn btn-outline-info user_unregistered-signup" id="signup-button">Registreren</button>
              </div>
              <div class="user_options-registered">
                <h2 class="user_registered-title">Heb je al een account?</h2>
                <p class="user_registered-text">Log in met je bestaande gegevens.</p>
                <button class="btn btn-outline-info user_registered-login" id="login-button">Login</button>

              </div>
            </div>
            <div class="user_options-forms" id="user_options-forms">
                <?php require 'inc/login.inc.php'; ?>
                <?php require 'inc/registration.inc.php'; ?>
            </div>
          </div>
        </section>
        <script src="/includes/js/newlogin.js"></script>
        <?php Util::displayPopup(); ?>
      </div>
    </div>
  </main>
</body>
</html>
