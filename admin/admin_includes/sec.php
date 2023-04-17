<?php

$mysqli = new mysqli('localhost','root','','cms');
$query = "SELECT * FROM cms_posts where  post_id in $pid_list";
$result = $mysqli->query($query);
while ($row = $result->fetch_assoc()) {
    echo $row['post_id'];
}
if (!is_array($pid_list)) {
    $pidi_list = array($pid_list);
}

$conn = mysqli_connect('localhost', 'root', '', 'cms');

$zip = new ZipArchive();
$archive_name = "posts.zip";
if ($zip->open($archive_name, ZipArchive::CREATE) !== TRUE) {
    exit("Cannot create zip archive");
}

// Loop through the post IDs and add each post content to the zip file

$file_list = array();


foreach ($pidi_list as $post_id) {
    // Create a text file using the createfile() function
    $filename = "post_" . $post_id . "_test.txt";
    $file_content = createfile($post_id,'test'); // replace $input with your desired input value
    
    // Add the text file to the zip archive
    $file_list[] = $file_content;
    // $thumbnail_path = get_post_thumbnail($post_id);
    // if ($thumbnail_path) {
    //     $file_list[] = $thumbnail_path;
    // }

    //$zip->addFromString($filename, $file_content);
}

// Close the zip file and download it
if ($zip->close() === false) {
    exit("Failed to create zip archive: " . $zip->getStatusString());
}

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$archive_name);
header('Content-Length: ' . filesize($archive_name));
readfile($archive_name);

// Delete the zip file from the server
unlink($archive_name);
$zip->close();
?>


<?php

function createFile($post_id, $input) {
    // Get the post content from the database using the post ID
    $conn = mysqli_connect('localhost', 'root', '', 'cms');
    $sql = "SELECT * FROM cms_posts WHERE post_id=$post_id";
    $result = mysqli_query($conn, $sql);
    if ($result !== false && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $post_content = $row['post_content'];
    
    // Concatenate the post ID and input to the filename
    $filename = 'post_' . $post_id . '_' . $input . '.txt';
    
    // Open the file for writing
    $file = fopen($filename, 'w');
    
    // Write the post content to the file
    fwrite($file, $post_content);
    
    // Close the file
    fclose($file);
    echo "file created successfully";
    
    // Return the filename
    return $filename;
}

}
?>