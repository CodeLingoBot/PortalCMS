<?php
require $_SERVER["DOCUMENT_ROOT"]."/Init.php";
$pageName = Text::get('TITLE_DEBUG');
Auth::checkAuthentication();
$pageName = Text::get('TITLE_MAIL_TEMPLATES');
// Auth::checkAdminAuthentication();
if (!Permission::hasPrivilege("debug")) {
    Redirect::permissionerror();
    die();
}
require DIR_ROOT.'includes/functions.php';
require DIR_ROOT.'includes/head.php';
displayHeadCSS();
PortalCMS_JS_headJS();
?>
</head>
<body>
<?php require DIR_ROOT.'includes/nav.php'; ?>
<main>
    <div class="content">
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-12">
                    <h1><?php echo $pageName; ?></h1>
                </div>
            </div>
            <?php Util::DisplayMessage(); ?>
        </div>
        <hr>
        <div class="container">
            <h2>error</h2>

            <p><?php
            $date = date('Y-m-d H:i:s');
            echo '$date: '.$date.' <br>';
            $datesubtracted = $date - 30;
            echo '$date - 30: '.$datesubtracted.'<br>';
            $unix = strtotime($date);
            echo 'unix: '.$unix.'<br>';
            ?></p>
            <h2>var_dump($_SESSION)</h2>
            <?php var_dump($_SESSION) ?>
        </div>
    </div>
</main>
<?php require DIR_ROOT.'includes/footer.php'; ?>
</body>
</html>