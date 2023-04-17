<?php
include "admin_add_user.php";
class create_zip{

function create_ziplll($file_list){
    $zip = new ZipArchive();
    $archive_name = "posts.zip";
    if ($zip->open($archive_name, ZipArchive::CREATE) !== TRUE) {
        exit("Cannot create zip archive");
    }
    
    // Loop through the file list and add each file to the zip archive
    foreach ($file_list as $file_path) {
        if (file_exists($file_path)) {
            $zip->addFile($file_path);
        }
    }
    
    // Close the zip file and download it
    if ($zip->close() === false) {
        exit("Failed to create zip archive: " . $zip->getStatusString());
    }
    
    
    ob_end_clean();
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$archive_name);
    header('Content-Length: ' . filesize($archive_name));
    readfile($archive_name);
    
    // Delete the zip file from the server
    unlink($archive_name);
    $zip->close();
    



}
function get_post_thumbnail($post_id) {
    // Get the post thumbnail from the database using the post ID
    $conn = mysqli_connect('localhost', 'root', '', 'cms');
    $sql = "SELECT meta_value FROM cms_postmeta WHERE post_id=$post_id AND meta_key='_thumbnail_id'";
    $result = mysqli_query($conn, $sql);
    if ($result !== false && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $thumbnail_id = $row['meta_value'];
        
        // Get the file path of the post thumbnail using the thumbnail ID
        $sql = "SELECT meta_value FROM cms_postmeta WHERE post_id=$thumbnail_id AND meta_key='_wp_attached_file'";
        $result = mysqli_query($conn, $sql);
        if ($result !== false && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $thumbnail_path = $row['meta_value'];
            
            // Construct the full file path of the post thumbnail and return it
            $uploads_dir = __DIR__ . '/MyDir/';
            $thumbnail_fullpath = $uploads_dir . '/' . $thumbnail_path;
            return $thumbnail_fullpath;
        }
    }
    return null;
}

function createFile($post_id, $input,$base_path) {
    // Get the post content from the database using the post ID
   // global $base_path;

   //
   echo $base_path."inside create file";
    $conn = mysqli_connect('localhost', 'root', '', 'cms');
    $sql = "SELECT * FROM cms_posts WHERE post_id=$post_id";
    $result = mysqli_query($conn, $sql);
    if ($result !== false && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $post_content = $row['post_content'];
        
        // Concatenate the post ID and input to the filename
        $filename = 'post_' . $post_id . '_' . $input . '.txt';
        $file_path = $base_path .DIRECTORY_SEPARATOR.'post_files'.DIRECTORY_SEPARATOR . $filename; // Store the file in a "post_files" directory
        

        // echo $file_path;

        // Open the file for writing
        $file = fopen($file_path, 'w');
        
        // Write the post content to the file
        fwrite($file, $post_content);
        
        // Close the file
        fclose($file);

        echo "File created successfully: $file_path\n";
        
        // Return the file path
        return $file_path;
    }
}

function single_download($result){
    if (mysqli_num_rows($result) > 0) {
        // Output the content
        $row = mysqli_fetch_assoc($result);
    //echo $row["content"];
    ob_end_clean();
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename="my_file.txt"');
    
    // output the data as a downloadable file
    echo "ID: " . $row['post_id'] . "\n";
    echo "Status: " . $row['post_status'] . "\n";
    echo "Tags: " . $row['post_tags'] . "\n";
    echo "Date: " . $row['post_date'] . "\n";
    echo "Content: " . $row['post_content'];
    exit();
      } else {
        echo "No content found.";
      }
}


function clear_form(){
        $user_uname = '';
		$user_email = '';
		$user_pass1 = '';
		$user_pass2 = '';
		$user_fname = '';
		$user_lname = '';
}

}


?>