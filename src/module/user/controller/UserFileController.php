<?php

declare(strict_types=1);

namespace App\module\user\controller;

use App\kernel\sharedKernel\helper\JSONApi\JSONApi;
use App\kernel\sharedKernel\helper\VirtualController\VirtualController;
use App\module\user\service\UserFileUploadService;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserFileController extends VirtualController
{
    private JSONApi $JSONApi;

    private UserFileUploadService $fileUploadService;
    public function __construct(UserFileUploadService $fileUploadService)
    {
        $this->JSONApi = new JSONApi("FileUploader");
        $this->fileUploadService  = $fileUploadService;
    }

    /**
     * @Route (path="/me/upload-file", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        try {
            $currentUser = $this->user();
            $result = $this->fileUploadService->upload($currentUser, $request->files);
            return $this->JSONApi->toJSON($result->getFiles()->toArray());
        }
        catch (\InvalidArgumentException $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_BAD_REQUEST);
        }
        catch (\Exception $exception) {
            return $this->JSONApi->throwException($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}