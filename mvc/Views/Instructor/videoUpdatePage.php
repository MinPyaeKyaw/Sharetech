<?php 

	foreach ($_SESSION['videos'] as $value) {
?>
	<form action="<?php Route::route('instructor/updateDeleteVideos') ?>" method="post" enctype="multipart/form-data">

		<?php Security::csrf(); ?>

		<input type="hidden" name="video_id" value="<?php echo $value['video_id'] ?>">

		<input type="file" name="video">
		<br>

		<label>Title</label><br>
		<input type="text" name="title" value="<?php echo $value['video_title']; ?>" >
		<br>

		<label>Description</label><br>
		<textarea name="desc">
			<?php echo $value['video_description']; ?>
		</textarea>
		<br>

		<input type="hidden" name="path" value="<?php echo $value['video_path']; ?>" >

		<!-- Video Delete Form -->
		<input type="submit" name="deleteVideo" value="Delete">

		<!-- Video Update Form -->
		<input type="submit" name="updateVideo" value="Update">

	</form>
	<br>
<?php 
	}
?>