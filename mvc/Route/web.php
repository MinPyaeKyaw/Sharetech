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

// Route::go("fetchCat","CategoryController@fetchCategory");

Route::go("deleteCat","CategoryController@deleteCategory");

Route::go("updateCatPage","CategoryController@updateCategoryPage");
Route::go("updateCat","CategoryController@updateCategory");

/*-
----
CRUD for Course
*/
Route::go("instructor/insertCoursePage", "CourseController@insertPage");
Route::go("instructor/insertCourse", "CourseController@insertCourse");

Route::go("instructor/viewAllCourse", "CourseController@viewAll");
Route::go("instructor/viewByInst", "CourseController@viewByInst");
Route::go("instructor/viewByCat/$id", "CourseController@viewByCat");

Route::go("instructor/updatePage", "CourseController@updateCoursePage");
Route::go("instructor/updateCourse", "CourseController@updateCourse");

Route::go("instructor/deleteCourse", "CourseController@deleteCourse");

/*-
----
CRUD for Video
*/
Route::go("instructor/editUploadedVideo", "VideoController@insertIndivitualPage");
Route::go("instructor/finalUpload", "VideoController@insertIndivitualVideo");

Route::go("course/$id", "VideoController@view");

Route::go("instructor/videoUpdate", "VideoController@updateVideo");
Route::go("instructor/updateDeleteVideos", "VideoController@updateDeleteVideos");

Route::api("api/v1/cat", "CategoryController@fetchCategory");

 ?>