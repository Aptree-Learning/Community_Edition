<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsConroller extends Controller
{
    //
    public function index()
    {
        $subscriptions = Subscription::forUser(Auth::user()->id)->get();
        return response()->json(['data' => $subscriptions], 200);
    }

    public function show($id)
    {
        $subscription = Subscription::forUser(Auth::user()->id)
        ->where('id', $id)
        ->first();
        return response()->json(['data' => $subscription], 200);
    }
    
    public function store()
    {
        $subscription = new Subscription;
        $subscription->user_id = Auth::user()->id;
        $subscription->event = Input::get('event');
        $subscription->target_url = Input::get('hookUrl');
        $subscription->save();
    }

    public function update($id)
    {
        if(Input::get('event')) $subscription->event = Input::get('event');
        if(Input::get('target_url')) $subscription->target_url = Input::get('target_url');
        if(Input::get('state')) $subscription->state = Input::get('state');
        $subscription->save();
    } 

    public function destroy($id)
    {
        $subscription = Subscription::forUser(Auth::user()->id)->find($id);
        $subscription->delete();
    } 
}

