<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>
<?php include 'includes/navigation.php';?>
<?php include 'includes/functions.php';?>
<?php include 'admin/admin_includes/ALL_functions.php';?>

<?php 
	if(isset($_GET['cid'])) {
		$cid = mysqli_real_escape_string($connection, $_GET['cid']);
		
		// find total number of posts to determine number of pages for pagination
		$query = "select * from cms_posts where post_cat_id = $cid";
		$result = mysqli_query($connection, $query);
		$total_posts = mysqli_num_rows($result);
		$total_pages = ceil($total_posts / POSTSPERPAGE);
		
		// if $total_pages is 0, set it to 1 so pagination will not look for page 0
		if($total_pages < 1) {
			$total_pages = 1;
		}

		// check $_GET to get page number for pagination, otherwise start with page 1 
		if(isset($_GET['p'])) {
			$page = mysqli_real_escape_string($connection, $_GET['p']);

			// the 1st number in LIMIT is a multiple of POSTSPERPAGE starting at 0
			$first_limit = ($page - 1) * POSTSPERPAGE;
		} else {
			// $first_limit is needed for LIMIT clause, $page is needed for setting
			// active class of pagination buttons
			$first_limit = 0;
			$page = 1;
		}
		
		// create LIMIT clause
		$limit_clause = "LIMIT $first_limit, " . POSTSPERPAGE;
		
		// find posts for a specific category
		$query = "select cms_posts.*, cms_users.user_image FROM cms_posts
					INNER JOIN cms_users ON cms_posts.post_author = cms_users.user_uname
					where post_cat_id = '$cid' 
					AND post_status = 'Published'
					order by post_date DESC " . $limit_clause;
		
		// get category name from database to display in alert box
		$q2 = "select cat_title FROM cms_categories WHERE cat_id = $cid";
		
		$result = mysqli_query($connection, $q2);
		$cat_title = mysqli_fetch_array($result);
				
		$div_msg = "Displaying published posts for <strong>'$cat_title[0]'</strong> category.";
		
		$posts = mysqli_query($connection, $query);
		$div_class="";
		$div_msg="";
	
		
		check_if($posts,$connection,$cat_title);
	}			

// <!-- special alert div -->
// <!-- display alert messages -->

   $check_pa=new admin_view_posts();
$check_pa->display_alert($div_msg, $div_class);
?>
<!-- 
	"//<?php if(!empty($div_msg)):?> -->
<!-- <div class="alert alert-//<?php echo $div_class."it is empty";?>"> -->
	<!-- //<?php echo $div_msg;?> -->
<!-- </div> -->
<!-- //<?php endif;?>"			 -->

<!-- Blog Post Begins Here -->

<?php foreach($posts as $post):?>
<h2>
<a href="post.php?pid=<?php echo $post['post_id'];?>"><?php echo $post['post_title'];?></a>
</h2>
<p class="lead">by 
	<a href="aposts.php?u=<?php echo $post['post_author'];?>">
		<?php echo $post['post_author'];?>
		<img src="images/<?php echo $post['user_image'];?>" width="64px" height="64px">
	</a>
</p>
<p><span class="glyphicon glyphicon-time"></span>
<!-- timezone added -->
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<!-- timestamp added -->
	Posted on <?php echo date('M. j, Y, g:i a', strtotime($post['post_date']));?></p>
<hr>
<a href="post.php?pid=<?php echo $post['post_id'];?>">
<?php empty($post['post_image'])?$post['post_image']='post_default.png':
		$post['post_image'];?>
	<img class="img-responsive" src="images/<?php echo $post['post_image'];?>" alt="image">
</a>
<hr>
<p><?php echo shortenText($post['post_content']);?></p>
<a class="btn btn-primary" href="post.php?pid=<?php echo $post['post_id'];?>">
	Read More <span class="glyphicon glyphicon-chevron-right"></span>
</a>
<hr>
<?php endforeach;?>

<!-- pagination links -->

<!-- //This is a pagination system implemented in PHP that displays 
numbered links to navigate through pages of content, 
with previous and next buttons, and an active page indicator. -->
		<!-- /.col-md-8 -->

		<script>
	window.onload = function() {
	    pagin();
	};
	</script>

		 



<?php
function check_if($posts,$connection,$cat_title){
    if(!$posts) {	
        $div_class = 'danger';
        $div_msg = 'Database error: ' . mysqli_error($connection);
    } else {
        $post_count = mysqli_num_rows($posts);		
        if($post_count == 0) {
            $page_count = 0;
            $div_class = 'danger';
            $div_msg = "Sorry, no posts found for <strong>'$cat_title[0]'</strong> category.";
        } else {
            $page_count = ceil($post_count / 8);
            $div_class = 'success';
            $div_msg = "Showing published posts for <strong>'$cat_title[0]'</strong> category.";
            $div_msg .= " <a href='index.php'>Show All</a>";
        }
    }



}
?>



<?php  include 'includes/sidebar.php'; ?>     
<?php  include 'includes/footer.php'; ?>
