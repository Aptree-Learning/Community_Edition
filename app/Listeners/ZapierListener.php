<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\SubscriptionHook;

class ZapierListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        if($event->data) {
            $webhooks = SubscriptionHook::where("event", $event->event)->get();
            foreach($webhooks as $webhook)
            {
                $url = $webhook->hook_url;
                $data = $event->data->toArray();
                $client = new \GuzzleHttp\Client();
                $response = $client->request('POST', $url, [
                    'json' => $data
                ]);
            }
        }
    }
}
