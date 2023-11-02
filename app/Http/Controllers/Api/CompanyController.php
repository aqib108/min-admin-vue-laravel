<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CreateCompanyRequest;
use App\Models\Api\Company;
use App\Traits\ApiResponse;
use App\Events\CompanyCreateEvent;

class CompanyController extends Controller
{
    use ApiResponse;

    protected $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $companies = $this->model->latest()->paginate(10);
        return $this->successResponse($companies);
    }

    public function store(CreateCompanyRequest $request)
    {
        try{
            if ($request->hasFile("image")) {
                $request['logo'] = $this->uploadFile($request->file('image'));
            }
            if ($request->filled("id")) {
                $company = Company::find($request->id);
                $company->update($request->all());
            } else {
                $company = $this->model->create($request->all());
                event(new CompanyCreateEvent($company));
            }
            return $this->successResponse($company, $request->filled("id") ? "Record Successfully Updated" : "Company successfully created");
        }catch(\Exception $e){
          return $this->errorResponse($e->getMessage());
        }
       
    }

    function uploadFile($image): string
    {
        $imagePath = $image->store('public');
        return str_replace('public/', '', $imagePath);
    }

    public function show(string $id)
    {
        $company = $this->model->findOrFail($id);
        return $this->successResponse($company);
    }

    public function destroy(string $id)
    {
        try{
            $company = $this->model->findOrFail($id);
            if ($company->delete()) {
                return $this->successResponse([], 'Record Successfully Deleted');
            } else {
                return $this->errorResponse([], 'Something went wrong');
            }
        }catch (\Exception $e){ 
            return $this->errorResponse($e->getMessage());
        }
         
    }
}

