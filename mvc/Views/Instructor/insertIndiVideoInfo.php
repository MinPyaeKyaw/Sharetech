
<form method="post" action="<?php Route::route('instructor/finalUpload') ?>">
<?php 
	Security::csrf();
	echo $this->inputs;
?>
<br>
<input type="submit" name="completeUpload" value="Upload" />

</form>