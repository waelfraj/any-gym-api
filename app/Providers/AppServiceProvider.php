<?php

namespace App\Providers;

use App\Repositories\AdvertisementImageRepository;
use App\Repositories\AppointmentRepository;
use App\Repositories\CoachRepository;
use App\Repositories\ExerciseRepository;
use App\Repositories\Interfaces\AdvertisementImageRepositoryInterface;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\CoachRepositoryInterface;
use App\Repositories\Interfaces\ExerciseRepositoryInterface;
use App\Repositories\Interfaces\MailValidationRepositoryInterface;
use App\Repositories\Interfaces\MemberRepositoryInterface;
use App\Repositories\Interfaces\PasswordResetRepositoryInterface;
use App\Repositories\Interfaces\StaffRepositoryInterface;
use App\Repositories\Interfaces\TrainingListRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WeightRepositoryInterface;
use App\Repositories\MailValidationRepository;
use App\Repositories\MemberRepository;
use App\Repositories\PasswordResetRepository;
use App\Repositories\StaffRepository;
use App\Repositories\TrainingListRepository;
use App\Repositories\UserRepository;
use App\Repositories\WeightRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PasswordResetRepositoryInterface::class, PasswordResetRepository::class);
        $this->app->bind(MailValidationRepositoryInterface::class, MailValidationRepository::class);
        $this->app->bind(CoachRepositoryInterface::class, CoachRepository::class);
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);
        $this->app->bind(AdvertisementImageRepositoryInterface::class, AdvertisementImageRepository::class);
        $this->app->bind(ExerciseRepositoryInterface::class, ExerciseRepository::class);
        $this->app->bind(TrainingListRepositoryInterface::class, TrainingListRepository::class);
        $this->app->bind(WeightRepositoryInterface::class, WeightRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
