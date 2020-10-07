<?php 


/*-
----
Admin Authentication
*/
Route::go('adminLogin', 'AdminController@login');
Route::go('adminSignup', 'AdminController@signup');
Route::go('signupProcess', 'AdminController@signupProcess');
Route::go('loginProcess', 'AdminController@loginProcess');
Route::go('adminLogout', 'AdminController@logout');


 ?>