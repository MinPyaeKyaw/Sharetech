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
				
				// query for inserting course
				$sql = $courseModel->insert('course_name, course_description, course_cover, instructor_id, category_id', [$course_name, $course_description, $course_cover, $inst_id, $cat_id])->getQuery();
				$courseModel->run($sql);

				// redirecting to insert page
				$this->redirect('instructor/insertCoursePage');

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
				$sql = $courseModel->update('course_name, course_description, course_cover, updated_at', [$course_name, $course_description, $course_cover, 'now()'])->where('course_id', $course_id)->getQuery();
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

