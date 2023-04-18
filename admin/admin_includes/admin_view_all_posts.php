<!-- ---------- only logged in user can use this page ----------------> 
<?php 
include "ALL_functions.php";
$check_page = new admin_view_posts();
?>

<?php 
//
//echo $base_path;




if(empty($_SESSION['userid'])):?>
<script>
	window.onload = function() {
	    check_aut();
	};
	</script>
	
<?php else:?>	

<?php
	// if delete button is pressed, admins can delete any post 
	// but others can only delete their own posts
	if(isset($_GET['del'])) {
		if($_SESSION['role'] == 'Administrator' ||
			(isset($_GET['author']) && $_SESSION['username'] == $_GET['author'])) {
			$id = mysqli_real_escape_string($connection, $_GET['del']);
		
			$query = "DELETE FROM cms_posts WHERE post_id = $id";
		
			$del_result = mysqli_query($connection, $query);
				
			$div_info = confirmQuery($del_result, 'delete');
			$div_class 		= $div_info['div_class'];
			$div_msg 			= $div_info['div_msg'];
		}
	}
?>	
<?php
	// if 'Apply' button is pressed and $_POST is set, check that a
	// bulk action is selected and at least one post_id is selected;
	// otherwise, don't do anything
	if(!empty($_POST['bulkaction']) && !empty($_POST['cbarray'])) {
		// get action from dropdown list
		$bulk_action = $_POST['bulkaction'];
		$post_id_selected=$_POST['cbarray'];
		// loop thru each checked item to build a list of post_id's
		// that looks like '(nn,nn,nn,nn)'
		$pid_list = '(';
		foreach($_POST['cbarray'] as $pid) {
			$pid_list .= $pid . ',';
		}
		// remove the last ',' and add a ')'
		$pid_list = substr($pid_list, 0, strrpos($pid_list, ',')) . ')';
		//echo "Hello world";
		if($bulk_action=='Archieve_posts'){
			include 'admin_includes/sec2.php';
		}else{
		
		$query=$check_page->check_bulk_action($bulk_action,$pid_list);

		}





		if(isset($query)){
		$result = mysqli_query($connection, $query);
		$div_info = confirmQuery($result, $bulk_action);
		$div_class 		= $div_info['div_class'];
		$div_msg 			= $div_info['div_msg'];	
		}
	}

?>

<form action="" method="post">

	<div class="row">
		<!-- 'view_posts_bulk' class is for setting the upper margins in order
					to line up with the alert box on the right -->
		<div class="col-md-3 view-posts-bulk">
			<select class="form-control" name="bulkaction">
				<option value="">Select Bulk Action</option>
				<option value="Set Published Status">Set 'Published' Status</option>
				<option value="Set Draft Status">Set 'Draft' Status</option>
				<option value="Clone">Clone Posts</option>
				<option value="Delete">Delete Posts</option>
				<option value="Archieve_posts">Archieve posts</option>
			</select>
			<span id="view-posts-arrow" class="glyphicon glyphicon-arrow-down"></span>
		</div>
		<div class="col-md-4 view-posts-bulk">
			<input type="submit" name="bulksubmit" class="btn btn-success" value="Apply"
				onclick="javascript: return confirm('Are you sure?');">
			<a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
			<a href="posts.php?source=" class="btn btn-default">Refresh</a>
		</div>
		<?php
		// display an alert message from result of $_GET or $_POST;
		// this row is not displayed if both $_GET and $_POST are not set
		if(isset($div_msg)):?>
		<div class="col-md-5">
			<div class="alert alert-<?php echo $div_class;?>">
				<?php echo $div_msg;?>
			</div>
		</div>
		<?php endif; ?>	
	</div>		<!-- /.row -->
	
	<!-- displays all posts in a table -->
	
	<table class="table table-condensed table-bordered table-hover"
		style="margin-top:20px;">

		
		
	
		<thead>
		<script>
	window.onload = function() {
	    displayMessage();
	};
	</script>
											
		</thead>
		<tbody>
		<?php	// non-admins can only see their own posts


    $query=$check_page->check_admin_add();
		
        $connection=mysqli_connect('localhost','root','','cms');
		$posts = mysqli_query($connection, $query);
		?>
		<?php foreach($posts as $post):?>
			<tr>
				<!-- 'checkbox_column' class centers all checkboxes in custom.css -->
				<td class="checkbox_column">
					<input class="checkboxes" type="checkbox" name="cbarray[]"
						value="<?php echo $post['post_id'];?>">
				</td>
				<td align="center"><?php echo $post['post_id'];?></td>
				<td><?php echo $post['post_author'];?></td>
				<td>
					<a href="../post.php?pid=<?php echo $post['post_id'];?>">	
						<?php echo $post['post_title'];?></a>
				</td>
				<td><?php echo $post['cat_title'];?></td>
				<td><?php echo $post['post_status'];?></td>
				<td>
					<img class="img-responsive" style="margin:auto"
						src="../images/<?php echo $post['post_image'];?>" height="47px"	
						width="141px" alt="image">
				</td>
				<td><?php echo $post['post_tags'];?></td>
				<td align="center"><?php echo $post['post_views_count'];?> / 
					<a href="comments.php?pid=<?php echo $post['post_id'];?>">				
						<?php echo $post['post_comment_count'];?></a>
				</td>
				<?php date_default_timezone_set("Asia/Kolkata"); ?>
				<td><?php echo date('M. j, Y, g:i a', strtotime($post['post_date']));?>
				</td>
				<td align="center">
					<a href="posts.php?source=edit_post&id=<?php echo $post['post_id'];?>" 
						class="btn btn-primary btn-xs active" role="button">
						<abbr title="Edit Post">
							<span class="glyphicon glyphicon-pencil"></span>
						</abbr>
					</a>	
					<hr>
					<a onclick="return confirm('Are you sure you want to delete	 this post and all its comments?');" 
						href="posts.php?del=<?php echo $post['post_id'];?>&author=<?php echo $author;?>" 
						class="btn btn-danger btn-xs active" role="button">
						<abbr title="Delete Post">
							<span class="glyphicon glyphicon-trash"></span>
						</abbr>
					</a>		
				</td>


				<td align="center">
					<a href="posts.php?source=Archieve_Post&id=<?php echo $post['post_id'];?>" 
						class="btn btn-primary btn-xs active" role="button">
						<abbr title="Archieve_Post">
							<span class="glyphicon glyphicon-pencil"></span>
						</abbr>
					</a>	
					<hr>
							
				</td>





			</tr>
		<?php endforeach;?> 
		</tbody>
	</table>	
</form>





<?php endif;?>		<!-- only 'Administrator' can use this page -->