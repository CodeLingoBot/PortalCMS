<?php
require $_SERVER["DOCUMENT_ROOT"]."/Init.php";
$pageName = Text::get('TITLE_CONTRACTS');
Auth::checkAuthentication();
if (!Permission::hasPrivilege("rental-contracts")) {
    Redirect::permissionerror();
    die();
}
require_once DIR_INCLUDES.'functions.php';
require_once DIR_INCLUDES.'head.php';
displayHeadCSS();
PortalCMS_CSS_dataTables();
PortalCMS_JS_headJS();
PortalCMS_JS_dataTables();
?>

</head>
<body>
<?php require DIR_INCLUDES.'nav.php'; ?>
<main>
    <div class="content">
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-8"><h1><?php echo $pageName ?></h1></div>
                <div class="col-sm-4"><a href="new.php" class="btn btn-success navbar-btn float-right"><span class="fa fa-plus"></span> <?php echo Text::get('LABEL_ADD'); ?></a></div>
            </div>
            <hr>
            <?php
            Alert::renderFeedbackMessages();
            $stmt = DB::conn()->prepare("SELECT * FROM contracts ORDER BY id ASC");
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                echo 'Ontbrekende gegevens..';
            } else {
                include 'contracts_table.php';
            }
            ?>
            <script class="init">
                $(document).ready(function() {
                    var table = $('#example').DataTable({
                        "scrollX": true,
                        "language": {
                            "url": '//cdn.datatables.net/plug-ins/1.10.19/i18n/Dutch.json'
                        }
                    });
                } );
            </script>
        </div>
    </div>
</main>
<?php require DIR_INCLUDES.'footer.php'; ?>
</body>