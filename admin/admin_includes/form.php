


function form(){
    <form action="" method="post" enctype="multipart/form-data">
	<!-- hidden input field to hold post_author -->
	<input type="hidden" name="post_author" value="<?php echo $author;?>">
	
	<div class="form-group">
		<label for="post_author">   Author </label>
		<input type="text" class="form-control" name="post_author_disabled"
			value="<?php echo $author?>" disabled>
	</div>	
	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input type="text" class="form-control" name="post_title">
	</div>
	
	
	<div class="row">	<!-- ------------------------------------------- -->
	<div class="col-md-4">	
	
	
	<div class="form-group">
		<label for="post_category">Post Category</label>
			<select name="post_category">
			<?php if(isset($cats)):?>
				<?php foreach($cats as $cat):?>
					<option value="<?php echo $cat['cat_id'];?>">
							<?php echo $cat['cat_title'];?></option>
				<?php endforeach;?>
			<?php endif;?>
		</select>			
	</div>
	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select name="post_status">
			<option value="Draft">Draft</option>
			<option value="Published">Publish</option>
		</select>
	</div>
	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>
	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" accept="image/*" name="post_image">
	</div>
	
	</div>		<!-- /.col-md-4 ---------------------------------------- -->
	<div class="col-md-8">
	
	
	<div class="form-group">
		<label for="title">Post Content</label>
		<textarea class="form-control" name="post_content" rows="16"></textarea>
	</div>
	
	</div>		<!-- /.col-md-8 -->
	</div>		<!-- /.row --------------------------------------------- -->
	
	
	<button type="submit" name="addpostsubmit" class="btn btn-success add-del-btn">
		<i class="fa fa-plus"></i> Add Post</button>
	<a href="posts.php" class="btn btn-primary">
			<i class="fa fa-eye"></i> View All Posts</a>
			
</form>
}



?>