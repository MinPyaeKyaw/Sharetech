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
	echo "<br>";

	foreach ($this->courses as $value) {
?>
	<div>
		<h1>
			<!-- generating course path -->
			<?php $route = "course/".$value['course_id']; ?>
			<a href="<?php Route::route($route) ?>">
				<?php $course = explode("_", $value['course_name']); ?>
				<?php echo $course[1]; ?>
			</a>
		</h1>
		<p>
			<?php echo $value['course_description']; ?>
		</p>
	</div>

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