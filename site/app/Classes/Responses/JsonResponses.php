<?php

namespace App\Classes\Responses;

use Illuminate\Http\JsonResponse;

class JsonResponses extends JsonResponse
{
    protected $status;
    protected $message;
    protected $data;

    /**
     * @param array $data
     * @return ApiJsonResponse
     */
    public static function createOk(array $data): self
    {
        return self::create([
            'status' => 'ok',
            'data' => $data
        ], self::HTTP_OK);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return ApiJsonResponse
     */
    public static function createErr(
        string $message,
        array $data = [],
        int $code = self::HTTP_INTERNAL_SERVER_ERROR
    ): self
    {
        $payload = [
            'status' => 'err',
            'message' => $message
        ];

        if (!empty($data)) {
            $payload['data'] = $data;
        }

        return self::create($payload, $code);
    }
}
