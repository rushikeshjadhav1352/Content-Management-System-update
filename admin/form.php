<!-- <?php

//include "admin_includes/admin_add_post.php";

//echo "Helolo world";
//function addPost($connection) {
	//global $connection;
	
	if(isset($_POST['addpostsubmit'])) {
	  $author = mysqli_real_escape_string($connection, $_POST['post_author']);
	  $title = mysqli_real_escape_string($connection, $_POST['post_title']);
	  $cat = $_POST['post_category'];
	  $status = mysqli_real_escape_string($connection, $_POST['post_status']);
	  $tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
	  $image = mysqli_real_escape_string($connection, $_FILES['post_image']['name']);
	  $image_tmp = $_FILES['post_image']['tmp_name'];
	  $content = mysqli_real_escape_string($connection, $_POST['post_content']);
  
	  move_uploaded_file($image_tmp, "../images/$image");
  
	  $query = "INSERT INTO cms_posts
				(post_cat_id, post_title, post_author, post_date, post_image,
				post_content, post_tags, post_status)
				VALUES ($cat, '$title', '$author', now(), '$image', '$content',
				'$tags', '$status')";
  
	  $result = mysqli_query($connection, $query);
  
	  $div_info = confirmQuery($result, 'insert');
	  $div_class = $div_info['div_class'];
	  $div_msg = $div_info['div_msg'];
	}
  //}




?>
 -->








<?php















//include "admin_add_post.php";

// function addPost($connection,$_POST,$_FILES,$author) {
// 	if(isset($_POST['addpostsubmit'])) {
// 		$author = mysqli_real_escape_string($connection, $_POST['post_author']);
// 		$title = mysqli_real_escape_string($connection, $_POST['post_title']);
// 		$cat = $_POST['post_category'];
// 		$status = mysqli_real_escape_string($connection, $_POST['post_status']);
// 		$tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
// 		$image = mysqli_real_escape_string($connection, $_FILES['post_image']['name']);
// 		$image_tmp = $_FILES['post_image']['tmp_name'];
// 		$content = mysqli_real_escape_string($connection, $_POST['post_content']);
		
// 		move_uploaded_file($image_tmp, "../images/$image");
		
// 		$query = "INSERT INTO cms_posts
// 				(post_cat_id, post_title, post_author, post_date, post_image,
// 				post_content, post_tags, post_status)
// 				VALUES ($cat, '$title', '$author', now(), '$image', '$content',
// 				'$tags', '$status')";
		
// 		$result = mysqli_query($connection, $query);
		
// 		$div_info = confirmQuery($result, 'insert');
// 		$div_class = $div_info['div_class'];
// 		$div_msg = $div_info['div_msg'];
		
// 		return array('div_class' => $div_class, 'div_msg' => $div_msg);
// 	}
//}

function exectue($username){
$query = "select SELECT cms_users.user_uname from cms_users 
				where user_uname = '$username'
				union
				select cms_comments.comment_author from cms_comments 
				where comment_author = '$username'";
return $query;
}
?>
