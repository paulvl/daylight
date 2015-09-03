<?php

namespace Daylight\Foundation\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

trait AuthenticatesAndRegistersUsers
{
    use AuthenticatesUsers, RegistersUsers {
        AuthenticatesUsers::redirectPath insteadof RegistersUsers;
    }
}
