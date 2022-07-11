<?php if (!$field->hidden): ?>

    <?php if (!$this->showFieldLabels($field)): ?>

        <?= $this->renderFieldElement($field) ?>

    <?php else: ?>

        <?php if ($field->label): ?>
            <label for="<?= $field->getId() ?>" class="form-label">
                <?= e(trans($field->label)) ?>
            </label>
        <?php endif ?>

        <?php if ($fieldComment = $field->commentAbove): ?>
            <p class="form-text before-field"><?= $field->commentHtml ? trans($fieldComment) : e(trans($fieldComment)) ?></p>
        <?php endif ?>

        <?= $this->renderFieldElement($field) ?>

        <?php if ($fieldComment = $field->comment): ?>
            <p class="form-text"><?= $field->commentHtml ? trans($fieldComment) : e(trans($fieldComment)) ?></p>
        <?php endif ?>

    <?php endif ?>

<?php endif ?>
