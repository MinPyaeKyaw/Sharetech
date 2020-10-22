<!-- Insert Video Form -->
<form action="<?php Route::route('instructor/editUploadedVideo'); ?>" method="post" enctype="multipart/form-data">

	<?php Security::csrf(); ?>

	<input type="hidden" name="course_id" value="<?php echo $this->course_id ?>">

	<input type="hidden" name="course_name" value="<?php echo $this->course ?>">

	<label>Upload your videos</label><br>
	<input type="file" name="video[]" multiple="multiple"><br><br>

	<input type="submit" name="uploadVideo" value="Upload">

</form>