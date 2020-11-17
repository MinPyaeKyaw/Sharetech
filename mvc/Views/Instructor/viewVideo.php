<?php 
foreach ($this->videos as $value) {
?>

	<?php $src = "../Views/courses/".$value['video_path']; ?>

	<video width="320" height="240" controls>
  		<source src="<?php echo $src; ?>" type="video/mp4">
	</video>

	<h3><?php echo $value['video_title']; ?></h3>
	<p><?php echo $value['video_description']; ?></p>

<?php 
}
 ?>