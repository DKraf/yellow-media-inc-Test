<?php

/**
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Services\Company;

use App\Services\ICompany;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyService implements ICompany
{

    /**
     * Create new company method
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function store(Request $request): array
    {
        try {
            Auth::user()->company()->create($request->all());

            return ['id' => Auth::user()->id];

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }


    /**
     * List users companies method
     * @return mixed
     */
    public function list()
    {
        return Auth::user()->company->toArray();
    }
}
