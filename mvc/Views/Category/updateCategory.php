
<!-- form to update -->
<form action="<?php Route::route('updateCat') ?>" method="post">

	<!-- Generating CSRF Token -->
	<?php Security::csrf(); ?>

	<input type="hidden" name="catId" value="<?php echo $this->catId ?>">

	<label>Category</label><br>
	<input type="text" name="cat" value="<?php echo $this->cat ?>"><br><br>

	<input type="submit" name="updateCat" value="Update">

</form>