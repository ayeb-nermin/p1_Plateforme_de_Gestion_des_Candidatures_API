<?php

namespace App\Http\Swagger\Schemas\Responses;

/**
 *  @OA\Schema(
 *   schema="ApiResponseSuccess",
 *   type="object",
 *   required={"base_url", "status", "message"},
 *     @OA\Property(
 *         property="base_url",
 *         type="string",
 *         format="url"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="boolean",
 *         default="true",
 *     ),
 *     @OA\Property(
 *          property="status_code",
 *          type="integer",
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         example="OK",
 *     ),
 *     @OA\Property(
 *         property="data",
 *         type="object"
 *     )
 * )
 */
class ApiResponseSuccess
{
}
