<?php
class admin_view_posts{
    
    function check_bulk_action($bulk_action,$pid_list){
        if($bulk_action!='Archieve_posts'){
        switch($bulk_action) {
			case 'Set Published Status':		
				$query = "UPDATE cms_posts SET post_status = 'Published'
							WHERE post_id in $pid_list";
				break;
			case 'Set Draft Status':
				$query = "UPDATE cms_posts SET post_status = 'Draft' 
							WHERE post_id in $pid_list";
				break;
			case 'Clone':
				echo "Hello world";
				$query = "INSERT INTO cms_posts (post_cat_id, post_title, post_author, 
							post_image, post_content, post_tags, post_status) 
							SELECT post_cat_id, post_title, post_author,post_image, post_content, 
							post_tags, post_status 
							FROM cms_posts WHERE post_id in $pid_list";
				break;
			case 'Delete':
				echo "Hello world";
				$query = "DELETE FROM cms_posts WHERE post_id in $pid_list";
				break;
			//case 'Archieve_posts':
			//	//echo $base_path;
			//	
            //
			//	include 'admin_includes/sec2.php';
				
			default:
				break;	
		}
        return $query;
    }
    }


    // function table_heading(){
    //     <table>
    //     <thead>
	// 		<tr>
	// 			<th style="width:4%;text-align:center">
	// 			<input id="select_all" type="checkbox"></th>
	// 			<th style="width:4%;text-align:center">ID</th>
	// 			<th style="width:8%;text-align:center">Author</th>
	// 			<th style="width:17%;text-align:center">Title</th>
	// 			<th style="width:7%;text-align:center">Category</th>
	// 			<th style="width:7%;text-align:center">Status</th>
	// 			<th style="width:17%;text-align:center">Image</th>
	// 			<th style="width:16%;text-align:center">Tags</th>
	// 			<th style="width:9%;text-align:center">Views / Comments</th>
	// 			<th style="width:10%;text-align:center">Date</th>
	// 			<th style="width:5%;text-align:center">Edit / Delete</th>
	// 			<th style="width:5%;text-align:center">Archieve</th>																		
	// 		</tr>								
	// 	</thead>
    //     </table>
    // }

    function check_admin_add(){
       	// non-admins can only see their own posts
		if($_SESSION['role'] == 'Administrator') {	
			$author = "";	
			$query = "SELECT cms_posts.*, cms_categories.cat_title, 
						count(cms_comments.comment_id) as	post_comment_count
						FROM cms_posts
						INNER JOIN cms_categories ON cms_posts.post_cat_id = cms_categories.cat_id
						LEFT OUTER JOIN cms_comments ON cms_posts.post_id = cms_comments.comment_post_id
						GROUP BY cms_posts.post_id
						ORDER BY cms_posts.post_date DESC";
		} else {
			$author = $_SESSION['username'];			
			$query = "SELECT cms_posts.*, cms_categories.cat_title, 
						count(cms_comments.comment_id) as	post_comment_count
						FROM cms_posts
						INNER JOIN cms_categories ON cms_posts.post_cat_id = cms_categories.cat_id
						LEFT OUTER JOIN cms_comments ON cms_posts.post_id = cms_comments.comment_post_id
						WHERE post_author = '$author'
						GROUP BY cms_posts.post_id
						ORDER BY cms_posts.post_date DESC";
		}
        return $query;
    }
    function display_alert($div_msg, $div_class) {
        if (!empty($div_msg)) {
            echo '<div class="alert alert-' . $div_class . '">' . $div_msg . '</div>';
        }
    }

   
       

}
?>
<!-- this is all the content which is admin_view_all_posts where line no 126 -->
<?php echo '<script>function  displayMessage(){<tr>
				<th style="width:4%;text-align:center">
				<input id="select_all" type="checkbox"></th>
				<th style="width:4%;text-align:center">ID</th>
				<th style="width:8%;text-align:center">Author</th>
				<th style="width:17%;text-align:center">Title</th>
				<th style="width:7%;text-align:center">Category</th>
				<th style="width:7%;text-align:center">Status</th>
				<th style="width:17%;text-align:center">Image</th>
				<th style="width:16%;text-align:center">Tags</th>
				<th style="width:9%;text-align:center">Views / Comments</th>
				<th style="width:10%;text-align:center">Date</th>
				<th style="width:5%;text-align:center">Edit / Delete</th>
				<th style="width:5%;text-align:center">Archieve</th>																		
			</tr>}</script>'; ?>


<?php echo '<script>function  check_aut(){
<h2>Sorry! You are not authorized to use this page.</h2>
	<a href="../index.php" class="btn btn-primary add-del-btn">Home</a>
	<a href="posts.php?source=" class="btn btn-primary add-del-btn">View Posts</a>
	<a href="profile.php" class="btn btn-primary add-del-btn">Profile</a>
	<a href="../includes/logout.php" class="btn btn-primary add-del-btn">Log Out</a>

    </script>'; ?>

<?php

// function check_if($posts,$connection,$cat_title){
//     if(!$posts) {	
//         $div_class = 'danger';
//         $div_msg = 'Database error: ' . mysqli_error($connection);
//     } else {
//         $post_count = mysqli_num_rows($posts);		
//         if($post_count == 0) {
//             $page_count = 0;
//             $div_class = 'danger';
//             $div_msg = "Sorry, no posts found for <strong>'$cat_title[0]'</strong> category.";
//         } else {
//             $page_count = ceil($post_count / 8);
//             $div_class = 'success';
//             $div_msg = "Showing published posts for <strong>'$cat_title[0]'</strong> category.";
//             $div_msg .= " <a href='index.php'>Show All</a>";
//         }
//     }



// }


?>
<?php echo '<script>function  pagin(){
<div class="pagination-div">
	<ul class="pagination pagination-sm"  >
		<li>
				<a href="cposts.php?p=1&cid=<?php echo $cid;?>" aria-label="Previous">
  				<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
	  <?php for($i = 1; $i <= $total_pages; $i++):?>
	  <?php if($i == $page):?>
	  <li class="active">
		  	<a href="cposts.php?p=<?php echo $i;?>&cid=<?php echo $cid;?>"><?php echo $i;?></a>
	  	</li>
	  	<?php else:?>
	  <li>
		  	<a href="cposts.php?p=<?php echo $i;?>&cid=<?php echo $cid;?>"><?php echo $i;?></a>
	  	</li>
	  	<?php endif;?>
	  <?php endfor;?>
	  <li>
			<a href="cposts.php?p=<?php echo $total_pages;?>&cid=<?php echo $cid;?>" 
				aria-label="Next">
  				<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</div>


</div>
</script>'; ?>

<?php




?>






