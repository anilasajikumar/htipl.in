<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset');



Route::group(['middleware' =>['auth'], 'prefix' =>'dashboard', 'namespace' => 'Admin'],function(){

Route::get('/', 'AdminController@index')->name('home');
Route::get('change-password','AdminController@changePasswordForm')->name('admin.change_password');
Route::post('change-password','AdminController@changePassword')->name('admin.save_password');
Route::resource('online-course', 'OnlineCourseController');
Route::get('courses','OnlineCourseController@getdata')->name('course_data');
Route::get('trash/online-courses','OnlineCourseController@viewDeletedCourses')->name('trash.online_course');
Route::get('trash/online-courses-data','OnlineCourseController@getDeletedCoursesData')->name('trash.online_course.data');
Route::get('students/create', 'OnlineCourseController@studentcreate')->name('student.create');
Route::post('students/register', 'OnlineCourseController@onlinestudentregister')->name('online.student.register');
Route::get('students/registerlist', 'OnlineCourseController@registerlist')->name('online.student.registerlist');
Route::get('/students/{id}/edit', 'OnlineCourseController@registeredit')->name('student.registeredit');
Route::post('/students/{id}', 'OnlineCourseController@registerupdate')->name('student.registerupdate');

Route::post('/students/{id}/delete', 'OnlineCourseController@registerdestroy')->name('student.registerdestroy');

Route::post('/student/certificate-complete', 'OnlineCourseController@certificatecomplete')->name('student.certificatecomplete');

Route::get('/students/search/ajax', 'OnlineCourseController@ajaxSearch')->name('student.ajaxSearch');





Route::get('online-courses/restore/{id}','OnlineCourseController@Restore')->name('online-course.restore');

Route::resource('category', 'CategoryController');
Route::get('categories','CategoryController@getdata')->name('category_data');
Route::get('trash/category','CategoryController@viewDeletedCategory')->name('trash.category');
Route::get('trash/category-data','CategoryController@getDeletedCategoryData')->name('trash.category.data');
Route::get('category/restore/{id}','CategoryController@Restore')->name('category.restore');

Route::resource('corporate-course', 'CorporateCourseController');
Route::get('corporate-courses','CorporateCourseController@getdata')->name('corporate-course_data');
Route::get('trash/corporate-courses','CorporateCourseController@viewDeletedCourses')->name('trash.corporate_course');
Route::get('trash/corporate-courses-data','CorporateCourseController@getDeletedCoursesData')->name('trash.corporate_course.data');

Route::get('corporate-courses/restore/{id}','CorporateCourseController@Restore')->name('corporate-course.restore');

Route::resource('corporate-category', 'CorporateCategoryController');
Route::get('corporate-categories','CorporateCategoryController@getdata')->name('corporate-category_data');
Route::get('trash/corporate-category','CorporateCategoryController@viewDeletedCategory')->name('trash.corporate-category');
Route::get('trash/corporate-category-data','CorporateCategoryController@getDeletedCategoryData')->name('trash.corporate-category.data');
Route::get('corporate-category/restore/{id}','CorporateCategoryController@Restore')->name('corporate-category.restore');

Route::resource('exam', 'ExamController');
Route::get('exams','ExamController@getdata')->name('exam_data');
Route::get('trash/exam','ExamController@viewDeletedExams')->name('trash.exam');
Route::get('trash/exam-data','ExamController@getDeletedExamsData')->name('trash.exam.data');
Route::get('exam/restore/{id}','ExamController@Restore')->name('exam.restore');

Route::resource('center', 'CenterController');
Route::get('centers','CenterController@getdata')->name('center_data');
Route::get('trash/study-center','CenterController@viewDeletedCenters')->name('trash.study_center');
Route::get('trash/study-center-data','CenterController@getDeletedCentersData')->name('trash.study_center.data');
Route::get('center/restore/{id}','CenterController@Restore')->name('center.restore');
Route::get('center-password/{id}','CenterController@CenterPassword')->name('center.password');
Route::post('center-password/{id}','CenterController@changeCenterPassword')->name('center.password.change');

Route::resource('news-event', 'NewsAndEventController');
Route::get('news-events','NewsAndEventController@getdata')->name('news_event_data');

Route::resource('client', 'ClientController');
Route::get('clients','ClientController@getdata')->name('client_data');

Route::resource('testimonial', 'TestimonialController');
Route::get('testimonials','TestimonialController@getdata')->name('testimonial_data');

Route::resource('location', 'LocationController');
Route::get('locations','LocationController@getdata')->name('location_data');
Route::get('trash/location','LocationController@viewDeletedLocation')->name('trash.location');
Route::get('trash/location-data','LocationController@getDeletedLocationData')->name('trash.location.data');
Route::get('location/restore/{id}','LocationController@Restore')->name('location.restore');

Route::resource('center-course', 'CenterOnlineCourseController');
Route::get('center-courses','CenterOnlineCourseController@getdata')->name('center_course_data');

Route::get('center-courses/requests','CenterOnlineCourseController@centerCourseRequests')->name('center-course.requests');
Route::get('center-courses/requests/data','CenterOnlineCourseController@centerCourseRequestsData')->name('center-course.requests.data');

Route::get('center-courses/trash','CenterOnlineCourseController@centerCourseTrash')->name('center-course.trash');
Route::get('center-courses/trash/data','CenterOnlineCourseController@centerCourseTrashData')->name('center-course.trash.data');
Route::get('center-courses/restore/{id}','CenterOnlineCourseController@Restore')->name('center-course.restore');

Route::get('center-courses/requests/approve/{id}','CenterOnlineCourseController@centerCourseRequestsApprove')->name('center-course.requests.approve');
Route::get('center-courses/requests/reject/{id}','CenterOnlineCourseController@centerCourseRequestsReject')->name('center-course.requests.reject');

Route::resource('center-exam', 'CenterExamController');
Route::get('center-exams','CenterExamController@getdata')->name('center_exam_data');

Route::get('center-exams/trash','CenterExamController@centerExamTrash')->name('center-exam.trash');
Route::get('center-exams/trash/data','CenterExamController@centerExamTrashData')->name('center-exam.trash.data');
Route::get('center-exams/restore/{id}','CenterExamController@Restore')->name('center-exam.restore');

Route::get('center-exams/students/{id}','CenterExamController@centerExamStudents')->name('center_exam.students');
Route::get('center-exams/students/data/{id}','CenterExamController@centerExamStudentsData')->name('center_exam.students.data');

Route::get('completed-exams/students/{id}','CenterExamController@completedExamStudents')->name('completed_exam.students');
Route::get('completed-exams/students/data/{id}','CenterExamController@completedExamStudentsData')->name('completed_exam.students.data');

Route::get('result-published/students/{id}','CenterExamController@ResultPublishedStudents')->name('result_published_students');
Route::get('result-published/students/data/{id}','CenterExamController@ResultPublishedStudentsData')->name('result_published_students.data');

Route::get('download/result-file/{id}','CenterExamController@downloadResultFile')->name('download.result_file');
Route::get('download/certificate/{id}','CenterExamController@downloadCertificate')->name('download.certificate');

Route::get('answer-sheet/{id}','CenterExamController@ViewAnswers')->name('view_answers');
Route::get('download/answer-file/{id}','CenterExamController@downloadAnswerFile')->name('download.answer_file');

Route::get('pending-exam','CenterExamController@pendingExam')->name('admin.pending_exam');
Route::get('pending-exams','CenterExamController@pendingExamData')->name('admin.pending_exam_data');

Route::get('active-exam','CenterExamController@activeExam')->name('admin.active_exam');
Route::get('active-exams','CenterExamController@activeExamData')->name('admin.active_exam_data');

Route::get('completed-exam','CenterExamController@completedExam')->name('admin.completed_exam');
Route::get('completed-exams','CenterExamController@completedExamData')->name('admin.completed_exam_data');

Route::get('result-published-exam','CenterExamController@ResultPublishedExam')->name('admin.result_published_exam');
Route::get('result-published-exams','CenterExamController@ResultPublishedExamData')->name('admin.result_published_exam_data');

Route::get('live-exam','CenterExamController@liveExam')->name('admin.live_exam');
Route::get('live-exams','CenterExamController@liveExamData')->name('admin.live_exam_data');

Route::get('center-exam-payment/{id}','CenterExamController@centerExamPayment')
->name('center_exam_payment');

Route::get('closed-exam','CenterExamController@closedExam')->name('admin.closed_exam');
Route::get('closed-exams','CenterExamController@closedExamData')->name('admin.closed_exam_data');
Route::get('center-exam-invoice/{id}','CenterExamController@centerExamInvoice')
->name('center_exam_invoice');

Route::get('approve-exam/{id}','CenterExamController@approvePendingExam')->name('center-exam.approve');

Route::resource('course-module', 'CourseModuleController');
Route::get('course-modules','CourseModuleController@getdata')->name('course_module_data');

Route::resource('course-media', 'CourseMediaController');
Route::get('course-media-data','CourseMediaController@getdata')->name('course_media_data');

Route::resource('media-link', 'MediaLinkController');
Route::get('media-link-data','MediaLinkController@getdata')->name('media_link_data');

Route::post('media/upload-media', 'CourseMediaController@uploadFile')->name('media.upload');

Route::resource('course-exam', 'CourseExamController');
Route::get('course-exams','CourseExamController@getdata')->name('course_exam_data');
Route::get('course-exams/trash','CourseExamController@viewDeletedCourseExam')->name('course-exam.trash');
Route::get('course-exams/trash/data','CourseExamController@getDeletedCourseExam')->name('course-exam.trash.data');
Route::get('course-exams/restore/{id}','CourseExamController@Restore')->name('course-exam.restore');


Route::get('questions/{id}','CourseExamController@addQuestions')->name('course-exam.questions');
Route::post('questions/{id}','CourseExamController@saveQuestions')->name('questions.store');
Route::get('question-data/{id}','CourseExamController@QuestionsData')->name('questions_data');

Route::resource('question','QuestionController');

Route::get('/category/course/{id}','OnlineCourseController@getCourseByCategory');
Route::get('/course/course-module/{id}','CourseModuleController@getModuleByCourse');

Route::get('result/upload/{id}','CenterExamController@uploadResultFile')->name('result.upload');
Route::post('result/upload/{id}','CenterExamController@SaveResultFile')->name('result_files.save');

Route::get('completed-exam/make-published/{id}','CenterExamController@MakeExamAsPublished')->name('completed.exams.published');

Route::resource('exam-unit','ExamUnitController');
Route::get('exam-unit-data','ExamUnitController@getdata')->name('exam_unit_data');

Route::get('hall-ticket-list/{id}','CenterExamController@hallticketList')->name('admin.hall_ticket.students');
Route::get('hall-ticket-list-data/{id}','CenterExamController@hallticketListData')->name('admin.hall_ticket.students_data');
Route::get('hall-ticket/download/{id}','CenterExamController@downloadHallTickets')->name('admin.hall_tickets.download');

Route::resource('downloads','DownloadController');
Route::get('downloads-data','DownloadController@getdata')->name('downloads_data');

Route::get('online-course-students','OnlineCourseController@courseStudents')->name('online-course-students');
Route::get('online-course-certificate/{id}','OnlineCourseController@courseCertificate')->name('online_course_certificate');

Route::get('files/{id}','FileController@create')->name('files');
Route::patch('store-files/{id}','FileController@store')->name('store.files');

Route::get('edit-register-number/{id}','FileController@studentRegister')->name('edit_register');
Route::post('edit-register-number/{id}','FileController@updateStudentRegister')->name('update_register');

Route::resource('course-calender', 'CourseCalenderController');
Route::get('course-calenders','CourseCalenderController@getdata')->name('course-calender_data');

Route::get('/study_center/course/{id}','OnlineCourseController@getCourseByCenter');

Route::resource('alert','AlertController');
Route::get('alert-data','AlertController@getdata')->name('alert_data');

Route::get('student-status/{id}','OnlineCourseController@changeStudentStatus')->name('student.status');

Route::get('student/remove/{id}','OnlineCourseController@removeStudent')->name('student.remove');

Route::resource('placements', 'PlacementController')->except(['show']);
Route::get('placements/report','PlacementController@report')->name('placements.report');

Route::get('diploma','DiplomaController@index')->name('diploma.index');
Route::get('diploma/create','DiplomaController@create')->name('diploma.create');
Route::post('diploma','DiplomaController@store')->name('diploma.store');
Route::delete('diploma/{id}','DiplomaController@destroy')->name('diploma.destroy');

Route::get('/enquiryreport','AdminController@enquiryreport')->name('enquiry.index');

Route::get('enquiry-form/export','AdminController@export')->name('enquiry.export');

Route::delete('enquiry-form/destroy','AdminController@destroy')->name('enquiry.destroy');

Route::get('/video-testimonial','VideoTestimonialController@index')->name('video-testimonial.index');

Route::get('/video-testimonial/create','VideoTestimonialController@create')->name('video-testimonial.create');

Route::post('/video-testimonial/store','VideoTestimonialController@store')->name('video-testimonial.store');

Route::delete('/video-testimonial/{id}','VideoTestimonialController@destroy')->name('video-testimonial.delete');

Route::get('/examupload','ExamUploadController@index')->name('examupload.index');
Route::get('/examupload/create','ExamUploadController@create')->name('examupload.create');
Route::post('/examupload/store','ExamUploadController@store')->name('examupload.store');
Route::get('/examupload/{id}/submissions','ExamUploadController@submissions')->name('examupload.submissions');
Route::get('/examuplaod/report', 'ExamUploadController@report')->name('examupload.report');

Route::get('/hero', 'HeroSectionController@index')->name('hero.index');
Route::get('/hero/data', 'HeroSectionController@data')->name('hero.data');
Route::get('/hero/create', 'HeroSectionController@create')->name('hero.create');
Route::post('/hero/store', 'HeroSectionController@store')->name('hero.store');
Route::get('/hero/{id}/edit', 'HeroSectionController@edit')->name('hero.edit');
Route::put('/hero/{id}', 'HeroSectionController@update')->name('hero.update');
Route::delete('/hero/{id}', 'HeroSectionController@destroy')->name('hero.destroy');

Route::resource('accreditation', 'AccreditationController');
Route::get('accreditations','AccreditationController@getdata')->name('accreditation_data');

Route::resource('country', 'CountryController');
Route::get('countries','CountryController@getdata')->name('country_data');
Route::get('trash/country','CountryController@viewDeletedCountry')->name('trash.country');
Route::get('trash/country-data','CountryController@getDeletedCountryData')->name('trash.country.data');
Route::get('country/restore/{id}','CountryController@Restore')->name('country.restore');

Route::resource('m-category', 'MainCategoryController');
Route::get('main-categories','MainCategoryController@getdata')->name('main_category_data');
Route::get('trash/main-category','MainCategoryController@viewDeletedCategory')->name('trash.main_category');
Route::get('trash/main-category-data','MainCategoryController@getDeletedCategoryData')->name('trash.main_category.data');
Route::get('main-category/restore/{id}','MainCategoryController@Restore')->name('main_category.restore');

Route::resource('footer', 'FooterController');

Route::get('/announcement','AnnouncementController@index')->name('announcement.index');
Route::post('/announcement','AnnouncementController@store')->name('announcement.store');

Route::resource('batch', 'BatchDataController');
Route::get('batch-data','BatchDataController@getdata')->name('batch_data');

Route::resource('trainor', 'TrainorController');
Route::get('trainor/{id}/toggle-status','TrainorController@toggleStatus')->name('trainor.toggle-status');
Route::get('trainor/{id}/edit-password','TrainorController@editPassword')->name('trainor.edit-password');
Route::patch('trainor/{id}/update-password','TrainorController@updatePassword')->name('trainor.update-password');

Route::get('assessment','AssessmentController@index')->name('admin.assessment.index');
Route::get('assessment/{id}','AssessmentController@show')->name('admin.assessment.show');
Route::get('assessment-submissions','AssessmentController@submissions')->name('admin.assessment.submissions');
Route::get('assessment-submissions/{id}','AssessmentController@submissionDetail')->name('admin.assessment.submission');

Route::get('employees','EmployeeController@index')->name('employees.index');
Route::get('employees/create','EmployeeController@create')->name('employees.create');
Route::post('employees','EmployeeController@store')->name('employees.store');
Route::delete('employees/{id}','EmployeeController@destroy')->name('employees.destroy');
Route::post('employees/update-password','EmployeeController@updatePassword')->name('employees.updatePassword');
Route::get('employees/reset-password/{id}','EmployeeController@resetPassword')->name('employees.resetPassword');

Route::resource('masterdocumentdata', 'MasterDocumentDataController');
Route::get('masterdocumentdata-data','MasterDocumentDataController@getdata')->name('masterdocumentdata_data');

Route::get('invoice','InvoiceController@index')->name('invoice.index');
Route::get('invoice/data','InvoiceController@studentInvoiceData')->name('invoice.data');
Route::get('invoice/export','InvoiceController@export')->name('invoice.export');
Route::get('invoice/create/{id}','InvoiceController@create')->name('invoice.create');
Route::post('invoice','InvoiceController@store')->name('invoice.store');
Route::get('invoice/view/{id}','InvoiceController@view')->name('invoice.view');
Route::get('invoice/download/{id}','InvoiceController@download')->name('invoice.download');
Route::get('invoice/send-mail/{id}','InvoiceController@sendMail')->name('invoice.send.mail');
Route::get('invoice/{id}/edit','InvoiceController@edit')->name('invoice.edit');
Route::put('invoice/{id}','InvoiceController@update')->name('invoice.update');
Route::get('invoice-account-setting','InvoiceAccountSettingController@edit')->name('invoice.account.edit');
Route::post('invoice-account-setting','InvoiceAccountSettingController@update')->name('invoice.account.update');

Route::resource('enquiry-form', 'EnquiryFormController');
Route::get('enquiry-form-data','EnquiryFormController@getdata')->name('enquiry_form_data');
Route::post('postdata','EnquiryFormController@postdata')->name('postdata');












});


 /*------------------------------ Center --------------------------- */

                  

/**
		*Center Forgot Password Form.
		*Center Forgot Password.
		*Center Reset Password Form.
		*Reset Password.
		*/
Route::post('study-center/password/email','Center\Auth\ForgotPasswordController@sendResetLinkEmail')->name('study-center.password.email');
Route::get('study-center/password/reset','Center\Auth\ForgotPasswordController@showLinkRequestForm')->name('study-center.password.request');
Route::post('study-center/password/reset','Center\Auth\ResetPasswordController@reset');
Route::get('study-center/password/reset/{token}','Center\Auth\ResetPasswordController@showResetForm')->name('study-center.password.reset');


	/**
	*Center Login Form.
	*Center Login.
	*/
Route::get('study-center/login', 'Center\Auth\CenterLoginController@showLoginForm')->name('study-center.login');
Route::post('study-center/login', 'Center\Auth\CenterLoginController@login')->name('study-center.login.submit');

	/**
	*Center Protected Routes Starts Here.
	*Only Centers Can Access.
	*Middleware:study-center.
	*prefix:study-center-dashboard.
	*/
Route::group(['middleware' =>['center'], 'prefix' =>'study-center', 'namespace' => 'Center'],function(){

	/**
	*StudyCenter Home.
	*Change Password.
	*routes.
	*/ 
	Route::get('/dashboard','StudyCenterController@index')->name('study-centers');
	Route::get('change-password','StudyCenterController@changePasswordForm')->name('study-center.change_password');
	Route::post('change-password','StudyCenterController@changePassword')->name('study-center.save_password');

	Route::get('/my-course','StudyCenterController@myCourses')->name('my_course');
	Route::get('/my-courses','StudyCenterController@getMyCourseData')->name('my_course_data');

	Route::get('my-course/increase-limit/{slug}','StudyCenterController@increaseLimitForm')->name('increase_limit_form');
	Route::post('my-course/increase-limit','StudyCenterController@increaseLimit')->name('increase_limit');

	Route::get('{slug}/enroll-course','StudyCenterController@enrollCourseStudents')->name('center_course.register');
	Route::get('enroll-student','StudyCenterController@enrollStudent')->name('enroll.student');
	Route::post('enroll-course/student','StudyCenterController@registerStudents')->name('student.register');

	Route::resource('study-center-exam','CenterExamController');
	Route::get('pending-exams','CenterExamController@pendingExamData')->name('pending_exam_data');
	Route::get('{slug}/enroll-exam','CenterExamController@ExamEnrollStudentForm')->name('study-center-exam.register-form');
	Route::post('enroll-exam','CenterExamController@ExamEnrollStudent')->name('study-center-exam.register');

	Route::get('active-exam','CenterExamController@activeExam')->name('active_exam');
	Route::get('active-exams','CenterExamController@activeExamData')->name('active_exam_data');

	Route::get('completed-exam','CenterExamController@completedExam')->name('completed_exam');
	Route::get('completed-exams','CenterExamController@completedExamData')->name('completed_exam_data');

	Route::get('closed-exam','CenterExamController@closedExam')->name('closed_exam');
	Route::get('closed-exams','CenterExamController@closedExamData')->name('closed_exam_data');

	Route::get('live-exam','CenterExamController@liveExam')->name('live_exam');
	Route::get('live-exams','CenterExamController@liveExamData')->name('live_exam_data');

	Route::get('result-published-exam','CenterExamController@ResultPublishedExam')->name('result_published_exam');
	Route::get('result-published-exams','CenterExamController@ResultPublishedExamData')->name('result_published_exam_data');

	Route::get('students/published-result/{id}','CenterExamController@ResultPublishedStudents')->name('students_result');
	Route::get('students/published-result-data/{id}','CenterExamController@ResultPublishedStudentsData')->name('students_result.data');

	Route::get('download/result-file/{id}','CenterExamController@downloadResultFile')->name('download.students_result');

	Route::get('download/student-certificate/{id}','CenterExamController@downloadCertificate')->name('download.students_certificate');

	Route::get('exam-date/{exam}','CenterExamController@dateData');

	Route::get('students-list/{id}','CenterExamController@studentListData')->name('exam_students_data');

	Route::get('invoice/{id}','CenterExamController@Invoice')->name('study-center-exam.invoice');

	Route::get('completed-exam/student/{id}','CenterExamController@completedExamStudents')->name('completed_exam_student');
	Route::get('completed-exam/students-list/{id}','CenterExamController@completedExamStudentsData')->name('completed_exam_students_data');

	Route::get('upload/answers/{id}','CenterExamController@uploadAnswerFile')->name('answer_papers.upload');
	Route::post('upload/answers/{id}','CenterExamController@SaveAnswerFile')->name('answer_files.save');
	Route::delete('answer-sheet/{id}','CenterExamController@DeleteAnswerFile')->name('answer_sheet.delete');

	Route::get('hall-ticket-list/{id}','CenterExamController@hallticketList')->name('hall_ticket.students');
	Route::get('hall-ticket-list-data/{id}','CenterExamController@hallticketListData')->name('hall_ticket.students_data');

	Route::get('hall-ticket/download/{id}','CenterExamController@downloadHallTickets')->name('hall_tickets.download');

	Route::get('online-course/active-students','StudyCenterController@activeStudents')->name('active_students');
	Route::get('online-course/active-students-data','StudyCenterController@activeStudentsData')->name('active_students_data');
	Route::get('student-password/{id}','StudyCenterController@studentPassword')->name('student.password');
	Route::post('student-password/{id}','StudyCenterController@changestudentPassword')->name('student.password.change');

	Route::get('online-course/completed-students','StudyCenterController@completedStudents')->name('completed_students');
	Route::get('online-course/completed-students-data','StudyCenterController@completedStudentsData')->name('completed_students_data');
	Route::get('online-course/students-certificate/{id}','StudyCenterController@StudentsCertificate')->name('students.certificate');

	Route::get('online-course/dropped-students','StudyCenterController@droppedStudents')->name('dropped_students');
	Route::get('online-course/dropped-students-data','StudyCenterController@droppedStudentsData')->name('dropped_students_data');

	Route::get('downloads-files','StudyCenterController@downloadsFiles')->name('downloads-files');
	Route::get('downloads-files-data','StudyCenterController@downloadsFilesData')->name('downloads-files-data');
	Route::get('downloads-file/{id}','StudyCenterController@downloadsFile')->name('downloads.files');

	Route::get('student-files/{id}','FileController@create')->name('center_student_files');
	Route::patch('store-student-files/{id}','FileController@store')->name('center_student_files_store');

	Route::get('student-register-number/{id}','FileController@studentRegister')->name('edit_student_register');
	Route::post('student-register-number/{id}','FileController@updateStudentRegister')->name('update_student_register');

});


Route::group(['namespace' => 'Web'],function(){

	Route::get('/','WebsiteController@index');
	Route::get('about','WebsiteController@about')->name('about');
	Route::get('privacy-policy','WebsiteController@privacyPolicy')->name('privacy-policy');
	Route::get('courses','WebsiteController@qualifications')->name('courses');
	Route::get('corporate-training','WebsiteController@corporateTraining')->name('corporate-training');
	Route::get('corporate-training/{slug}','WebsiteController@corporateTrainingDetails')->name('corporate-training.details');
	Route::get('corporate-training-course/{slug}','WebsiteController@corporateTrainingCourseDetails')->name('corporate_training_course_details');

	Route::get('course-calendar','WebsiteController@courseCalendar')->name('course-calendar');
	Route::get('courses/{slug}','WebsiteController@qualificationsDetails')->name('qualifications.details');
	Route::get('exam/{slug}','WebsiteController@examDetails')->name('exam_details');
	Route::get('course/{slug}','WebsiteController@courseDetails')->name('course_details');
	Route::get('course/broucher/{slug}','WebsiteController@CourseBroucher')->name('course.download.broucher');
	Route::get('corporate-course/broucher/{slug}','WebsiteController@corporateTrainingBroucher')->name('corporate_course.download.broucher');
	Route::get('exam/broucher/{slug}','WebsiteController@ExamBroucher')->name('exam.download.broucher');
	Route::get('news-events','WebsiteController@newsEvents')->name('news-events');
	Route::get('news-events/{slug}','WebsiteController@newsEventsDetails')->name('news-events.details');
	Route::get('our-centers','WebsiteController@whereToStudy')->name('our-centers');
	Route::get('checkcert','WebsiteController@checkcert')->name('checkcert');
	Route::post('checkcert','WebsiteController@checkCertificate')->name('checkcertificate');
	Route::get('apply-now','WebsiteController@BecomeCenter')->name('apply_now');
	Route::post('apply-now','WebsiteController@ApplyNowMail')->name('apply_now.mail');
	Route::get('success','WebsiteController@success')->name('success');
	Route::get('find-course-provider','WebsiteController@findCourseProvider');
	Route::post('find-course-provider','WebsiteController@getCenter')->name('find_center');
	Route::get('find-examinations','WebsiteController@findExaminations');
	Route::post('find-examinations','WebsiteController@getExamCenter')->name('find_exam');
	Route::get('files','WebsiteController@Files')->name('student_files');
	Route::get('study-center/course/{id}','WebsiteController@getCourseByCenter');
	Route::get('placements','WebsiteController@placementList')->name('placements.list');
	Route::get('/placement/apply/{id}','WebsiteController@placementapplyForm')->name('placement.apply');
	Route::post('/placement/apply/store','WebsiteController@placementstore')->name('placement.apply.store');
	Route::get('/placement/apply/mail','WebsiteController@ApplyNowMail')->name('placement.apply.mail');
	Route::get('/video-testimonials','WebsiteController@videotestimonials')->name('video.testimonials');

	
	
	







});


/**
	*Student Login Form.
	*Student Login.
	*/
Route::get('login', 'Student\Auth\StudentLoginController@showLoginForm')->name('student.login');
Route::post('login', 'Student\Auth\StudentLoginController@login')->name('student.login.submit');

	/**
	*Center Protected Routes Starts Here.
	*Only Centers Can Access.
	*Middleware:student.
	*prefix:student-dashboard.
	*/
Route::group(['middleware' =>['student'], 'prefix' =>'student', 'namespace' => 'Student'],function(){

	/**
	*Student Home.
	*Change Password.
	*routes.
	*/ 
	Route::get('/dashboard','StudentController@index')->name('student-home');
	Route::get('change-password','StudentController@changePasswordForm')->name('student.change_password');
	Route::post('change-password','StudentController@changePassword')->name('student.save_password');
	Route::get('my-course-modules','StudentController@myCourseModuleData')->name('my_course_module_data');
	Route::get('medias/video/{slug}','StudentController@getAllVideoMedias')->name('medias.video');
	Route::get('medias/file/{slug}','StudentController@getAllPdfMedias')->name('medias.file');
	Route::get('medias/links/{slug}','StudentController@getAllMediaLinks')->name('medias.links');
	Route::get('exam','StudentController@startExam')->name('student.exam');
	Route::post('exam/answers','StudentController@submitResult')->name('student.answers');
	Route::get('certificate','StudentController@getCertificate')->name('certificate');
	Route::get('result','StudentController@getResult')->name('student-result');
	Route::get('files-list','StudentController@getFiles')->name('student-file-list');
	Route::get('student-alerts','StudentController@getAlerts')->name('student-alerts');
	Route::get('student-alerts','StudentController@getAlerts')->name('student-alerts');
	Route::get('examsattend', 'StudentController@examsattend')->name('examsattend');
    Route::post('examsattend/{id}/submit', 'StudentController@examsattendsubmit')->name('examsattendsubmit');
});

