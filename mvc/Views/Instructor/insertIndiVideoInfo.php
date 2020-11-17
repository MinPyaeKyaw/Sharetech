<!-- Defining info of each videos -->
<form method="post" action="<?php Route::route('instructor/finalUpload') ?>" id="videoForm">
<?php 
	Security::csrf();
	echo $_SESSION['videosInfo'];
?>
<br>
</form>

<!-- Button for Uploading video -->
<input type="submit" name="completeUpload" value="Upload" form="videoForm" />