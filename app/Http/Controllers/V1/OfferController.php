<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Offer\UpdateOfferRequest;
use App\Http\Requests\V1\Offer\CreateOfferRequest;
use App\Http\Resources\V1\Offer\OfferResource;
use App\Http\Swagger\Schemas\Models\User;
use App\Models\Offer;
use App\Models\User as ModelsUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Medianet\APIToolKit\Api\ApiResponse;
use Illuminate\Support\Facades\Auth;


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

    public function apply(Request $request, Offer $offer): JsonResponse
    {
        $auth_id = Auth::user()->id ?? $request->user_id;

        $user = ModelsUser::find($auth_id);

        if($user){
            //check if the user has completed his cv
            if(! $user->cv){
                return $this->responseApiKit(403, [],'You should complete your cv first');
            }

            // else store application
            $user->offres()->attach($offer->id);
        }

        return $this->responseApiKit(200, [],'Successfully applied');
    }


}
