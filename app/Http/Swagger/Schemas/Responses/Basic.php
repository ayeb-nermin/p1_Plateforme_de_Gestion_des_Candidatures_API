<?php

namespace App\Http\Swagger\Schemas\Responses;

/**
 * @OA\Schema(
 *     schema="Basic",
 *     required={"base_url", "status", "message"},
 *     @OA\Property(
 *         property="base_url",
 *         type="string",
 *         format="url"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="boolean",
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

class Basic
{
}
