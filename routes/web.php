<?php

/*
|--------------------------------------------------------------------------
| IMPORTANT NOTE
|--------------------------------------------------------------------------
|
| So that only logged in users can access the app, *we must route every request
| through a controller*. The Controller class (parent class of all controllers)
| applies the auth middleware to accomplish so.
|
*/

Auth::routes(['verify' => false]);

Route::get('/', 'UserPagesController@home');
Route::get('/profile', 'UserPagesController@profile');
Route::get('/advisory', 'AdvisorPagesController@advisory');
Route::get('/history/{student}', 'AdvisorPagesController@history');

Route::get('/sign-in', 'StudentPagesController@signIn');
Route::get('/sign-out', 'StudentPagesController@signOut');
Route::post('/sign-in', 'TripController@signIn');
Route::post('/sign-out', 'TripController@signOut');

Route::post('/authorise-overnight/{student}', 'OvernightAuthorisationController@store');
Route::post('/revoke-overnight/{student}', 'OvernightAuthorisationController@destroy');

Route::get('/absences', 'AbsenceController@index');
Route::post('/absences', 'AbsenceController@store');
Route::get('/absences/create', 'AbsenceController@create');
Route::get('/absences/user/{user}', 'AbsenceController@history');
Route::post('/absences/{absence}/approve', 'AbsenceController@approve');
Route::post('/absences/{absence}/reject', 'AbsenceController@reject');

Route::resource('advisors', 'AdvisorController')->except(['index', 'show', 'destroy']);
Route::resource('students', 'StudentController')->except(['show', 'destroy']);
Route::resource('users', 'UserController')->except(['store', 'create']);
Route::resource('posts', 'PostController')->except(['show']);
