<?php namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use App\Report;
use App\Science;
use App\Organization;
use App\Method;


class ReportController extends Controller {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index($id)
    {
        return view('report.index', compact('id'));
    }

    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
    public function create()
    {
        $report = new Report;
        $title = Request::input('title');
        $worker_id = Request::input('worker_id');
        $expire_date = Request::input('expire_date');
        $status = 'Заплановано';
        $rate = 0;

        $block = Request::input('block');
        $str = explode('-', $block);

        $type = $str[0];
        $unit_store = $str[1];

        $report->title = $title;
        $report->type = $type;
        $report->status = $status;
        $report->expire_date = $expire_date;
        $report->rate = $rate;
        $report->unit_store = $unit_store;
        $report->worker_id = $worker_id;
        $report->save();

        return redirect('worker/'.$worker_id);
    }

    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store()
    {
        //
    }

    /**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function show()
    {
        $direct = Request::input('direction');
        if (Request::ajax())
        {
            switch($direct){
                case 'science':
                $direction = Science::orderBy('type')->get();
                break;
                case 'method':
                $direction = Method::orderBy('type')->get();
                break;
                case 'organization':
                $direction = Organization::orderBy('type')->get();
                break;
            }
            return $direction;
        }

        return $direct;
    }

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id, $unit)
    {
        $report = Report::find($id);
        if($report->status == 'Заплановано'){
            $report->status = 'Готово';
            $report->rate = $unit;
            $report->save();
        } else {
            $report->status = 'Заплановано';
            $report->rate = 0;
            $report->save();
        }
        return redirect('worker/'. $report->worker_id);
    }

    /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($id)
    {
        //
    }

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id)
    {        
        $report = Report::find($id);
        $report->delete();
        return redirect('worker/'. $report->worker_id);
    }

}
