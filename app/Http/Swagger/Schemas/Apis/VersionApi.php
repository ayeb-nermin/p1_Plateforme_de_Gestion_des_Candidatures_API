<?php

namespace App\Http\Swagger\Schemas\Apis;

/**
 * @OA\Get(
 *      path="/v1/version",
 *      operationId="getCurrentApiVersion",
 *      tags={"Version"},
 *      summary="Get the current API version",
 *      description="Returns the current endpoint API's version",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Version")
 *          ),
 *       ),
 *       security={{"ServerAuthBearer":{}}}
 * )
 */
class VersionApi
{
}
