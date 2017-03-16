<?php 

use Illuminate\Http\Request;

class LookupsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $lookups = Lookup::orderBy('value')->get();
        return $lookups;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $type
	 * @return Response
	 */
	public function show($type)
	{
        $lookups = Lookup::where('type', '=', $type)
            ->get();

        return $lookups;
	}

    /**
     * Display the Loopkup by type and key
     *
     * @param $type
     * @param $key
     * @return Response
     */
    public function getByTypeAndKey($type, $key)
    {
        $lookup = Lookup::where('type', '=', $type)->where('key', '=', $key)->get();
        return $lookup;
    }

}
