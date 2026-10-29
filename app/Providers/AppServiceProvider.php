<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Domain Repositories
use App\Domain\Livestock\Repositories\LivestockListingRepositoryInterface;
use App\Domain\Livestock\Repositories\EloquentLivestockListingRepository;
use App\Domain\Ordering\Repositories\OrderRepositoryInterface;
use App\Domain\Ordering\Repositories\EloquentOrderRepository;
use App\Domain\Hadp\Repositories\HadpApplicationRepositoryInterface;
use App\Domain\Hadp\Repositories\EloquentHadpApplicationRepository;
use App\Domain\Veterinary\Repositories\InaphPassportRepositoryInterface;
use App\Domain\Veterinary\Repositories\EloquentInaphPassportRepository;
use App\Domain\Pastoral\Repositories\WoolLabRepositoryInterface;
use App\Domain\Pastoral\Repositories\EloquentWoolLabRepository;
use App\Domain\Pastoral\Repositories\BahakTransitRepositoryInterface;
use App\Domain\Pastoral\Repositories\EloquentBahakTransitRepository;
use App\Domain\Identity\Repositories\UserRepositoryInterface;
use App\Domain\Identity\Repositories\EloquentUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LivestockListingRepositoryInterface::class, EloquentLivestockListingRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, EloquentOrderRepository::class);
        $this->app->bind(HadpApplicationRepositoryInterface::class, EloquentHadpApplicationRepository::class);
        $this->app->bind(InaphPassportRepositoryInterface::class, EloquentInaphPassportRepository::class);
        $this->app->bind(WoolLabRepositoryInterface::class, EloquentWoolLabRepository::class);
        $this->app->bind(BahakTransitRepositoryInterface::class, EloquentBahakTransitRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
