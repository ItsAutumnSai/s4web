<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    public function __construct()
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        View::share('menus', [
            [
                'url' => route('dashboard'),
                'name' => __('menu.dashboard'),
                'icon' => 'bx-home-circle',
                'active' => Route::is('dashboard'),
                'available' => true,
            ],
            [

                'name' => __('menu.history'),
                'icon' => 'bx-history',
                'active' => Route::is('history.*', 'yolo.*'),
                'available' => true,
                'submenu' => [
                    [
                        'url' => route('history.index'),
                        'name' => __('menu.sensor_iot'),
                        'active' => Route::is('history.index'),
                        'available' => true,
                    ],
                    [
                        'url' => route('yolo.index'),
                        'name' => __('menu.yolo_detection'),
                        'active' => Route::is('yolo.index'),
                        'available' => true,
                    ],
                ],
            ],
            [
                'name' => __('menu.user_management'),
                'icon' => 'bx-briefcase-alt-2',
                'active' => Route::is('role.*') || Route::is('user.*') || Route::is('data.*'),
                'available' => $user->can('view_user') || $user->can('view_role'),
                'submenu' => [
                    [
                        'url' => route('user.index'),
                        'name' => __('menu.user'),
                        'active' => Route::is('user.*'),
                        'available' => $user->can('view_user'),
                    ],
                    [
                        'url' => route('role.index'),
                        'name' => __('menu.role'),
                        'active' => Route::is('role.*'),
                        'available' => $user->can('view_role'),
                    ],
                    [
                        'url' => route('data.index'),
                        'name' => __('menu.data'),
                        'active' => Route::is('data.*'),
                        'available' => $user->can('view_user'),
                    ],
                ],
            ],
            [
                'header' => __('menu.my_setting'),
                'available' => true,
            ],
            [
                'name' => __('menu.account'),
                'icon' => 'bx-user',
                'active' => Route::is('account.*'),
                'available' => true,
                'submenu' => [
                    [
                        'url' => route('account.profile.edit'),
                        'name' => __('menu.profile'),
                        'active' => Route::is('account.profile.edit'),
                        'available' => true,
                    ],
                    [
                        'url' => route('account.log.index'),
                        'name' => __('menu.activity_log'),
                        'active' => Route::is('account.log.index'),
                        'available' => true,
                    ],
                ],
            ],
        ]);
    }

    protected function successNotification(string $key, string $menu): array
    {
        return [
            'icon' => 'success',
            'title' => __($menu),
            'message' => __($key, ['menu' => __($menu)])
        ];
    }

    protected function failNotification(string $key, string $menu): array
    {
        return ['icon' => 'error', 'title' => __($menu), 'message' => __($key, ['menu' => __($menu)])];
    }
}
