
<a href="<?php Route::route('insertCatPage') ?>">Insert Category</a>
<br><br>
<?php 
	foreach ($this->cats as $value) {
		echo $value['category'];
?>
	<!-- delete form -->
	<form method="post" action="<?php Route::route('deleteCat'); ?>">
		<!-- Generating CSRF Token -->
		<?php Security::csrf(); ?>

		<input type="hidden" name="catId" value="<?php echo $value['category_id']; ?>">

		<input type="submit" name="deleteCat" value="Delete">
	</form>

	<!-- update form -->
	<form method="post" action="<?php Route::route('updateCatPage'); ?>">
		<!-- Generating CSRF Token -->
		<?php Security::csrf(); ?>

		<input type="hidden" name="catId" value="<?php echo $value['category_id']; ?>">

		<input type="hidden" name="cat" value="<?php echo $value['category']; ?>">

		<input type="submit" name="updateCat" value="Update">
	</form>
<?php 
	}
 ?>