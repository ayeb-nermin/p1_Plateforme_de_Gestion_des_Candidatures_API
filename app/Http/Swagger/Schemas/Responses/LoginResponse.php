<?php

namespace App\Http\Swagger\Schemas\Responses;

/**
 * @OA\Schema(
 *   schema="LoginResponse",
 *   required={"base_url", "status", "message", "data"},
 *   type="object",
 *   @OA\Property(
 *         property="base_url",
 *         type="string",
 *         format="url"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="boolean",
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string"
 *     ),
 *     @OA\Property(
 *          property="data",
 *          type="object",
 *          @OA\Property(
 *              property="access_token",
 *              type="string",
 *          ),
 *          @OA\Property(
 *              property="token_expire_datetime",
 *              type="string",
 *              format="date-time",
 *          ),
 *          @OA\Property(
 *              property="login_type",
 *              type="string",
 *              enum={"email", "number"},
 *          ),
 *          @OA\Property(
 *              property="user_type",
 *              type="string",
 *              enum={"member", "member_tmp"},
 *          ),
 *     ),
 * )
 */
class LoginResponse
{
}
