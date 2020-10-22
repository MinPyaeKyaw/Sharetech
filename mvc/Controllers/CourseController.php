<?php 

// beginning of the Course Controller class
class CourseController extends Controller {

	// to insert page
	public function insertPage() {
		$this->view->render("Instructor/uploadCourse/insertCoursePage");
	}

	// insert course
	public function insertCourse() {
		// instance course model
		$courseModel = new CourseModel();

		if (isset($_POST['uploadCourse'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {

				$inst_id            = $_POST['inst_id'];
				$cat_id             = $_POST['cat_id'];
				$course_name        = $_POST['course_name'];
				$course_description = $_POST['course_description'];
				$course_cover       = $_FILES['course_cover']['name'];
				$tmp_course_cover   = $_FILES['course_cover']['tmp_name'];
				
				// defining tmp folder path
				$tmpFolder = "Views/tmp_course/";
				// getting id to avoid duplication in tmp folder
				$id = count(scandir($tmpFolder));

				// creating course folder in tmp folder
				mkdir($tmpFolder.$id.'_'.$course_name);
				mkdir($tmpFolder.$id.'_'.$course_name."/cover");

				if (Security::escapeFile($course_cover) == true) {

					// storing in tmp folder
					move_uploaded_file(
						$tmp_course_cover, 
						$tmpFolder.$id.'_'.$course_name."/cover/".$course_cover
					);

					// query for inserting course
					$sql = $courseModel
					->insert(
						'course_name,course_description,course_cover, instructor_id,category_id', 
						[$course_name,$course_description,$course_cover,$inst_id, $cat_id]
					)
					->getQuery();
					$courseModel->run($sql);

					// query for getting course id for vedio upload
					$sql = $courseModel->select('course_id')->where('instructor_id', $inst_id)->where('course_name', $course_name)->getQuery();

					// getting courseId
					$courseId = '';
					foreach ($courseModel->fetch($sql) as $value) {
						$courseId = $value['course_id'];
					}

					// exporting data to view
					$this->view->course_id = $courseId;
					$this->view->course = $id.'_'.$course_name;
					$this->view->render('Instructor/insertVideoPage');
				}
			}
		}
	}

	// viewing all courses
	public function viewAll() {
		// instance course model
		$courseModel = new CourseModel();
		// instance category model
		$categoryModel = new CategoryModel();

		// query for fetching category
		$sqlCat = $categoryModel->select("*")->getQuery();
		// query for viewing all course
		$sql = $courseModel->select('*')->getQuery();

		// exporting to view
		$this->view->cats    = $categoryModel->fetch($sqlCat);
		$this->view->courses = $courseModel->fetch($sql);
		$this->view->render('Instructor/viewAllCourse');

	}

	// view by instructor
	public function viewByInst() {
		// instance course model
		$courseModel = new CourseModel();

		// query for viewing all course
		$sql = $courseModel->select('*')->where('instructor_id', 4)->getQuery();

		// exporting to view
		$this->view->courses = $courseModel->fetch($sql);
		$this->view->render('Instructor/viewByInst');
	}

	// view by category
	public function viewByCat($id) {
		// instance course model
		$courseModel = new CourseModel();

		// query for viewing all course
		$sql = $courseModel->select('*')->where('category_id', $id)->getQuery();

		// exporting to view
		$this->view->courses = $courseModel->fetch($sql);
		$this->view->render('Instructor/viewByCategory');
	}

	// update courses
	public function updateCoursePage() {
		// instance course model
		$courseModel = new CourseModel();

		if(isset($_POST['updateSubmit'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {

				$courseId = $_POST['course_id'];

				// query for getting course info
				$sql = $courseModel->select('*')->where('course_id', $courseId)->getQuery();

				// exporting to view
				$this->view->courseInfo = $courseModel->fetch($sql);
				$this->view->render("Instructor/updateCourse");
			
			}
		}

	}

	// Updating course
	public function updateCourse() {
		// instance course model
		$courseModel = new CourseModel();

		if(isset($_POST['updateCourse'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {

				$course_id = $_POST['course_id'];
				$course_name = $_POST['course_name'];
				$course_description = $_POST['course_description'];
				$course_cover = $_FILES['course_cover']['name'];

				// query for updating course
				$sql = $courseModel
				->update(
					'course_name,course_description,course_cover,updated_at', 
					[$course_name,$course_description,$course_cover, 'now()']
				)
				->where('course_id', $course_id)
				->getQuery();
				$courseModel->run($sql);

				// need to delete videos in video table

				// redirecting to all view courses
				$this->redirect('instructor/viewAllCourse');
			
			}
		}
	}

	// deleting course
	public function deleteCourse() {
		// instance course model
		$courseModel = new CourseModel();

		if(isset($_POST['deleteSubmit'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {

				$course_id = $_POST['course_id'];

				// query for deleting course
				$sql = $courseModel->delete()->where('course_id', $course_id)->getQuery();
				$courseModel->run($sql);

				// redirecting to all view courses
				$this->redirect('instructor/viewAllCourse');
			
			}
		}
	}

}

 ?>

