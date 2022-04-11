<?php

namespace App\Infrastructure\Controllers;

use App\Application\GetUserListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetUserListController extends BaseController
{
    private $getUserList;

    /**
     * IsEarlyAdopterUserController constructor.
     */
    public function __construct(GetUserListService $getUserList)
    {
        $this->getUserList = $getUserList;
    }
    public function __invoke(): JsonResponse
    {

        try {
            $getUserList = $this->getUserList->execute();
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'list' => $getUserList
        ], Response::HTTP_OK);

    }


}
