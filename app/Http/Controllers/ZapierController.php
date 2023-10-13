<?php

namespace App\Http\Controllers;

use Mail;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SubscriptionHook;
use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\Team;
use App\Models\Enrollment;
use App\Models\Pathway;
use App\Mail\AssignedToCourse;
use App\Mail\AssignedToPathway;
use Illuminate\Support\Facades\Crypt;

class ZapierController extends Controller
{
    //

    protected function parseAPIKey($api_key, $key)
    {
        return json_decode(Crypt::decryptString($api_key), true)[$key];
    }

    public function me(Request $request)
    {
        $api_key = $request->get("api_key");
        $user = User::where('email', $this->parseAPIKey($api_key, 'email'))->first();
        if($user) {
            return response()->json(['message' => 'Request received'], 200);
        }
        else{
            return response()->json(['message' => 'Provided information is incorrect'], 200);
        }
    }

    public function subscribeHook(Request $request)
    {
        SubscriptionHook::create([
            'event' => $request->event,
            'hook_url' => $request->hookUrl,
        ]);
        return response()->json(['message' => 'Request received'], 200);
    }
    
    public function unsubscribeHook(Request $request)
    {
        SubscriptionHook::delete([
            'event' => $request->event,
            'hook_url' => $request->hookUrl,
        ]);
        return response()->json(['message' => 'Request received'], 200);
    }
    
    public function performList(Request $request)
    {
        $api_key = $request->get("api_key");
        $event = $request->event;
        $email = $this->parseAPIKey($api_key, 'email');
        
        $user = User::where('email', $email)->first();

        $payload = [];
        if($user) {
            if($event == 'course.create') {
                $course = Course::orderBy('created_at', 'desc')->first();
                $payload = $course ? [$course] : [];
            }
            if($event == 'group.create') {
                $team = Team::orderBy('created_at', 'desc')->first();
                $payload = $team ? [$team] : [];
            }
            if($event == 'user.create') {
                $user = User::orderBy('created_at', 'desc')->first();
                $payload = $user ? [$user] : [];
            }
            if($event == 'pathway.completed') {
                $pathway = Pathway::where('status', 1)->orderBy('updated_at', 'desc')->first();
                $payload = $pathway ? [$pathway] : [];
            }
            if($event == 'course.completed') {
                $course = Enrollment::where('user_id', $user->id)->whereNotNull('completed_at')->orderBy('completed_at', 'desc')->first();
                if($course) {
                    $payload = [$course->course];
                }
            }
        }

        return response()->json($payload, 200);
    }

    
    public function actionList(Request $request)
    {
        $api_key = $request->get("api_key");
        $event = $request->event;
        
        $payload = ["message" => "No action performed"];
        if($event == 'enroll.user_to_course') {
            $assinger = User::where('email', $this->parseAPIKey($api_key, 'email'))->first();
            $user = User::where('email', $request->user_email)->first();
            $course = Course::where('id', $request->course_id)->first();
            if($user && $course) {
                $result = $user->courses()->syncWithPivotValues([$course->id], ['assigned_by' => $assinger->id, 'created_at' => now(), 'updated_at' => now()]);
        
                foreach($result['attached'] as $eachAttached)
                {
                    $course = Course::findOrFail($eachAttached);
                    Mail::to($user->email)->send(new AssignedToCourse($course));
                }
                $payload = $result;
            }
        }
        if($event == 'enroll.user_to_pathway') {
            $assinger = User::where('email', $this->parseAPIKey($api_key, 'email'))->first();
            $user = User::where('email', $request->user_email)->first();
            $pathway = Pathway::where('id', $request->pathway_id)->first();
            if($user && $pathway) {
                $result = $user->pathways()->syncWithPivotValues([$pathway->id], ['assigned_by' => $assinger->id, 'created_at' => now(), 'updated_at' => now()]);
        
                foreach($result['attached'] as $eachAttached)
                {
                    $pathway = Pathway::findOrFail($eachAttached);
                    Mail::to($user->email)->send(new AssignedToPathway($pathway));
                }
                $payload = $result;
            }
        }
        if($event == 'user.update') {
            $user = User::updateOrCreate(
                ["email" => $request->email],
                ["name" => $request->name],
            );
            if(isset($request->password)) {
                $user->password = Hash::make($request->password);
            }
            if(isset($request->provider_email)) {
                $provider = User::where("email", $request->provider_email)->first();
                if($provider) {
                    $user->provider_id = $provider->id;
                }
            }
            $user->save();
            $payload = $user;
        }

        if($event == 'user.delete') {
            $user = User::where('email', $request->user_email)->first();
            if($user)
            {
                $user->delete();
                $payload = ["message" => "User $request->user_email is deleted successfully."];
            }
        }
        if($event == 'user.add_group') {
            $user = User::where('email', $request->user_email)->first();
            $team = Team::where('id', $request->group_id)->first();
            if($user && $team)
            {
                $team->users()->attach(
                    $user, ['role' => null]
                );
                $payload = ["message" => "User $request->user_email is added to $team->name successfully."];
            }
        }
        return response()->json($payload, 200);
    }
}
