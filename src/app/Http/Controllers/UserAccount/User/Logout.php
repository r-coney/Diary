<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\Logout\LogoutCommand;
use App\UserAccount\UseCase\User\Logout\LogoutInterface;
use Exception;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Logout extends Controller
{
    private readonly LogoutInterface $logout;

    public function __construct(LogoutInterface $logout)
    {
        $this->logout = $logout;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            if(!($this->logout)(new LogoutCommand($request))) {
                throw new NotFoundHttpException('Failed to Logout.');
            }

            $response = [
                'status' => 'success',
                'message' => 'Logout success.',
            ];
            $statusCode = 200;
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            $statusCode = 400;
        }

        return response()->json($response, $statusCode);
    }
}
