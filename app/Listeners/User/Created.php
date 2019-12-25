<?php

namespace App\Listeners\User;

use App\Events\User\Created as Usercreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Audit;

class Created
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
     * @param  Created  $event
     * @return void
     */
    public function handle(Usercreated $event)
    {
		$data = $event->user;		
        $log = [];
    	$log['status'] =Audit::getActionByKey('created');
        $log['status_insert'] = auth()->user()->displayname.' has added new user named '.$data->displayname.' whose ID number is '.$data->id;    	
    	$log['userid'] = auth()->user()->id;
        $log['curr_date_time'] = date('Y-m-d H:i:s');		
	    Audit::create($log);
    }
}
