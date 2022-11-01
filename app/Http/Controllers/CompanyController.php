<?php

/**
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Http\Controllers;

use App\Http\Resource\Company\ListResource;
use App\Services\Company\CompanyService;
use App\Traits\ResponseJsonWithHttpStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
    use ResponseJsonWithHttpStatus;

    /**
     * Creat new company
     *
     * @param Request $request
     * @param CompanyService $companyService
     * @return JsonResponse
     */
    public function store(Request $request, CompanyService $companyService): JsonResponse
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'phone' => 'required',
                'description' => 'required',
            ]);

            return $this->success($companyService->store($request));
        } catch (\Exception $e) {
            return $this->error($e->getMessage() , 400);
        }
    }


    /**
     * List users companies method
     *
     * @param CompanyService $companyService
     * @return JsonResponse
     */
    public function list(CompanyService $companyService): JsonResponse
    {
        try {
            return $this->success(ListResource::toArray($companyService->list()));
        } catch (\Exception $e) {
            return $this->error($e->getMessage() , $e->getCode());
        }
    }
}
