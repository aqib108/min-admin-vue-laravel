<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Employee;
use App\Traits\ApiResponse;
use App\Http\Requests\Api\SaveEmployeeRequest;
class EmployeeController extends Controller
{
    use ApiResponse;

    protected $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $employees = $this->model->with(['company'])->latest()->paginate($this->perPage);
        return $this->successResponse($employees);
    }

    public function store(SaveEmployeeRequest $request)
    {
        try{
            if ($request->filled("id")) {
                $company = $this->model::find($request->id);
                $company->update($request->all());
            } else {
                $company = $this->model->create($request->all());
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
