<?php

namespace App\Providers;

use App\Http\Controllers\KhosimController;
use App\Policies\CocsimPolicy;
use App\Policies\DaPolicy;
use App\Policies\DevPolicy;
use App\Policies\Ga_devPolicy;
use App\Policies\GaPolicy;
use App\Policies\HubPolicy;
use App\Policies\MaiManagePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\RolePolicy;
use App\Policies\SmsPolicy;
use App\Policies\TemplatePolicy;
use App\Policies\UserPolicy;
use App\Policies\KhosimPolicy;
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
       $this->defineKhosim();
       $this->defineCocsim();
       $this->defineHub();
       $this->defineSms();
       $this->defineMailManage();
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

    public function defineKhosim(){
        Gate::define('khosim-index', [KhosimPolicy::class, 'index']);
        Gate::define('khosim-show', [KhosimPolicy::class, 'show']);
        Gate::define('khosim-add', [KhosimPolicy::class, 'add']);
        Gate::define('khosim-edit', [KhosimPolicy::class, 'edit']);
        Gate::define('khosim-update', [KhosimPolicy::class, 'update']);
        Gate::define('khosim-delete', [KhosimPolicy::class, 'delete']);

    }
    public function defineCocsim(){
        Gate::define('cocsim-index', [CocsimPolicy::class, 'index']);
        Gate::define('cocsim-show', [CocsimPolicy::class, 'show']);
        Gate::define('cocsim-add', [CocsimPolicy::class, 'add']);
        Gate::define('cocsim-edit', [CocsimPolicy::class, 'edit']);
        Gate::define('cocsim-update', [CocsimPolicy::class, 'update']);
        Gate::define('cocsim-delete', [CocsimPolicy::class, 'delete']);

    }
    public function defineHub(){
        Gate::define('hub-index', [HubPolicy::class, 'index']);
        Gate::define('hub-show', [HubPolicy::class, 'show']);
        Gate::define('hub-add', [HubPolicy::class, 'add']);
        Gate::define('hub-edit', [HubPolicy::class, 'edit']);
        Gate::define('hub-update', [HubPolicy::class, 'update']);
        Gate::define('hub-delete', [HubPolicy::class, 'delete']);
    }
    public function defineSms(){
        Gate::define('sms-index', [SmsPolicy::class, 'index']);
        Gate::define('sms-show', [SmsPolicy::class, 'show']);
        Gate::define('sms-add', [SmsPolicy::class, 'add']);
        Gate::define('sms-edit', [SmsPolicy::class, 'edit']);
        Gate::define('sms-update', [SmsPolicy::class, 'update']);
        Gate::define('sms-delete', [SmsPolicy::class, 'delete']);
    }

    public function defineMailManage(){
        Gate::define('mail_manage-index', [MaiManagePolicy::class, 'index']);
        Gate::define('mail_manage-show', [MaiManagePolicy::class, 'show']);
        Gate::define('mail_manage-add', [MaiManagePolicy::class, 'add']);
        Gate::define('mail_manage-edit', [MaiManagePolicy::class, 'edit']);
        Gate::define('mail_manage-update', [MaiManagePolicy::class, 'update']);
        Gate::define('mail_manage-delete', [MaiManagePolicy::class, 'delete']);
    }




}
