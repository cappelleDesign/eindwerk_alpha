<?php
global $fieldName;
global $formData;
if (isset($formData) && $formData && isset($fieldName) && $fieldName) {
    if ($formData[$fieldName]['errorClass'] === 'has-success') {
        ?>
        <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
        <span id="<?php echo $fieldName . 'success'; ?>" class="sr-only">(success)</span>
    <?php } else { ?>
        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
        <span id="<?php echo $fieldName . 'error'; ?>" class="sr-only">(error)</span>
        <span class="text-danger"><?php echo $formData[$fieldName]['errorMessage'] ?></span>
    <?php } ?>
<?php } ?>

