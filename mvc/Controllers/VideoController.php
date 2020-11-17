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
				$_SESSION['videosInfo'] = '';

				// initialize input
				$input = "<input type='hidden' name='courseId' value=".$course_id." />";
				$input .= "<input type='hidden' name='courseName' value=".$course_name." />";
				for($i=0; $i<count($videos); $i++) {
					if (Security::escapeFile($videos[$i]) == true) {

						// generating input for each video
						$name = str_replace(' ', '_', basename($videos[$i], '.php'));
						$input .= $videos[$i]."<br>";
						// 
						$video = Security::setFilename($videos[$i]);
						$input .= "<input type='hidden' name=".$video." value=".$course_name.'/'.$video." />";
						$input .= "<label>Video Title</label>";
						$input .= "<br>";
						$input .= "<input type=\"text\" name=".$name." />";
						$input .= "<br>";
						$input .= "<label>Video Description</label>";
						$input .= "<br>";
						$input .= "<textarea name="."des_".$name."></textarea>";
						$input .= "<br>";
						$input .= "<br>";

						// defining tmp folder path
						$tmpFolder = "Views/tmp_course/".$course_name."/";

						// storing in tmp folder
						move_uploaded_file(
							$tmp_videos[$i], 
							$tmpFolder.$video
						);
					}
				}

				// assigning inputs into videoInfo session
				$_SESSION['videosInfo'] = $input;

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

				for($i=2; $i<count($array); $i+=3) {
					// getting video info
					$path = $array[$i];
					$title = $array[$i+1];
					$des = $array[$i+2];

					// query for insert video info
					$sql = $videoModel
					->insert(
						'video_title, video_description, video_path, course_id',
						[$title, $des, $path, $course_id]
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

				// updating course upload status
				$sql = $videoModel
				->table('course')
				->update('uploaded', true)
				->where('course_id', $course_id)
				->getQuery();
				$videoModel->run($sql);
			}
		}

		// redirecting to instructor/insertCoursePage
		$this->redirect('instructor/insertCoursePage');
	}

	// viewing videos by course
	public function view($id) {
		// instance video model
		$videoModel = new VideoModel();

		// query for fetching videos
		$sql = $videoModel->select('*')->where('course_id', $id)->getQuery();
		$data = $videoModel->fetch($sql);

		// exporting data to view
		$this->view->videos = $data;
		$this->view->render('Instructor/viewVideo');
	}

	// updating videos and respective info
	public function updateVideo() {
		// instance video model
		$videoModel = new VideoModel();

		if ((isset($_SESSION['videos']) && isset($_SESSION['course_id'])) || isset($_SESSION['deleted'])) {
			// query for fetching video info
				$sql = $videoModel->select('*')->where('course_id', $_SESSION['course_id'])->getQuery();
				$videos = $videoModel->fetch($sql);

				// exporting data to view
				$_SESSION['videos'] = $videos;
				$this->view->render('Instructor/videoUpdatePage');
		}

		if (isset($_POST['toUpdateVideo'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {

				$course_id = $_POST['course_id'];

				// query for fetching video info
				$sql = $videoModel->select('*')->where('course_id', $course_id)->getQuery();
				$videos = $videoModel->fetch($sql);

				// exporting data to view
				$_SESSION['videos'] = $videos;
				$_SESSION['course_id'] = $course_id;
				$this->view->render('Instructor/videoUpdatePage');
			}
		}
	}

	// Updating Individual Videos
	public function updateDeleteVideos() {

		// instance video model
		$videoModel = new VideoModel();

		// Deleting Videos
		if (isset($_POST['deleteVideo'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {
				$id = $_POST['video_id'];
				$path = $_POST['path'];

				// query for deleting video
				$sql = $videoModel
				->delete()
				->where('video_id', $id)
				->getQuery();
				$videoModel->run($sql);

				// deleting video file
				$actualPath = "Views/courses/".$path;
				unlink($actualPath);

				// redirecting to video update page
				$_SESSION['deleted'] = "deleted";
				$this->redirect('instructor/videoUpdate');

			}
		}

		// Updating Videos
		if (isset($_POST['updateVideo'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {
				$id = $_POST['video_id'];
				$title = $_POST['title'];
				$desc = $_POST['desc'];
				$path = $_POST['path'];
				$video = $_FILES['video']['name'];
				$tmp_video = $_FILES['video']['tmp_name'];

				if (empty($video)) {
					// query for deleting video
					$sql = $videoModel
					->update(
						'video_title, video_description, video_path',
						[$title, $desc, $path]
					)
					->where('video_id', $id)
					->getQuery();
					$videoModel->run($sql);
				}else {
					if (Security::escapeFile($video) == true) {
						$path;
						$course = explode('/',$path);
						$course = $course[0];
						$courseFolder = "Views/courses/".$course;
						$video = Security::setFilename($video);

						// deleting previous video
						unlink("Views/courses/".$path);

						// replacing video file
						move_uploaded_file(
							$tmp_video, 
							$courseFolder."/".$video
						);
					}
					$video_path = $course."/".$video;

					// query for deleting video
					$sql = $videoModel
					->update(
						'video_title, video_description, video_path',
						[$title, $desc, $video_path]
					)
					->where('video_id', $id)
					->getQuery();
					$videoModel->run($sql);
				}

				// redirecting to video update page
				$this->redirect('instructor/videoUpdate');

			}
		}

	}

}

 ?>

