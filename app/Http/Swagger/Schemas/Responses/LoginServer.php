<?php

namespace App\Http\Swagger\Schemas\Responses;

/**
 * @OA\Schema(
 *   schema="LoginServer",
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
 *              property="user",
 *              type="object",
 *              ref="#/components/schemas/ServerUser"
 *          ),
 *     ),
 * )
 */
class LoginServer
{
}
