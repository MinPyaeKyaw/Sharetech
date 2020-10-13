<?php 


/*-
----
Instructor page routes
*/
Route::go('createCoursePage', 'CourseController@createPage');
Route::go('createCourseProcess', 'CourseController@createProcess');


/*-
----
CRUD for category
*/
Route::go("insertCatPage","CategoryController@insertPage");
Route::go("insertCat","CategoryController@insertCategory");

Route::go("fetchCat","CategoryController@fetchCategory");

Route::go("deleteCat","CategoryController@deleteCategory");

Route::go("updateCatPage","CategoryController@updateCategoryPage");
Route::go("updateCat","CategoryController@updateCategory");

 ?>