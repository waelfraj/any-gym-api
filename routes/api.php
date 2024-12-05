<?php

use App\Http\Controllers\API\Advertisement\AdvertisementApiController;
use App\Http\Controllers\API\Advertisement\CreateAdvertisementApiController;
use App\Http\Controllers\API\Advertisement\DestroyAdvertisementApiController;
use App\Http\Controllers\API\Advertisement\LastAdvertisementApiController;
use App\Http\Controllers\API\Advertisement\ShowAdvertisementApiController;
use App\Http\Controllers\API\Advertisement\UpdateAdvertisementApiController;
use App\Http\Controllers\API\Appointment\AppointmentController;
use App\Http\Controllers\API\Appointment\CreateAppointmentController;
use App\Http\Controllers\API\Appointment\ParticipateAppointmentController;
use App\Http\Controllers\API\AUTH\CheckResetPasswordTokenController;
use App\Http\Controllers\API\AUTH\DetailsAuthentificatedUserController;
use App\Http\Controllers\API\AUTH\ForgetPasswordController;
use App\Http\Controllers\API\AUTH\LoginController;
use App\Http\Controllers\API\AUTH\LogoutController;
use App\Http\Controllers\API\AUTH\MailValidationController;
use App\Http\Controllers\API\AUTH\RefreshController;
use App\Http\Controllers\API\AUTH\RegisterController;
use App\Http\Controllers\API\AUTH\SendResetPasswordEmailController;
use App\Http\Controllers\API\AUTH\SendValidationEmailController;
use App\Http\Controllers\API\Coach\CoachController;
use App\Http\Controllers\API\Coach\DestroyCoachController;
use App\Http\Controllers\API\Coach\ShowCoachController;
use App\Http\Controllers\API\Coach\StoreCoachController;
use App\Http\Controllers\API\Coach\ValidateCoachController;
use App\Http\Controllers\API\CompleteProfile\CompleteMemberProfileController;
use App\Http\Controllers\API\Exercise\AttachExerciseTrainingListController;
use App\Http\Controllers\API\Exercise\CreateExerciseController;
use App\Http\Controllers\API\Exercise\DestroyExerciseController;
use App\Http\Controllers\API\Exercise\ExerciseByCategoryController;
use App\Http\Controllers\API\Exercise\ExerciseController;
use App\Http\Controllers\API\Exercise\ShowExerciseController;
use App\Http\Controllers\API\GeminiApi\GeminiApiController;
use App\Http\Controllers\API\HomeMember\HomeMemberController;
use App\Http\Controllers\API\HomeStaff\StaffHomeController;
use App\Http\Controllers\API\Member\DestroyMemberController;
use App\Http\Controllers\API\Member\MemberController;
use App\Http\Controllers\API\Member\SearchMemberByNameController;
use App\Http\Controllers\API\Member\ShowMemberController;
use App\Http\Controllers\API\Member\ValidateMemberController;
use App\Http\Controllers\API\MemberTrainingList\AttachMemberToTrainingListController;
use App\Http\Controllers\API\MemberTrainingList\GetMemberTrainingListController;
use App\Http\Controllers\API\Staff\CreateStaffController;
use App\Http\Controllers\API\Staff\DestroyStaffController;
use App\Http\Controllers\API\Staff\SearchStaffByNameController;
use App\Http\Controllers\API\Staff\ShowStaffController;
use App\Http\Controllers\API\Staff\StaffController;
use App\Http\Controllers\API\Staff\ValidateStaffController;
use App\Http\Controllers\API\TrainingList\CreateNewTrainingListController;
use App\Http\Controllers\API\TrainingList\DestroyTrainingListController;
use App\Http\Controllers\API\TrainingList\GetAllTrainingListsController;
use App\Http\Controllers\API\TrainingList\GetTrainingListsByCoachController;
use App\Http\Controllers\API\TrainingList\GetTrainingListsByQueryController;
use App\Http\Controllers\API\TrainingList\RemoveExerciseFromListController;
use App\Http\Controllers\API\User\EditConnectedUserController;
use App\Http\Controllers\API\Weight\CreateWeightController;
use App\Http\Controllers\API\Weight\DeleteWeightByMemberController;
use App\Http\Controllers\API\Weight\GetWeightByMemberController;
use Illuminate\Support\Facades\Route;

Route::middleware(['middleware' => 'api', 'return-json'])->group(function () {
    Route::middleware(['loginThrottle:10,5,1'])->post('login', LoginController::class);
    Route::middleware(['loginThrottle:10,5,1', 'XssSanitization'])->post('send-reset-password', SendResetPasswordEmailController::class);
    Route::middleware(['XssSanitization'])->post('check-reset-password-token', CheckResetPasswordTokenController::class);
    Route::middleware(['XssSanitization'])->post('new-password', ForgetPasswordController::class);
    Route::middleware(['loginThrottle:10,5,1', 'XssSanitization'])->post('send-validation-mail', SendValidationEmailController::class);
    Route::middleware(['XssSanitization'])->post('check-validation-mail-token', MailValidationController::class);
    Route::middleware(['XssSanitization'])->post('register', RegisterController::class);
    Route::group(['middleware' => 'jwt'], function () {
        Route::prefix('/advertisement')->group(function () {
            Route::get('/last', LastAdvertisementApiController::class);
        });
        Route::post('logout', LogoutController::class);
        Route::post('refresh', RefreshController::class);
        Route::post('me', DetailsAuthentificatedUserController::class);
        Route::prefix('/users')->group(function () {
            Route::middleware(['XssSanitization'])->post('/edit/connected', EditConnectedUserController::class);
        });
        Route::prefix('/training-list')->group(function () {
            Route::get('/', GetAllTrainingListsController::class);
        });
        Route::prefix('/weights')->group(function () {
            Route::get('/', GetWeightByMemberController::class);
            Route::post('/', CreateWeightController::class)->middleware(['XssSanitization']);
            Route::delete('/{weightId}', DeleteWeightByMemberController::class);
        });
        Route::prefix('/complete-profile')->group(function () {
            Route::post('/', CompleteMemberProfileController::class)->middleware(['XssSanitization']);
        });
        Route::middleware(['isMember'])->group(function () {
            Route::post('/attach-member-training-list', AttachMemberToTrainingListController::class)->middleware(['XssSanitization']);
            Route::get('/member-training-list', GetMemberTrainingListController::class);
            Route::post('/appointments/{appointmentId}/participate', ParticipateAppointmentController::class);

        });
        Route::post('/chat/', GeminiApiController::class)->middleware(['XssSanitization']);
        Route::get('/members/home', HomeMemberController::class);

        Route::get('/appointments', AppointmentController::class);

        Route::middleware(['isCoach'])->group(function () {

            Route::post('/appointments', CreateAppointmentController::class)->middleware(['XssSanitization']);


            Route::prefix('/exercises')->group(function () {
                Route::get('/', ExerciseController::class);
                Route::get('/category/{category}', ExerciseByCategoryController::class);
                Route::get('/{id}', ShowExerciseController::class);
                Route::middleware(['XssSanitization'])->post('/create', CreateExerciseController::class);
                Route::middleware(['XssSanitization'])->post('/add', AttachExerciseTrainingListController::class);
                Route::delete('/{id}', DestroyExerciseController::class);
            });
            Route::prefix('/training-list')->group(function () {
                Route::post('/create', CreateNewTrainingListController::class)->middleware(['XssSanitization']);
                Route::get('/query', GetTrainingListsByQueryController::class);
                Route::get('/coach', GetTrainingListsByCoachController::class);
                Route::delete('/{id}', DestroyTrainingListController::class);
                Route::delete('/{idList}/{idExercise}', RemoveExerciseFromListController::class);
            });
        });
        Route::middleware(['isStaff'])->group(function () {
            Route::get('/staffs/home', StaffHomeController::class);
        });
        Route::middleware(['isAdmin'])->group(function () {
            Route::prefix('/members')->group(function () {
                Route::get('/', MemberController::class);
                Route::get('/search/{name}', SearchMemberByNameController::class);
                Route::get('/{id}', ShowMemberController::class);
                Route::delete('/{id}', DestroyMemberController::class);
                Route::middleware(['XssSanitization'])->post('/validate/{id}', ValidateMemberController::class);
            });
            Route::prefix('/staffs')->group(function () {
                Route::get('/', StaffController::class);
                Route::middleware(['XssSanitization'])->post('/create', CreateStaffController::class);
                Route::get('/search/{name}', SearchStaffByNameController::class);
                Route::get('/{id}', ShowStaffController::class);
                Route::delete('/{id}', DestroyStaffController::class);
                Route::middleware(['XssSanitization'])->post('/validate/{id}', ValidateStaffController::class);
            });
            Route::prefix('/coaches')->group(function () {
                Route::get('/', CoachController::class);
                Route::get('/{id}', ShowCoachController::class);
                Route::middleware(['XssSanitization'])->post('/', StoreCoachController::class);
                Route::middleware(['XssSanitization'])->post('/validate/{id}', ValidateCoachController::class);
                Route::delete('/{id}', DestroyCoachController::class);
            });
            Route::prefix('/advertisement')->group(function () {
                Route::get('/', AdvertisementApiController::class);
                Route::get('/{id}', ShowAdvertisementApiController::class);
                Route::middleware(['XssSanitization'])->post('/', CreateAdvertisementApiController::class);
                Route::middleware(['XssSanitization'])->post('/{id}', UpdateAdvertisementApiController::class);
                Route::delete('/{id}', DestroyAdvertisementApiController::class);
            });
        });
    });
});
