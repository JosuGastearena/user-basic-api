<?php

namespace App\Infrastructure\Controllers;

use App\Application\GetUserDataService\GetUserDataService;
use Barryvdh\Debugbar\Controllers\BaseController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GetUserDataController extends BaseController
{
    private $getUserDataService;

    public function __construct(GetUserDataService $getUserDataService)
    {
        $this->getUserDataService = $getUserDataService;
    }

    public function __invoke(string $id): JsonResponse
    {
        try {
            $user = $this->getUserDataService->execute($id);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'id' => $user->getId(),
            'email'=> $user->getEmail()
        ], Response::HTTP_OK);
    }


}
