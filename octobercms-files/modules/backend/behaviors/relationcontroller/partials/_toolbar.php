<div data-control="toolbar">

    <?php foreach ($relationToolbarButtons as $button): ?>

        <?php if ($button == 'update'): ?>
            <?= $this->relationMakePartial('button_update', [
                'relationManageId' => $relationManageId ?: $relationViewModel->getKey()
            ]) ?>
        <?php else: ?>
            <?= $this->relationMakePartial('button_'.$button) ?>
        <?php endif ?>

    <?php endforeach ?>

</div>
