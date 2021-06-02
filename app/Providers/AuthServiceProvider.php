<?php

namespace App\Providers;

use App\Policies\DaPolicy;
use App\Policies\DevPolicy;
use App\Policies\Ga_devPolicy;
use App\Policies\GaPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\RolePolicy;
use App\Policies\TemplatePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use function PHPUnit\Framework\callback;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       $this->defineProject();
       $this->defineDu_an();
       $this->defineTemplate();
       $this->defineGadev();
       $this->defineGa();
       $this->defineDev();
       $this->defineUser();
       $this->defineVaitro();
       $this->definePhan_quyen();
    }

    public function defineProject(){

        Gate::define('project-index', [ProjectPolicy::class, 'index']);
        Gate::define('project-show', [ProjectPolicy::class, 'show']);
        Gate::define('project-add', [ProjectPolicy::class, 'add']);
        Gate::define('project-edit', [ProjectPolicy::class, 'edit']);
        Gate::define('project-update', [ProjectPolicy::class, 'update']);
        Gate::define('project-delete', [ProjectPolicy::class, 'delete']);

    }

    public function defineDu_an(){
        Gate::define('du_an-index', [DaPolicy::class, 'index']);
        Gate::define('du_an-show', [DaPolicy::class, 'show']);
        Gate::define('du_an-add', [DaPolicy::class, 'add']);
        Gate::define('du_an-edit', [DaPolicy::class, 'edit']);
        Gate::define('du_an-update', [DaPolicy::class, 'update']);
        Gate::define('du_an-delete', [DaPolicy::class, 'delete']);
    }

    public function defineTemplate(){
        Gate::define('template-index', [TemplatePolicy::class, 'index']);
        Gate::define('template-show', [TemplatePolicy::class, 'show']);
        Gate::define('template-add', [TemplatePolicy::class, 'add']);
        Gate::define('template-edit', [TemplatePolicy::class, 'edit']);
        Gate::define('template-update', [TemplatePolicy::class, 'update']);
        Gate::define('template-delete', [TemplatePolicy::class, 'delete']);
    }

    public function defineGadev(){
        Gate::define('gadev-index', [Ga_devPolicy::class, 'index']);
        Gate::define('gadev-show', [Ga_devPolicy::class, 'show']);
        Gate::define('gadev-add', [Ga_devPolicy::class, 'add']);
        Gate::define('gadev-edit', [Ga_devPolicy::class, 'edit']);
        Gate::define('gadev-update', [Ga_devPolicy::class, 'update']);
        Gate::define('gadev-delete', [Ga_devPolicy::class, 'delete']);
    }
    public function defineGa(){
        Gate::define('ga-index', [GaPolicy::class, 'index']);
        Gate::define('ga-show', [GaPolicy::class, 'show']);
        Gate::define('ga-add', [GaPolicy::class, 'add']);
        Gate::define('ga-edit', [GaPolicy::class, 'edit']);
        Gate::define('ga-update', [GaPolicy::class, 'update']);
        Gate::define('ga-delete', [GaPolicy::class, 'delete']);
    }
    public function defineDev(){

        Gate::define('dev-index', [DevPolicy::class, 'index']);
        Gate::define('dev-show', [DevPolicy::class, 'show']);
        Gate::define('dev-add', [DevPolicy::class, 'add']);
        Gate::define('dev-edit', [DevPolicy::class, 'edit']);
        Gate::define('dev-update', [DevPolicy::class, 'update']);
        Gate::define('dev-delete', [DevPolicy::class, 'delete']);
    }

    public function defineVaitro(){
        Gate::define('vai_tro-index', [RolePolicy::class, 'index']);
        Gate::define('vai_tro-show', [RolePolicy::class, 'show']);
        Gate::define('vai_tro-add', [RolePolicy::class, 'add']);
        Gate::define('vai_tro-edit', [RolePolicy::class, 'edit']);
        Gate::define('vai_tro-update', [RolePolicy::class, 'update']);
        Gate::define('vai_tro-delete', [RolePolicy::class, 'delete']);
    }
    public function defineUser(){
        Gate::define('user-index', [UserPolicy::class, 'index']);
        Gate::define('user-show', [UserPolicy::class, 'show']);
        Gate::define('user-add', [UserPolicy::class, 'add']);
        Gate::define('user-edit', [UserPolicy::class, 'edit']);
        Gate::define('user-update', [UserPolicy::class, 'update']);
        Gate::define('user-delete', [UserPolicy::class, 'delete']);
    }
    public function definePhan_quyen(){
        Gate::define('phan_quyen-index', [PermissionPolicy::class, 'index']);
        Gate::define('phan_quyen-show', [PermissionPolicy::class, 'show']);
        Gate::define('phan_quyen-add', [PermissionPolicy::class, 'add']);
        Gate::define('phan_quyen-edit', [PermissionPolicy::class, 'edit']);
        Gate::define('phan_quyen-update', [PermissionPolicy::class, 'update']);
        Gate::define('phan_quyen-delete', [PermissionPolicy::class, 'delete']);

    }




}
