<?php 
include "../common.php";
include 'admin_includes/admin_header.php';
include 'form.php';
?>
<body>
	<div id="wrapper">
	<?php include 'admin_includes/admin_nav.php';?>

		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-md-12">
						<h1 class="page-header"><?php echo SITENAME;?> Admin
							<small id="small"> Posts Manager</small>
						</h1>
					</div>
				</div>		<!-- /.row -->
									
				<div class="row">
					<div class="col-md-12">
						
<?php
if(isset($_GET['source'])) {
	$source = $_GET['source'];
} else {
	$source = "";
}
 $s=new switch_ch();
 $s->checki($source);
?>	

<?php include 'admin_includes/admin_footer.php';?>