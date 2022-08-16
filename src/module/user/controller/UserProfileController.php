<?php

declare(strict_types=1);

namespace App\module\user\controller;

use App\kernel\sharedKernel\helper\JSONApi\JSONApi;
use App\kernel\sharedKernel\helper\VirtualController\VirtualController;
use App\module\user\dto\request\CreateUserProfileRequestTObject;
use App\module\user\service\UserProfileService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends VirtualController
{
    private JSONApi $JSONApi;

    private UserProfileService $userProfileService;
    public function __construct(UserProfileService $userProfileService)
    {
        $this->JSONApi = new JSONApi("UserProfile");
        $this->userProfileService = $userProfileService;
    }

    /**
     * @Route (path="/me/profile", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $currentUser = $this->user();
            $dto = new CreateUserProfileRequestTObject($request);
            $profile = $this->userProfileService->create($currentUser, $dto);
            return $this->JSONApi->toJSON($profile, "", Response::HTTP_OK, ["default"]);
        }
        catch (\InvalidArgumentException $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_BAD_REQUEST);
        }
        catch (\Exception $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}