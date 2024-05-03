<?php

namespace App\Http\Swagger\Schemas\Apis;

/**
 * @OA\Post(
 *     path="/v1/auth/login",
 *     tags={"Authentification"},
 *     operationId="LoginApi",
 *     summary="Get user and token",
 *     description="Username and password are required",
 *     @OA\RequestBody(
 *         description="Returns the user and the token",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  @OA\Property(
 *                      property="username",
 *                      description="User (email or fidelys ID)",
 *                      type="string",
 *                  ),
 *                  @OA\Property(
 *                      property="password",
 *                      description="User Password or PIN CODE",
 *                      type="string",
 *                  )
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *              type="object",
 *              ref="#/components/schemas/LoginResponse"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *              type="object",
 *              ref="#/components/schemas/ApiResponseError"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessable Entity (validation failed)",
 *         @OA\JsonContent(
 *              type="object",
 *              ref="#/components/schemas/ApiResponseErrorValidation"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="General server error",
 *         @OA\JsonContent(
 *              type="object",
 *              ref="#/components/schemas/ApiResponseError"
 *         ),
 *     ),
 *     security={{"ServerAuthBearer":{}}}
 * )
 */
class LoginApi
{
}
