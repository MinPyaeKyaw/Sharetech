<?php 

// beginning of the Course Controller class
class CourseController extends Controller {

	public function home() {

		$courseModel = new CourseModel();

		$sql = $courseModel->select('*')->orderBy('id', 'desc')->getQuery();




		$courseModel->run($sql);

		$this->view->render('course/home', 'courseLayout');
	}

	/*-
	----
	Login Process
	*/
	public function loginProcess() {
		if (isset($_POST['login'])) {
			$email = $_POST['email'];
			$pass  = $_POST['password'];

			$statement = AdminAuthentication::login($email, $pass);

			if ($statement == true) {
				$this->redirect('dashboard');
			}else {
				$this->redirect('adminLogin');
			}
		}
	}

	public function signupProcess() {
		if (isset($_POST['signup'])) {
			$name = $_POST['username'];
			$mail = $_POST['mail'];
			$pass = $_POST['password'];
			$statement = AdminAuthentication::signup($name, $mail, $pass);


			if ($statement == true) {
				$this->redirect('adminLogin');	
			}else {	
				$this->redirect('adminSignup');	
			}
		}
	}

	public function testingCSRF() {
		$user = new UserModel();

		if (isset($_POST['submit'])) {
			if (Security::verifyCSRF($_POST['csrf']) == true) {
				echo "Yo! you are secured.";
			}	
		}	
	}

	public function testForm() {
		$data;
		if(isset($_POST['submit'])) {
			$data = $_POST['text'];
		}

		$this->view->data = $data;
		$this->view->render('course/home', 'courseLayout');
	}

}

 ?>

