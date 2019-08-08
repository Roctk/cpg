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
use App\Http\Controllers\Controller;
use App\Repository\CourseRepository;
use App\Subscription;
use App\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class CoursesController extends Controller
{
    /** @var  Builder */
    private $query;

    /** @var  ResponseFactory */
    private $responseFactory;

    private $auth;

    /**
     * @var CourseRepository
     */
    private $courseRepository;

    public function __construct(ResponseFactory $responseFactory, CourseRepository $courseRepository)
    {
        $this->query = Course::query();
        $this->responseFactory = $responseFactory;
        $this->courseRepository = $courseRepository;
    }

    public function index(): JsonResponse
    {
        $courses = $this->courseRepository->getCoursesList();
        return $this->responseFactory->json([
            'data' => $courses
        ]);
    }

    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $subscription = $this->query->find($request->get('course_id'));
        $user->courses()->save($subscription);

        return $this->responseFactory->json(['success' => true]);
    }
}