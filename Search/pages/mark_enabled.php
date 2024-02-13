<?php

if (isset($_POST['id']) && isset($_POST['action'])) {

    $bug_id = $_POST['id'];
    $action = $_POST['action'];

    $enabled = $action === 'undo' ? '10' : '80';

    $query = "UPDATE mantis_bug_table SET status=" . db_param() . " WHERE id = '$bug_id';";

    $res = db_query($query, array($enabled));

    //print_r($res);

    $url = plugin_page('search_page');
    //echo $url;

    header('Location: ' . $url);

}
