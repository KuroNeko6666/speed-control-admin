<?php
namespace App\Http\Livewire\Home;
class DataSidebar
{
    public $data = [
        'dashboard' =>[
            'name' => 'Dashboard',
            'path' => '/',
            'sub_menus' => null,
            'active' => false,
        ],
        'master' =>[
            'name' => 'Master',
            'path' => '/',
            'active' => false,
            'sub_menus' => [
                'admin' => [
                    'name' => 'admin data',
                    'path' => '/master-admin',
                    'active' => false,
                ],
                'user' => [
                    'name' => 'user data',
                    'path' => '/master-user',
                    'active' => false,
                ],
                'operator' => [
                    'name' => 'operator data',
                    'path' => '/master-operator',
                    'active' => false,
                ],
                'device' => [
                    'name' => 'device data',
                    'path' => '/master-device',
                    'active' => false,
                ],
            ],
        ],
        'user_device' =>[
            'name' => 'User Device',
            'path' => '/user-device',
            'sub_menus' => null,
            'active' => false,
        ],

        'data_device' =>[
            'name' => 'Data Device',
            'path' => '/data-device',
            'sub_menus' => null,
            'active' => false,
        ],
    ];

    public function data($active, $sub_active = null){
        if($sub_active == null){
            $this->data[$active]['active'] = true;
        } else {
            $this->data[$active]['active'] = true;
            $this->data[$active]['sub_menus'][$sub_active]['active'] = true;
        }
        return $this->data;
    }
}

