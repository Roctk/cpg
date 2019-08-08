<?php
/**
 * Created by PhpStorm.
 * User: Vic
 * Date: 18.03.2019
 * Time: 21:12
 */

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\SubscribeRequest;
use App\Course;
use App\Favorite;
use App\Http\Controllers\Controller;
use App\Repository\CourseRepository;
use App\Subscription;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class FavoritesController extends Controller
{
    /** @var  Builder */
    private $query;

    /** @var  ResponseFactory */
    private $responseFactory;

    /** @var  AuthManager */
    private $auth;

    /**
     * @var CourseRepository
     */
    private $courseRepository;

    public function __construct(ResponseFactory $responseFactory, AuthManager $auth, CourseRepository $courseRepository)
    {
        $this->query = Course::query();
        $this->responseFactory = $responseFactory;
        $this->auth = $auth;
        $this->courseRepository = $courseRepository;
    }

    public function index(): JsonResponse
    {
        $user = $this->auth->guard()->user();
        $courses = $this->courseRepository->getFavoriteCoursesForUser($user);
        return $this->responseFactory->json([
            'data' => $courses
        ]);
    }

    public function store($courseId): JsonResponse
    {
        /** @var User $user */
        $user = $this->auth->guard()->user();
        $course = $this->query->findOrFail($courseId);
        $user->favorites()->save($course);

        return $this->responseFactory->json(['success' => true]);
    }

    public function remove($courseId)
    {
        /** @var User $user */
        $user = $this->auth->guard()->user();
        $course = $this->query->findOrFail($courseId);
        Favorite::query()->where(['course_id' => $courseId, 'user_id' => $user->id])->delete();

        return $this->responseFactory->json(['success' => true]);
    }
}