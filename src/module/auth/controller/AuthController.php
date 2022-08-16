<?php

declare(strict_types=1);

namespace App\module\auth\controller;

use App\kernel\sharedKernel\helper\JSONApi\JSONApi;
use App\module\auth\dto\request\UserSIgnInDataTObject;
use App\module\auth\dto\request\UserSignUpDataTObject;
use App\module\auth\exception\WrongCredentialsException;
use App\module\auth\service\AuthService;
use App\module\user\exception\UserAlreadyExistsException;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController
{
    private  JSONApi $JSONApi;

    private  AuthService $authService;
    #[Pure] public function __construct(AuthService $authService)
    {
        $this->JSONApi = new JSONApi("Auth");
        $this->authService = $authService;
    }

    /**
     * @Route(path="/sign-up", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function signUp(Request $request): JsonResponse
    {
        try {
            $dto = new UserSignUpDataTObject($request);
            $result = $this->authService->signUp($dto);
            return $this->JSONApi->toJSON(["token" => $result->getJwt()]);
        }
        catch (UserAlreadyExistsException $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_CONFLICT);
        }
        catch (\InvalidArgumentException $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_BAD_REQUEST);
        }
        catch (\Exception $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route(path="/sign-in", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function signIn(Request $request): JsonResponse
    {
        try {
            $dto = new UserSIgnInDataTObject($request);
            $result = $this->authService->signIn($dto);
            return $this->JSONApi->toJSON($result);
        }
        catch (WrongCredentialsException $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_CONFLICT);
        }
        catch (\InvalidArgumentException $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_BAD_REQUEST);
        }
        catch (\Exception $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}