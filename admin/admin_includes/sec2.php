<?php include "create_zip.php"; ?>
<?php
$conn = mysqli_connect('localhost', 'root', '', 'cms');
//this is calling in sec2.
// Array to store file paths of all selected posts and their thumbnail
$file_list = array();
// Loop through the post IDs and create a text file for each post
//echo '<pre>';print_r($pidi_list);echo '</pre>';exit;
$c=new create_zip();
foreach ($post_id_selected as $pid_id) {
    // Create a text file using the createfile() function

    $filename = "post_" . $pid_id . "_test.txt";
    $file_content = $c->createFile($pid_id,'test',$base_path);
    // Add the file path to the array
    $file_list[] = $file_content;
    // Get the post thumbnail and add its file path to the array
    $thumbnail_path = $c->get_post_thumbnail($pid_id);
    if ($thumbnail_path) {
      $file_list[] = $thumbnail_path;
    }}
$c->create_ziplll($file_list);
?>