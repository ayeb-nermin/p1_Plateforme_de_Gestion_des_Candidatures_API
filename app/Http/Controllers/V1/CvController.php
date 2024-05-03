<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cv\UpdateCvRequest;
use App\Http\Requests\V1\Cv\CreateCvRequest;
use App\Http\Resources\V1\Cv\CvResource;
use App\Models\Cv;
use Illuminate\Http\JsonResponse;
use Medianet\APIToolKit\Api\ApiResponse;
use Illuminate\Support\Facades\Auth;


class CvController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        // $this->authorizeResource(Cv::class, 'cv');
    }

    public function index(): JsonResponse
    {
        $cvs = Cv::useFilters()->dynamicPaginate();

        return $this->responseApiKit(200, ['cvs' => CvResource::collection($cvs)]);
    }

    public function store(CreateCvRequest $request): JsonResponse
    {
        $auth_id = Auth::user() ?? $request->user_id;
        dd($auth_id);
        $cv = Cv::create($request->validated());

        return $this->responseApiKit(201, ['cv' => new CvResource($cv)], 'Cv created successfully');
    }

    public function show(Cv $cv): JsonResponse
    {
        return $this->responseApiKit(200, ['cv' => new CvResource($cv)]);
    }

    public function update(UpdateCvRequest $request, Cv $cv): JsonResponse
    {
        $cv->update($request->validated());

        return $this->responseApiKit(200, ['cv' => new CvResource($cv)],'Cv updated Successfully');
    }

    public function destroy(Cv $cv): JsonResponse
    {
        $cv->delete();

        return $this->responseApiKit(204, [],'Cv deleted Successfully');
    }


}
