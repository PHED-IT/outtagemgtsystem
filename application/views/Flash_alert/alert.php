<?php
    $success_flashData = $this->session->flashdata('success');
    $error_flashData = $this->session->flashdata('error');
    $warning_flashData = $this->session->flashdata('warning');

    if ($success_flashData !== NULL) {
        echo '<div class="alert alert-success" role="alert" style="margin-top:10px">'.$success_flashData.'</div>';
    }

    if ($error_flashData !== NULL) {
        echo '<div class="alert alert-danger" role="alert" style="margin-top:10px">'.$error_flashData.'</div>';
    }

    if ($warning_flashData !== NULL) {
        echo '<div class="alert alert-danger" role="alert" style="margin-top:10px">'.$warning_flashData.'</div>';
    }
?>