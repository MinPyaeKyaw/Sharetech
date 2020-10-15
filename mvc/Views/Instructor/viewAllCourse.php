<?php 
	foreach ($this->cats as $value) {
	$url = "instructor/viewByCat/".$value['category_id'];
?>
	<a href="<?php Route::route($url) ?>">
		<?php echo $value['category']; ?>
	</a>
	<br>
<?php 
	}

	echo "<br>";

	foreach ($this->courses as $value) {
		echo $value['course_name'];
		echo "<br>";
		echo $value['course_description'];
		echo "<br>";
		echo $value['course_cover'];
		echo "<br>";
?>
	<!-- Update Form -->
	<form action="<?php Route::route('instructor/updatePage') ?>" method="post">

		<?php Security::csrf() ?>

		<input type="hidden" name="course_id" value="<?php echo $value['course_id'] ?>">

		<input type="submit" name="updateSubmit" value="Update">
		
	</form>

	<!-- Delete Form -->
	<form action="<?php Route::route('instructor/deleteCourse') ?>" method="post">

		<?php Security::csrf() ?>

		<input type="hidden" name="course_id" value="<?php echo $value['course_id'] ?>">
		
		<input type="submit" name="deleteSubmit" value="Delete">
		
	</form>
<?php 
	}

 ?>