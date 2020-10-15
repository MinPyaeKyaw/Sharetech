<!-- Course Upload Form -->
<form action="<?php Route::route('instructor/insertCourse') ?>" method="post" enctype="multipart/form-data">

	<?php Security::csrf(); ?>

	<input type="hidden" name="inst_id" value="4">

	<input type="hidden" name="cat_id" value="5">

	<label>Course Cover</label><br>
	<input type="file" name="course_cover"><br><br>

	<label>Course Name</label><br>
	<input type="text" name="course_name"><br><br>

	<label>Course Description</label><br>
	<textarea name="course_description"></textarea><br><br>

	<input type="submit" name="uploadCourse">

</form>