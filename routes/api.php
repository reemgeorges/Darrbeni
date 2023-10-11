<?php

use App\Http\Controllers\Api\AboutUsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SpecializationController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CollageController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\ImportanceController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('/Darrebni')->group(function (){

    Route::prefix('/auth')->group(function (){
        Route::post('/register',[AuthController::class,'register']);
        Route::post('/login',[AuthController::class,'login']);
        Route::post('/UserProfile/logout',[AuthController::class, 'logout'])->middleware(['auth:sanctum']);
    });
    Route::get('/Slider/all', [SliderController::class, 'index']);

    Route::get('/Collages/all',[CollageController::class, 'index']);
    Route::get('/Specialization/allSpecialization',[SpecializationController::class, 'index']);
    Route::get('/Collages/getSpecialization/collage={id}',[SpecializationController::class, 'getByCollage']);
    Route::get('/Collages/Specializations',[CollageController::class, 'getCollagesWithSpecialization']);
    Route::post('/Specialization/search',[SpecializationController::class, 'searchBySpecialization']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('/Notification/getall',[NotificationController::class, 'getnotifications']);



        
        Route::get('/terms/specialization/{id}/getall',[TermController::class, 'getTerm']);
        Route::get('/terms/getall',[TermController::class, 'getAllTerms']);


        //show Questions with Answers For Terms Depends On Subject
        Route::get('/Questions/Terms/term_id/{termid}/Subjects/subject_id/{id}',[QuestionController::class, 'getQuestionsBySubject']);

        //Show Questions With Answers For Books
        Route::get('/Books/Questions/Subject/{id}',[QuestionController::class, 'BookQuestion']);

        //show Questions and answers randomly Depends On Specialization
        Route::get('/BankQuestions/specialization/{id}',[QuestionController::class, 'BankQuestions']);
        Route::get('/SpecializationTermsQuestions/term/{id}',[QuestionController::class, 'QuestionTermForSpecialization']);

        //single question fetch

        
        Route::get('/Question/single/{id}',[QuestionController::class, 'getQuestionsByid']);



//show Questions with Answers For Terms
         Route::get('/Terms/Question/term_id/{id}',[QuestionController::class, 'showQuestionForTerm']);
         Route::get('/Terms/{term}/nextQuestion/{question}', [QuestionController::class, 'showNext']);
         Route::get('/Terms/{term}/prevQuestion/{question}', [QuestionController::class, 'showPrev']);

//Show Questions With Answers For Books
         Route::get('/Books/Question/sub_id/{id}',[QuestionController::class, 'showQuestionForBooks']);
         Route::get('/Books/{subid}/nextQuestion/{question}', [QuestionController::class, 'showNextForBook']);
         Route::get('/Books/{subid}/prevQuestion/{question}', [QuestionController::class, 'showPrevForBook']);

         Route::post('/ImportanceQuestions/addQuestion/question/{id}',[ImportanceController::class, 'addImportance']);
         Route::get('/ImportanceQuestions/getImportances',[ImportanceController::class, 'getImportances']);
         Route::delete('/ImportanceQuestions/remove/question/{id}',[ImportanceController::class, 'removeImportance']);


        
        Route::get('/Terms/Filters/question/{id}',[QuestionController::class, 'getQuestionsByTerm']);


        Route::get('/aboutus/get',[AboutUsController::class, 'index']);


        Route::get('/Terms/Filters/subj/{id}',[TermController::class, 'FilterSubjectTerm']);
        Route::get('/Terms/Filters/spec/{id}',[TermController::class, 'FilterSpecTerm']);


        Route::get('/Specialization/checkButtons',[SpecializationController::class, 'CheckButtons']);
        Route::get('/Specialization/filters/type/{type}',[SubjectController::class, 'showMasterOrGraduationSubjects']);
        Route::get('/Specialization/filters/specialization/{id}',[SubjectController::class, 'showSubjects']);

        Route::put('/UserProfile/update',[UserController::class, 'update']);
        Route::delete('/UserProfile/delete',[UserController::class, 'destroy']);
        Route::get('/UserProfile/Info',[UserController::class, 'getInfo']);
        Route::post('/UserProfile/Feedback',[FeedbackController::class, 'store']);

        Route::prefix('dashboard')->middleware('admin')->group(function (){


            Route::post('/Notification/send',[NotificationController::class, 'sendNotification']);
            Route::post('/Notification/update',[NotificationController::class, 'updateToken']);
            

            Route::post('/Slider/create', [SliderController::class, 'store']);
            Route::put('/Slider/update/{id}', [SliderController::class, 'update']);
            Route::delete('/Slider/delete/{id}', [SliderController::class, 'destroy']);

            Route::post('/Specialization/create',[SpecializationController::class, 'store']);
            Route::put('/Specialization/update/{id}',[SpecializationController::class, 'update']);
            Route::delete('/Specialization/delete/{id}',[SpecializationController::class, 'destroy']);

            Route::post('/Subject/create',[SubjectController::class, 'store']);
            Route::put('/Subject/update/{id}',[SubjectController::class, 'update']);
            Route::delete('/Subject/delete/{id}',[SubjectController::class, 'destroy']);

            Route::post('/Term/store', [TermController::class, 'store']);
            Route::put('/Term/update/{id}', [TermController::class, 'update']);
            Route::delete('/Term/delete/{id}', [TermController::class, 'destroy']);

            Route::post('/Question/create',[QuestionController::class, 'store']);
            Route::put('/Question/update/{id}',[QuestionController::class, 'udate']);
            Route::delete('/Question/delete/{id}',[QuestionController::class, 'destroy']);

            Route::post('/Answer/store', [AnswerController::class, 'store']);
            Route::put('/Answer/update/{id}', [AnswerController::class, 'update']);
            Route::delete('/Answer/delete/{id}', [AnswerController::class, 'destroy']);

        });

    });

});
