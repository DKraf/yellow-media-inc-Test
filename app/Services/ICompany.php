<?php

/**
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Services;

use Illuminate\Http\Request;

interface ICompany
{
    public function store(Request $request);
    public function list();
}
