<?php

namespace App\Providers;

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
        Gate::define('project-index',callback:'App\Policies\ProjectPolicy@index');
        Gate::define('project-show',callback:'App\Policies\ProjectPolicy@show');
        Gate::define('project-add',callback:'App\Policies\ProjectPolicy@add');
        Gate::define('project-edit',callback:'App\Policies\ProjectPolicy@edit');
        Gate::define('project-update',callback:'App\Policies\ProjectPolicy@update');
        Gate::define('project-delete',callback:'App\Policies\ProjectPolicy@delete');
    }

    public function defineDu_an(){
        Gate::define('du_an-index',callback:'App\Policies\DaPolicy@index');
        Gate::define('du_an-show',callback:'App\Policies\DaPolicy@show');
        Gate::define('du_an-add',callback:'App\Policies\DaPolicy@add');
        Gate::define('du_an-edit',callback:'App\Policies\DaPolicy@edit');
        Gate::define('du_an-update',callback:'App\Policies\DaPolicy@update');
        Gate::define('du_an-delete',callback:'App\Policies\DaPolicy@delete');
    }

    public function defineTemplate(){
        Gate::define('template-index',callback:'App\Policies\TemplatePolicy@index');
        Gate::define('template-show',callback:'App\Policies\TemplatePolicy@show');
        Gate::define('template-add',callback:'App\Policies\TemplatePolicy@add');
        Gate::define('template-edit',callback:'App\Policies\TemplatePolicy@edit');
        Gate::define('template-update',callback:'App\Policies\TemplatePolicy@update');
        Gate::define('template-delete',callback:'App\Policies\TemplatePolicy@delete');
    }

    public function defineGadev(){
        Gate::define('gadev-index',callback:'App\Policies\Ga_devPolicy@index');
        Gate::define('gadev-show',callback:'App\Policies\Ga_devPolicy@show');
        Gate::define('gadev-add',callback:'App\Policies\Ga_devPolicy@add');
        Gate::define('gadev-edit',callback:'App\Policies\Ga_devPolicy@edit');
        Gate::define('gadev-update',callback:'App\Policies\Ga_devPolicy@update');
        Gate::define('gadev-delete',callback:'App\Policies\Ga_devPolicy@delete');
    }
    public function defineGa(){
        Gate::define('ga-index',callback:'App\Policies\GaPolicy@index');
        Gate::define('ga-show',callback:'App\Policies\GaPolicy@show');
        Gate::define('ga-add',callback:'App\Policies\GaPolicy@add');
        Gate::define('ga-edit',callback:'App\Policies\GaPolicy@edit');
        Gate::define('ga-update',callback:'App\Policies\GaPolicy@update');
        Gate::define('ga-delete',callback:'App\Policies\GaPolicy@delete');
    }
    public function defineDev(){
        Gate::define('dev-index',callback:'App\Policies\DevPolicy@index');
        Gate::define('dev-show',callback:'App\Policies\DevPolicy@show');
        Gate::define('dev-add',callback:'App\Policies\DevPolicy@add');
        Gate::define('dev-edit',callback:'App\Policies\DevPolicy@edit');
        Gate::define('dev-update',callback:'App\Policies\DevPolicy@update');
        Gate::define('dev-delete',callback:'App\Policies\DevPolicy@delete');
    }

    public function defineVaitro(){
        Gate::define('vai_tro-index',callback:'App\Policies\RolePolicy@index');
        Gate::define('vai_tro-show',callback:'App\Policies\RolePolicy@show');
        Gate::define('vai_tro-add',callback:'App\Policies\RolePolicy@add');
        Gate::define('vai_tro-edit',callback:'App\Policies\RolePolicy@edit');
        Gate::define('vai_tro-update',callback:'App\Policies\RolePolicy@update');
        Gate::define('vai_tro-delete',callback:'App\Policies\RolePolicy@delete');
    }
    public function defineUser(){
        Gate::define('user-index',callback:'App\Policies\UserPolicy@index');
        Gate::define('user-show',callback:'App\Policies\UserPolicy@show');
        Gate::define('user-add',callback:'App\Policies\UserPolicy@add');
        Gate::define('user-edit',callback:'App\Policies\UserPolicy@edit');
        Gate::define('user-update',callback:'App\Policies\UserPolicy@update');
        Gate::define('user-delete',callback:'App\Policies\UserPolicy@delete');
    }
    public function definePhan_quyen(){
        Gate::define('phan_quyen-index',callback:'App\Policies\PermissionPolicy@index');
        Gate::define('phan_quyen-show',callback:'App\Policies\PermissionPolicy@show');
        Gate::define('phan_quyen-add',callback:'App\Policies\PermissionPolicy@add');
        Gate::define('phan_quyen-edit',callback:'App\Policies\PermissionPolicy@edit');
        Gate::define('phan_quyen-update',callback:'App\Policies\PermissionPolicy@update');
        Gate::define('phan_quyen-delete',callback:'App\Policies\PermissionPolicy@delete');
    }




}
