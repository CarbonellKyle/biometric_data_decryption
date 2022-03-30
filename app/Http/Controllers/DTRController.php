<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DTRController extends Controller
{
    public function index()
    {
        $current_month = Carbon::now()->month; //current month for default value on dropdown
        return view('dtr.index', compact('current_month'));
    }

    public function upload(){
        return view('dtr.import');
    }

    public function uploadSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required',
        ]);

        $fileOriginalName = $request->file('file')->getClientOriginalName();
        $filetype = $request->file('file')->getClientOriginalExtension();

        if($filetype!='dat'){
            return back()->with('upload_fail', 'Invalid file type. Please upload a .dat File!');
        }

        $request->file('file')->storeAs('/dat', $fileOriginalName, 'uploads');
        return back()->with('file_uploaded', $fileOriginalName);
    }

    public function import(Request $request)
    {
        //Max execution time is set to 5mins
        $seconds = 360;
        ini_set('max_execution_time', $seconds);

        $filename = $request->filename;

        //Getting and opening dat file
        $file = fopen(public_path('uploads/dat' . '/' . $filename), 'r');

        //Storing each line of dat file to an array
        while(!feof($file)) {
            $line[] = fgets($file);
        }

        //Close file
        fclose($file);

        for($i=0; $i<sizeof($line); $i++){
            //Spliting elements on each line (with spaces and tabs)
            $data[] = preg_split("/\s+/", $line[$i], -1, PREG_SPLIT_NO_EMPTY);

            DB::table('biometric_data')->insert([
                'employee_id' => $data[$i][0],
                'datetime' => $data[$i][1] . ' ' . $data[$i][2],
                'school_id' => $data[$i][3],
            ]);
        }

        return back()->with('data_imported', 'Data has been imported successfully!');
    }

    public function getDTR(Request $request)
    {
        $now = Carbon::now(); //current date
        $month = $request->month; //month selected by user
        $current_month = $month; //for default value on dropdown
        $noOfDays = Carbon::now()->month($month)->daysInMonth; //number of days of selected month

        //Creating an array for days on month selected
        for($i=1; $i<$noOfDays+1; $i++){
            $days[$i] = array(
                'date' => Carbon::createFromDate($now->year, $month, $i),
                'in1' => null,
                'out1' => null,
                'in2' => null,
                'out2' => null,
                'ut' => null,
                'ot' => null,
            );
        }

        //Attendance logs of selected employee
        $logs = DB::table('biometric_data')
        ->where('employee_id', $request->id)
        ->whereMonth('datetime', $request->month)
        ->orderBy('datetime', 'ASC')->get();

        //Getting ins and out
        //Looping days of the month
        for($i=1; $i<$noOfDays+1; $i++){
            //Looping attendance log
            for($j=0; $j<sizeof($logs); $j++){
                if($days[$i]['in1']==null){
                    //In1 will be the first one to be filled if a log is on the same day
                    if($days[$i]['date']->isSameDay($logs[$j]->datetime)){
                        $days[$i]['in1'] = $logs[$j]->datetime;
                    }
                }elseif($days[$i]['out1']==null){
                    //Filled after In1 with the value of next log on the same day
                    if($days[$i]['date']->isSameDay($logs[$j]->datetime)){
                        $days[$i]['out1'] = $logs[$j]->datetime;
                    }
                }elseif($days[$i]['in2']==null){
                    //Filled after Out1 with the value of next log on the same day
                    if($days[$i]['date']->isSameDay($logs[$j]->datetime)){
                        $days[$i]['in2'] = $logs[$j]->datetime;
                    }
                }elseif($days[$i]['out2']==null){
                    //Filled after In2 with the value of next log on the same day
                    if($days[$i]['date']->isSameDay($logs[$j]->datetime)){
                        $days[$i]['out2'] = $logs[$j]->datetime;
                    }
                }
            }
        }

        return view('dtr.index', compact('days', 'current_month'));
    }
}
