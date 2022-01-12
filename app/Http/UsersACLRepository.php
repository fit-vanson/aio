<?php

namespace App\Http;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use Illuminate\Support\Facades\Auth;

class UsersACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {

        return [
            ['disk' => 'File Manager', 'path' => '*', 'access' => 2],                                  // main folder - read
            ['disk' => 'KeyStore', 'path' => '*', 'access' => 1],                                  // main folder - read
//            ['disk' => 'File Manager', 'path' => 'keystore', 'access' => 1],                                  // main folder - read
//            ['disk' => 'File Manager', 'path' => 'keystore/*', 'access' => 1],                                  // main folder - read
//            ['disk' => 'File Manager', 'path' => 'project', 'access' => 0],                                  // main folder - read
//            ['disk' => 'File Manager', 'path' => 'template', 'access' => 0],                                  // main folder - read
//            ['disk' => 'File Manager', 'path' => 'templatedata', 'access' => 1],                                  // main folder - read
//            ['disk' => 'File Manager', 'path' => 'templatedata/*', 'access' => 2],                                  // main folder - read
//            ['disk' => 'base', 'path' => '*', 'access' => 0],                                  // main folder - read
        ];
    }
}
