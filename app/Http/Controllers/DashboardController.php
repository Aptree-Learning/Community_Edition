<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(empty($request->get('force'))){
            if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
            {
                return redirect()->route('overview');
            }
        }
        $filter = request()->query('filter');
        $libraries = Course::with('category')->whereHas('category', function($query) {
            $query->whereVisible(true);
        })->get();

        $enrollments = Enrollment::whereHas('course')->with('course.category')->where('user_id', Auth::id())->get();

        $maps = $enrollments->mapWithKeys(function($item, $key) {
            return [$item['course_id'] => $item];
        });

        $user = Auth::user();
        $user_assigned = $user->courses->pluck('id');
        $user_teams = $user->teams->load('courses');
        $allCourses = $user_assigned->merge($user_teams->pluck('courses')->collapse()->pluck('id'))->unique();
        $allCourses = Course::whereIn('id', $allCourses)->get();
        $courses = $allCourses;
        $filters = ['new', 'progress', 'completed'];
        $count['all'] = $allCourses->count();

        foreach($filters as $eachFilter) {
            $tCourse = clone $allCourses;

            if ($eachFilter == 'new') {
                foreach($tCourse as $index => $eachCourse) {
                    if (isset($maps[$eachCourse->id]))
                        unset($tCourse[$index]);
                }
            } else if ($eachFilter == 'progress') {
                foreach($tCourse as $index => $eachCourse) {
                    $flag = true;
                    if (empty($maps[$eachCourse->id]))
                        $flag = false;
                    else if ($maps[$eachCourse->id]['completed_at']) {
                            $flag = false;
                    }
                    if (!$flag)
                        unset($tCourse[$index]);
                }
            } else if ($eachFilter == 'completed') {
                foreach($tCourse as $index => $eachCourse) {
                    if (empty($maps[$eachCourse->id])) {
                        unset($tCourse[$index]);
                    } else if( ! $maps[$eachCourse->id]['completed_at']) {
                        unset($tCourse[$index]);
                    }
                }
            }
            if ($eachFilter)
                $count[$eachFilter] = $tCourse->count();
            if ($filter == $eachFilter)
                $courses = $tCourse;
        }

        $allPathways = $user->pathways->load('courses');
        $pathways = $allPathways;
        $count['all'] += $allPathways->count();

        foreach($filters as $eachFilter) {
            $tPathways = clone $allPathways;

            if ($eachFilter == 'new') {
                foreach($tPathways as $index => $eachPathway) {
                    $tCourses = $eachPathway->courses;
                    $flag = true;
                    foreach($tCourses as $eachCourse) {
                        if (isset($maps[$eachCourse->id]))
                        {
                            $flag = false;
                            break;
                        }
                    }
                    if (!$flag)
                        unset($tPathways[$index]);
                }
            } else if ($eachFilter == 'progress') {
                foreach($tPathways as $index => $eachPathway) {
                    $tCourses = $eachPathway->courses;
                    $flag = false;
                    foreach($tCourses as $eachCourse) {
                        if (isset($maps[$eachCourse->id]) && !$maps[$eachCourse->id]['completed_at']) {
                                $flag = true;
                                break;
                        }
                    }
                    if (!$flag)
                        unset($tPathways[$index]);
                }
            } else if ($eachFilter == 'completed') {
                foreach($tPathways as $index => $eachPathway) {
                    $tCourses = $eachPathway->courses;
                    $flag = true;
                    foreach($tCourses as $eachCourse) {
                        if (isset($maps[$eachCourse->id]) && !$maps[$eachCourse->id]['completed_at']) {
                                $flag = false;
                                break;
                        }
                    }
                    if (!$flag)
                        unset($tPathways[$index]);
                }
            }
            if ($eachFilter)
                $count[$eachFilter] += $tPathways->count();
            if ($filter == $eachFilter)
                $pathways = $tPathways;
        }

        return view('dashboard', compact('libraries', 'enrollments', 'courses', 'pathways', 'filter', 'count'));
    }

    public function overview()
    {
        return view('overview');
    }
}
