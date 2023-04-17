<?php
include "sec2.php";
$connection = mysqli_connect('localhost','root','','cms');
if(isset($_GET['id'])) {

 $archieve_id= $_GET['id'];
$query = "SELECT * FROM cms_posts WHERE  post_id=$archieve_id";
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// fetch the data as an associative array
$c->single_download($result);

}
?>