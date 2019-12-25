<?php

namespace App\Listeners\User;

use App\Events\User\Viewed as Userviewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Audit;

class Viewed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Viewed  $event
     * @return void
     */
    public function handle(Userviewed $event)
    {
        $data = $event->user;		
        $log = [];
    	$log['status'] =Audit::getActionByKey('view_password');
        $log['status_insert'] = auth()->user()->displayname.' has viewed '.$data->displayname.' \'s password.'.$data->displayname.'\'s ID number is '.$data->id;    	
    	$log['userid'] = auth()->user()->id;
        $log['curr_date_time'] = date('Y-m-d H:i:s');		
	    Audit::create($log);
    }
}
