<?php

namespace App\Providers;

use App\Repository\ClientRepositoryInterface;
use App\Repository\CompanyRepositoryInterface;
use App\Repository\ContractorRepositoryInterface;
use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\CorrespondenceRepositoryInterface;
use App\Repository\DesignTeamRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\ClientRepository;
use App\Repository\Eloquent\CompanyRepository;
use App\Repository\Eloquent\ContractorRepository;
use App\Repository\Eloquent\CorrespondenceFileRepository;
use App\Repository\Eloquent\CorrespondenceRepository;
use App\Repository\Eloquent\DesignTeamRepository;
use App\Repository\Eloquent\ProjectFileRepository;
use App\Repository\Eloquent\ProjectManagerRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\ProjectFileRepositoryInterface;
use App\Repository\ProjectManagerRepositoryInterface;
use App\Repository\ProjectRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractorService;
use App\Services\CorrespondenceFileService;
use App\Services\CorrespondenceService;
use App\Services\DesignTeamService;
use App\Services\ProjectFileService;
use App\Services\ProjectManagerService;
use App\Services\ProjectService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ProjectService::class, function ($app) {
            return new ProjectService(
                $app->make(ProjectRepositoryInterface::class) ,
                $app->make(UserService::class) , 
                $app->make(ProjectFileService::class)
            );
        }); 
        
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ClientService::class, function ($app) {
            return new ClientService($app->make(ClientRepositoryInterface::class));
        });  

        $this->app->bind(ContractorRepositoryInterface::class, ContractorRepository::class);
        $this->app->bind(ContractorService::class, function ($app) {
            return new ContractorService($app->make(ContractorRepositoryInterface::class));
        }); 


        $this->app->bind(DesignTeamRepositoryInterface::class, DesignTeamRepository::class);
        $this->app->bind(DesignTeamService::class, function ($app) {
            return new DesignTeamService($app->make(DesignTeamRepositoryInterface::class));
        });         


        $this->app->bind(ProjectManagerRepositoryInterface::class, ProjectManagerRepository::class);
        $this->app->bind(ProjectManagerService::class, function ($app) {
            return new ProjectManagerService($app->make(ProjectManagerRepositoryInterface::class));
        });       
        
        
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });   
        
        
        $this->app->bind(ProjectFileRepositoryInterface::class, ProjectFileRepository::class);
        $this->app->bind(ProjectFileService::class, function ($app) {
            return new ProjectFileService($app->make(ProjectFileRepositoryInterface::class));
        });  
        
        

        $this->app->bind(CorrespondenceRepositoryInterface::class, CorrespondenceRepository::class);
        $this->app->bind(CorrespondenceService::class, function ($app) {
            return new CorrespondenceService(
                $app->make(CorrespondenceRepositoryInterface::class) ,
                $app->make(UserService::class) , 
                $app->make(CorrespondenceFileService::class)
            );
        }); 


        $this->app->bind(CorrespondenceFileRepositoryInterface::class, CorrespondenceFileRepository::class);
        $this->app->bind(CorrespondenceFileService::class, function ($app) {
            return new CorrespondenceFileService($app->make(CorrespondenceFileRepositoryInterface::class));
        });  


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
