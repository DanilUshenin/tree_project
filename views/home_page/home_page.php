<html lang="en">
<?php include(ROOT . '/views/layouts/head.php') ?>
<body>
<div class="wrapper">
    <button type="button" class="btn btn-link" id="create-root" <?= isset($node) ? 'style="display:none;"' : '' ?>>Create root</button>
    <div id="node-tree">
        <?php include(ROOT . '/views/home_page/node.php') ?>
    </div>

    <?php include(ROOT . '/views/layouts/popups/delete_root_node_popup.php') ?>
    <?php include(ROOT . '/views/layouts/popups/rename_node_popup.php') ?>
</div>
</body>
</html>