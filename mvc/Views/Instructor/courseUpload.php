<!-- Course Uploading Form -->
<form method="post" action="<?php Route::route('createCourseProcess') ?>">

	<?php Security::csrf(); ?>

	<!-- Categories -->
	<label>Choose your category</label><br>
	<select name="cat">
		<?php foreach ($this->cats as $key => $value) {
		?>
		<option value="<?php echo $key+1; ?>">
			<?php echo $value['category']; ?>
		</option>
		<?php 
		} ?>
	</select><br><br>

	<!-- Course Name -->
	<label>Course Name</label><br>
	<input type="text" name="course_name"><br><br>

	<!-- Course Description -->
	<label>Course Description</label><br>
	<textarea name="course_description"></textarea><br><br>

	<input type="submit" name="submit">
	
</form>
<!-- Course Uploading Form -->