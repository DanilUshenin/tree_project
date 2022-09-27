<?php if(isset($node)): ?>
<ul class="node" data-node-id="<?= $node->getAttribute('id') ?>">
    <span class="show-children" data-node-id="<?= $node->getAttribute('id') ?>"<?= empty($node->children) ? 'style="display: none;"' : '' ?>>&#9656;</span>
    <span class="hide-children" data-node-id="<?= $node->getAttribute('id') ?>"<?= empty($node->children) ? 'style="display: none;"' : '' ?>>&#9662;</span>
    <span class="node-name" data-node-id="<?= $node->getAttribute('id') ?>"><?= $node->getAttribute('name') ?></span>
    <i class='create-node fa fa-plus-square-o' data-node-id="<?= $node->getAttribute('id') ?>"></i>
    <i class='<?= $node->getAttribute('is_root') ? 'delete-root-node' : 'delete-node' ?> fa fa-minus-square-o' data-node-id="<?= $node->getAttribute('id') ?>"></i>
    <div class="children" data-node-id="<?= $node->getAttribute('id') ?>">
        <?php if(isset($node->children)): ?>
            <?php foreach ($node->children as $node): ?>
                <li>
                    <?php include(ROOT . '/views/home_page/node.php') ?>
                </li>
            <?php endforeach; ?>
        <?php endif ?>
    </div>
</ul>
<?php endif ?>