<?php
if (isset($extraMsg) && !empty($extraMsg)) {
    ?>
    <div class="alert alert-danger">
        <?php
        echo $extraMsg;
        ?>    
    </div>
    <?php
}