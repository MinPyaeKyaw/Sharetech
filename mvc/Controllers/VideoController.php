<?php 

// beginning of the Category Controller class
class VideoController extends Controller {

	// insert video data indivitually
	public function insertIndivitualPage() {
		
		if(isset($_POST['uploadVideo'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {
				$course_id   = $_POST['course_id'];
				$course_name = $_POST['course_name'];
				$videos      = $_FILES['video']['name'];
				$tmp_videos  = $_FILES['video']['tmp_name'];

				// initialize input
				$input = "<input type='hidden' name='courseId' value=".$course_id." />";
				$input .= "<input type='hidden' name='courseName' value=".$course_name." />";
				for($i=0; $i<count($videos); $i++) {
					if (Security::escapeFile($videos[$i]) == true) {

						// generating input for each video
						$name = str_replace(' ', '_', basename($videos[$i], '.php'));
						$input .= "<label>Video Title</label>";
						$input .= "<br>";
						$input .= "<input type=\"text\" name=".$name." />";
						$input .= "<br>";
						$input .= "<label>Video Description</label>";
						$input .= "<br>";
						$input .= "<textarea name="."des_".$name."></textarea>";
						$input .= "<br>";

						// defining tmp folder path
						$tmpFolder = "Views/tmp_course/".$course_name."/";

						// storing in tmp folder
						move_uploaded_file(
							$tmp_videos[$i], 
							$tmpFolder.$videos[$i]
						);
					}
				}
				// exporting data to view
				$this->view->inputs = $input;
				$this->view->render('Instructor/insertIndiVideoInfo');
			}
		}
	}

	// insert video data to db and move to courses folder
	public function insertIndivitualVideo() {
		// instance video model
		$videoModel = new VideoModel();

		if(isset($_POST['completeUpload'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {
				unset($_POST['completeUpload']);
				unset($_POST['csrf']);

				$course_id = $_POST['courseId'];
				$course_name = $_POST['courseName'];
				$title = '';
				$des   = '';
				$array = [];

				// pushing post method data into array
				foreach ($_POST as $key => $value) {
					array_push($array, $value);
				}

				for($i=2; $i<count($array); $i++) {
					// getting video info
					$title = $array[$i];
					$des = $array[$i+1];
					$i++;

					// query for insert video info
					$sql = $videoModel
					->insert(
						'video_title, video_description, course_id',
						[$title, $des, $course_id]
					)
					->getQuery();
					$videoModel->run($sql);
				}

				// move videos from tmp to courses folder
				$tmpFolderPath = "Views/tmp_course/";
				$finalCourseFolderPath = "Views/courses/";
				$courseFolder = scandir($tmpFolderPath);

				for($i=2; $i<count($courseFolder); $i++) {
					if ($courseFolder[$i] == $course_name) {

						// getting video paths
						$videos = scandir($tmpFolderPath.$course_name);
						// creating course folder
						mkdir($finalCourseFolderPath.$course_name);

						// moving to course folder
						for($j=2; $j<count($videos); $j++) {
							rename(
								$tmpFolderPath.$course_name.'/'.$videos[$j], 
								$finalCourseFolderPath.$course_name.'/'.$videos[$j]
							);
						}

						// removing course folder in tmp folder
						rmdir($tmpFolderPath.$course_name);
					}
				}
			}
		}

		// redirecting to instructor/insertCoursePage
		$this->redirect('instructor/insertCoursePage');
	}

}

 ?>

