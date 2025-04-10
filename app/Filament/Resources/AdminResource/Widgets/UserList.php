<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;

class UserList extends Widget
{
    protected static string $view = 'user-list'; // Without a subfolder

    protected int | string | array $columnSpan = 'full';

    public function getUsers()
    {
        return User::latest()->take(10)->get();
    }
}

