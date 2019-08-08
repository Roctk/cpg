<?php
/**
 * Created by PhpStorm.
 * User: Vic
 * Date: 01.05.2019
 * Time: 18:44
 */
namespace App\Repository;

use App\Course;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class CourseRepository
{
    /** @var  Builder */
    private $query;

    public function __construct()
    {
        $this->query = Course::query();
    }

    public function getCoursesList(): Collection
    {
        $courses = $this->query->orderBy('is_adv', 'desc')->get();
        return $this->prepareCourses($courses);
    }

    public function getSubscribedCoursesForUser(User $user)
    {
        $courses = $user->courses;
        return $this->prepareCourses($courses);
    }

    public function getFavoriteCoursesForUser(User $user)
    {
        $courses = $user->favorites;
        return $this->prepareCourses($courses);
    }

    protected function prepareCourses(Collection $courses): Collection
    {
        /** @var Course $course */
        foreach ($courses as $course) {
            $course->date_time = $this->normalizeDateTime($course->date_time);
            $course->date_time_end = $this->normalizeDateTime($course->date_time_end);
//            if(empty($course->pivot)) {
//                continue;
//            }
//            $course->pivot->created_at = $this->normalizeDateTime($course->pivot->created_at);
//            $course->pivot->updated_at = $this->normalizeDateTime($course->pivot->created_at);
        }

        return $courses;
    }

    protected function normalizeDateTime($dateTime)
    {
        return empty($dateTime) ? $dateTime : Carbon::parse($dateTime)->format(Course::DATE_FORMAT);
    }
}