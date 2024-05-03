<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Offer\UpdateOfferRequest;
use App\Http\Requests\V1\Offer\CreateOfferRequest;
use App\Http\Resources\V1\Offer\OfferResource;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Medianet\APIToolKit\Api\ApiResponse;

class OfferController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        // $this->authorizeResource(Offer::class, 'offer');
    }

    public function index(): JsonResponse
    {
        $offers = Offer::useFilters()->dynamicPaginate();

        return $this->responseApiKit(200, ['offers' => OfferResource::collection($offers)]);
    }

    public function store(CreateOfferRequest $request): JsonResponse
    {
        $offer = Offer::create($request->validated());

        return $this->responseApiKit(201, ['offer' => new OfferResource($offer)], 'Offer created successfully');
    }

    public function show(Offer $offer): JsonResponse
    {
        return $this->responseApiKit(200, ['offer' => new OfferResource($offer)]);
    }

    public function update(UpdateOfferRequest $request, Offer $offer): JsonResponse
    {
        $offer->update($request->validated());

        return $this->responseApiKit(200, ['offer' => new OfferResource($offer)],'Offer updated Successfully');
    }

    public function destroy(Offer $offer): JsonResponse
    {
        $offer->delete();

        return $this->responseApiKit(204, [],'Offer deleted Successfully');
    }


}
