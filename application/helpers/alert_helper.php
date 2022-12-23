<?php

function successAlert()
{
    $ci =& get_instance();

    if (isset($_SESSION['success_message'])):?>
        <div class="alert alert-success" role="alert">
            <?php
            echo $ci->session->flashdata('success_message');
            unset($_SESSION['success_message']);
            ?>
        </div>
    <?php endif;
}

function errorAlert()
{
    if (isset($_SESSION['error_message'])):?>
        <div class="alert alert-danger" role="alert">
            <?php
            echo $_SESSION['error_message'];
            unset($_SESSION['error_message']);
            ?>
        </div>
    <?php endif;
}