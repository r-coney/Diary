<?php
namespace App\Http\Controllers\UserAccount\User;

use Exception;
use Illuminate\Http\Request;
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

    public function __invoke(Request $request)
    {
        $verifyTokenCommand = new VerifyTokenCommand($request);

        try {
            ($this->verifyAccessToken)($verifyTokenCommand);
            $response = [
                'status' => 'success',
                'message' => 'Authentication Success',
            ];
            $statusCode = 200;
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            $statusCode = 401;
        }

        return response()->json(data: $response, status: $statusCode);
    }
}
