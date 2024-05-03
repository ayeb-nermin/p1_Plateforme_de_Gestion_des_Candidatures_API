<?php

namespace App\Http\Swagger\Schemas\Responses;

/**
 *  @OA\Schema(
 *   schema="ApiResponseErrorValidation",
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
 *     ),
 *     @OA\Property(
 *          property="errors",
 *          type="object",
 *              @OA\Property(
 *                  property="field_one",
 *                  type="array",
 *                  @OA\Items(
 *                      type="string",
 *                  ),
 *              ),
 *              @OA\Property(
 *                  property="field_two",
 *                  type="array",
 *                  @OA\Items(
 *                      type="string",
 *                  ),
 *              )
 *       ),
 *   )
 */
class ApiResponseErrorValidation
{
}
