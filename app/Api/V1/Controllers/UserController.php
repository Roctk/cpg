<?php

namespace App\Api\V1\Controllers;

use App\Repository\CourseRepository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;

class UserController extends Controller
{
    /** @var  ResponseFactory */
    private $responseFactory;

    /**
     * @var CourseRepository
     */
    private $courseRepository;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ResponseFactory $responseFactory, CourseRepository $courseRepository)
    {
        $this->middleware('jwt.auth', []);
        $this->responseFactory = $responseFactory;
        $this->courseRepository = $courseRepository;
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard()->user());
    }

    public function courses()
    {
        $user = Auth::guard()->user();
        $data = $this->courseRepository->getSubscribedCoursesForUser($user);
        return $this->responseFactory->json(compact('data'));
    }
}
