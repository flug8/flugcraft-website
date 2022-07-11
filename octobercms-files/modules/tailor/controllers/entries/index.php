<?php if (!$this->fatalError): ?>

    <?= $this->listRender() ?>

<?php else: ?>

    <p class="flash-message static error"><?= e(trans($this->fatalError)) ?></p>

<?php endif ?>
