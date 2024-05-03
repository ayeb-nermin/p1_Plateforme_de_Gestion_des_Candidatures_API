<?php

namespace App\Http\Swagger\Schemas\Responses;

/**
 *  @OA\Schema(
 *   schema="ApiResponseError",
 *   type="object",
 *   required={"base_url", "status", "message", "status_code"},
 *     @OA\Property(
 *         property="base_url",
 *         type="string",
 *         format="url"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="boolean",
 *         default="false",
 *     ),
 *     @OA\Property(
 *          property="status_code",
 *          type="integer",
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string"
 *     )
 * )
 */
class ApiResponseError
{
}
