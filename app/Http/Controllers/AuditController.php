<?php 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Session;
use Auth;
use Redirect;
use Validator;
use App\Models\TranAudit;

class AuditController extends Controller
{
    public function index(Request $request)
	{         		
		return view('audit-management.audit-management');
	}

	public function getAuditAjax(Request $request)
    {       
         $result = TranAudit::getAuditList(); 		
         $response = array();
                 foreach($result as $row){
                   $response[] =$row;
                 }
         $udata['data'] = $response;
         return response()->json($udata); 
    }
	
	public function getActionsAjax(Request $request)
    {       
        $result =TranAudit::getActionList();                                
         $response = array();
                 foreach($result as $key=>$row){
                   //$response[] =array('key'=>$key,'value'=>$row);
				   $response[] =$row;
                 }
         $udata['data'] = $response;
         return response()->json($response); 
    }
}