<?php

namespace App\Listeners\User;

use App\Events\User\Updated as Userupdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Audit;

class Updated
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
     * @param  Updated  $event
     * @return void
     */
    public function handle(Userupdated $event)
    {		
        $model = $event->user;
        $changes = $model->getChanges();
		$status = Audit::getActionByKey('updated');
        $status_insert = auth()->user()->displayname.' has edited '.$model->displayname.'\'s user account.'.$model->displayname.'\'s user id is '.$model->id.'.';
		$original = $model->getOriginal();
		$changes = [];
		foreach ($model->getChanges() as $key => $value) {
			if($key!='curr_date' && $key!='created_at'){
			  if($key=='firstname'){
			   $status_insert.='<p>The <strong>'.ucfirst($key).'</strong> was '.$original[$key].' and it has been replaced with '.$value.'</p>';
			  }
			  elseif($key=='lastname'){
				$status_insert.='<p>The <strong>'.ucfirst($key).'</strong> was '.$original[$key].' and it has been replaced with '.$value.'</p>';  
			  }
			  elseif($key=='displayname'){
				$status_insert.='<p>The <strong>'.ucfirst($key).'</strong> was '.$original[$key].' and it has been replaced with '.$value.'</p>';  
			  }
			  else{
				 $status_insert.='<p>The <strong>'.ucfirst($key).'</strong> was '.$original[$key].'  and was changed to  '.$value.'</p>'; 
			  }
			}
		}
		
		if(count($changes)==2){
		  if(array_key_exists("password_string", $changes)){
			$status = Audit::getActionByKey('reset_password');
            $status_insert = auth()->user()->displayname.' has reset '.$model->displayname.'\'s user account.'.$model->displayname.'\'s user id is '.$model->id.'.The old password was : '.$changes['password_string'].'.The new password is hidden for user security.';   
		 }
		}
	
        $log = [];
    	$log['status'] = $status;
        $log['status_insert'] = $status_insert;    	
    	$log['userid'] = auth()->user()->id;
        $log['curr_date_time'] = date('Y-m-d H:i:s');		
	    Audit::create($log);
    }
}
