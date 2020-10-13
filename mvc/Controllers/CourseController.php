<?php 

// beginning of the Course Controller class
class CourseController extends Controller {

	// Creating courses
	public function createPage() {

		// instance category model
		$categoryModel = new CategoryModel();

		// query fetching category data
		$sql = $categoryModel->select('*')->getQuery();

		// exporting category data to view
		$this->view->cats = $categoryModel->fetch($sql);
		$this->view->render("Instructor/courseUpload");
	}

	// Process for creating courses
	public function createProcess() {

		// instance course model
		$courseModel = new CourseModel();

		if(isset($_POST['submit'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {
				$name = $_POST['course_name'];
				$desc = $_POST['course_description'];
				$cat_id = $_POST['cat'];
				$cover = 'sad.jpg';

				// query for inserting course data
				$sql = $courseModel->insert('course_name, course_description, course_cover, instructor_id, category_id', [$name, $desc, $cover, 4, $cat_id])->getQuery();
				$courseModel->run($sql);

				// redirecting to ...
				$this->redirect('createCoursePage');
			}
		}
	}

}

 ?>

