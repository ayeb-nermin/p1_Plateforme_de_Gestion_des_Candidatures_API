<?php

namespace App\Http\Swagger\Schemas\Apis;

/**
 * @OA\Post(
 *     path="/v1/api-user/login",
 *     tags={"ServerAuthentification"},
 *     operationId="getLoginByEmailAndPasswordServer",
 *     summary="Get user server token",
 *     description="Email and password are required",
 *     @OA\RequestBody(
 *         description="Returns the server user and the token",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  @OA\Property(
 *                      property="email",
 *                      description="User email",
 *                      type="string",
 *                      format="email",
 *                  ),
 *                  @OA\Property(
 *                      property="password",
 *                      description="User Password",
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
 *              ref="#/components/schemas/LoginServer"
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
 * )
 */
class LoginServerApi
{
}
