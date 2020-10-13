<a href="<?php Route::route('fetchCat') ?>">View Category</a>
<br><br>
<!-- Insert Category form -->
<form action="<?php Route::route('insertCat') ?>" method="post">

	<!-- Generating CSRF Token -->
	<?php Security::csrf(); ?>

	<label>Category Name</label><br>
	<input type="text" name="category"><br><br>

	<input type="submit" name="insertCat" value="Insert">
</form>