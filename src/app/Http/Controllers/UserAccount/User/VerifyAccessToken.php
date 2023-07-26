<?php
namespace App\Http\Controllers\UserAccount\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\VerifyAccessToken\VerifyTokenCommand;
use App\UserAccount\UseCase\User\VerifyAccessToken\VerifyAccessTokenInterface;

class VerifyAccessToken extends Controller
{
    private VerifyAccessTokenInterface $verifyAccessToken;

    public function __construct(VerifyAccessTokenInterface $verifyAccessToken)
    {
        $this->verifyAccessToken = $verifyAccessToken;
    }

    /**
     * アクセストークンが有効か判定
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $verifyTokenCommand = new VerifyTokenCommand($request);
        $result = ($this->verifyAccessToken)($verifyTokenCommand);
        if (!$result->hasError()) {
            $response = [
                'status' => 'success',
                'message' => 'Authentication Success',
            ];
            $statusCode = 200;
        } else {
            $response = [
                'status' => 'error',
                'message' => $result->error(),
            ];
            $statusCode = 401;
        }

        return response()->json(data: $response, status: $statusCode);
    }
}
