<?php

namespace Ricks\livedit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LiveditController extends Controller
{
	private $repo;

	public function __construct(Request $request)
    {
		$this->repo = new LiveditRepository($request);
	}
    
    public function push(Request $request)
    {
		$action = $this->repo->push(Auth::id(), $request->input());

    	if( $action['status'] )
    	{
    		return [
    			'success' => true
    		];
    	}

    	return ['success' => false, 'message' => $action['message']];
    }

    public function ask($resource_type)
    {
    	$live_edits = $this->repo->findIds($resource_type);

    	$return_data = $this->repo->processReturn($live_edits);

    	return $return_data;
    }
}
