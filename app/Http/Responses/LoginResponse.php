<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $home = Auth()->user()->hasRole('admin') ? '/admin/dashboard' : '/participant/dashboard';
 
        return redirect()->intended($home);
    }
}
