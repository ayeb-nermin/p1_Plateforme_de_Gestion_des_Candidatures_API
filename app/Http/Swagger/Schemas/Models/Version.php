<?php

namespace App\Http\Swagger\Schemas\Models;

/**
 *  @OA\Schema(
 *   schema="Version",
 *   type="object",
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
 *         property="message",
 *         type="string"
 *     ),
 *     @OA\Property(
 *          property="data",
 *          type="object",
 *          @OA\Property(
 *              property="version",
 *              type="string",
 *          ),
 *      ),
 * )
 */
class Version
{
}
