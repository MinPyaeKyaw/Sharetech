<!-- Course Update Form -->
<?php 

	// getting course information that we want ot update
	foreach ($_SESSION['courseInfo'] as $value) {
		$course_id          = $value['course_id'];
		$course_name        = $value['course_name'];
		$course_description = $value['course_description'];
		$course_cover		= $value['course_cover'];
	}

 ?>

<!-- Course updating form -->
<form action="<?php Route::route('instructor/updateCourse') ?>" method="post" enctype="multipart/form-data">

	<?php Security::csrf(); ?>

	<input type="hidden" name="course_id" value="<?php echo $course_id ?>">

	<label>Course Cover</label><br>
	<input type="file" name="course_cover" value="<?php echo $course_cover ?>"><br><br>

	<label>Course Name</label><br>
	<input type="text" name="course_name" value="<?php echo $course_name ?>"><br><br>

	<label>Course Description</label><br>
	<textarea name="course_description">
		<?php echo $course_description ?>
	</textarea><br><br>

	<input type="submit" name="updateCourse" value="Update">

</form>

<!-- to videos updating form -->
<form method="post" action="<?php Route::route('instructor/videoUpdate') ?>">
	<?php Security::csrf(); ?>

	<input type="hidden" name="course_id" value="<?php echo $course_id ?>" />

	<input type="submit" name="toUpdateVideo" value="Update Videos">
</form>