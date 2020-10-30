<?php 

// beginning of the Category Controller class
class CategoryController extends Controller {

	// to insert page
	public function insertPage() {
		$this->view->render("Category/insertCategory");
	}

	// inserting category
	public function insertCategory() {

		// instancing category model
		$categoryModel = new CategoryModel();

		if (isset($_POST['insertCat'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {
				$category = $_POST['category'];
				
				// query for inserting category
				$sql = $categoryModel->insert('category', $category)->getQuery();
				$categoryModel->run($sql);

				// redirecting to insertCatPage
				$this->redirect('insertCatPage');

			}
		}

	}

	// fetching category
	public function fetchCategory() {

		// instancing category model
		$categoryModel = new CategoryModel();

		// query for fetching category
		$sql = $categoryModel->select('*')->getQuery();

		// exporting fetched data to view
		$this->view->cats = $categoryModel->fetch($sql);
		$this->view->render('Category/viewCategory');

	}

	// deleting category
	public function deleteCategory() {

		// instancing category model
		$categoryModel = new CategoryModel();

		if (isset($_POST['deleteCat'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {
				$catId = $_POST['catId'];

				// query for deleting category
				$sql = $categoryModel->delete()->where('category_id', $catId)->getQuery();
				$categoryModel->run($sql);

				// redirecting to category view
				$this->redirect('fetchCat');

			}
		}

	}

	// updating category page
	public function updateCategoryPage() {

		// instancing category model
		$categoryModel = new CategoryModel();

		if (isset($_POST['updateCat'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {

				// exporting data to update view
				$this->view->catId = $_POST['catId'];
				$this->view->cat = $_POST['cat'];
				$this->view->render('Category/updateCategory');

			}
		}

	}

	// updating category
	public function updateCategory() {

		// instancing category model
		$categoryModel = new CategoryModel();

		if (isset($_POST['updateCat'])) {
			if(Security::verifyCSRF($_POST['csrf']) == true) {
				$catId = $_POST['catId'];
				$cat   = $_POST['cat'];

				// query for updating category
				$sql = $categoryModel->update('category', $cat)->where('category_id', $catId)->getQuery();
				$categoryModel->run($sql);

				// redirecting to category view
				$this->redirect('fetchCat');

			}
		}
	}
}

 ?>

