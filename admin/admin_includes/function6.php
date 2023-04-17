<?php

//include "admin_includes/admin_add_post.php";

echo "Helolo world";
function addPost($connection) {
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
  }


  function validateUserRegistration($user_uname, $user_email, $user_pass1, $user_pass2, $r) {
    if(empty($user_uname) || empty($user_email) || empty($user_pass1) || empty($user_pass2)) {
        return ['div_class' => 'danger', 'div_msg' => 'Please fill in all required fields.'];
    } elseif($user_pass1 !== $user_pass2) {
        return ['div_class' => 'danger', 'div_msg' => 'Password fields do not match. Please try again.'];
    } elseif(!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        return ['div_class' => 'danger', 'div_msg' => 'Please enter a valid email address.'];
    } elseif(mysqli_num_rows($r) > 0) {
        return ['div_class' => 'danger', 'div_msg' => 'Sorry, that username is already in use. Please choose another.'];
    }
    return null;
}



  function getCategories($connection){
    // get category name from database for dropdown field
    $query = "SELECT * FROM cms_categories ORDER BY cat_title";
    $cats = mysqli_query($connection, $query);

    // this is a special case, so it does not user confirmQuery()
    if(!$cats) {
        $div_class = "danger";
        $div_msg = "Database failed: ".mysqli_error($connection);
    }

    return $cats;
}

function initializeUserVariables() {
    $user_uname = '';
    $user_email = '';
    $user_pass1 = '';
    $user_pass2 = '';
    $user_fname = '';
    $user_lname = '';
    
    return compact('user_uname', 'user_email', 'user_pass1', 'user_pass2', 'user_fname', 'user_lname');
}



?>
<?php
function generate_first_row($user_uname, $user_email) {
    return '
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="user_uname">Username *</label>
                    <input type="text" class="form-control" name="user_uname" value="' . $user_uname . '">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="user_email">Email Address *</label>
                    <input type="text" class="form-control" name="user_email" value="' . $user_email . '">
                </div>
            </div>
        </div>
    ';
}
?>

