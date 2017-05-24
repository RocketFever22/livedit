<?php

namespace Ricks\livedit;

use Auth;
use App\AboutUs;
use DB;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LiveditRepository{
	private $time_lapse;

	public function __construct(Request $request){
		$this->time_lapse = Carbon::now()->subMinutes(config('livedit.minutes'))->toDateTimeString();
	} 

	public function findIds(String $resource_type)
	{
		$list = DB::table(config('livedit.table'))
			->where(config('livedit.field'), $resource_type)
			->where('updated_at', '>', $this->time_lapse)
			->get()->all();

		DB::table(config('livedit.table'))
			->where('updated_at', '<', $this->time_lapse)
			->delete();

		return $list;
	}

	public function processReturn(Array $live_edits)
	{	
		$formatted = [];
		$ids_added = [];
		foreach($live_edits as $live_item)
		{
			if(!in_array($live_item->field_id, $ids_added)){
				$formatted[] = [
					"resource_id" => $live_item->field_id,
					"user" => User::find($live_item->user_id)
				];
				$ids_added[] = $live_item->field_id;
			}
		}

		return $formatted;
	}

	public function push(Int $user_id, Array $data)
	{
		try{
			DB::table(config('livedit.table'))
				->insert([
					'user_id' => $user_id, 
					config('livedit.field') => $data[config('livedit.field')], 
					'field_id' => $data['field_id'],
					'updated_at' => Carbon::now()
				]);
		} catch( \Exception $e){
			return array('status' => false, 'message' => $e->getMessage());
		}

		return array('status' => true);
	}

}