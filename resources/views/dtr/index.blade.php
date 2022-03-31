@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-12my-2">
        <h1 class="text-center">Biometric Data Decyption</h1>

        <a class="btn btn-primary mt-4 offset-2" href="{{ route('upload') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
            </svg> Import
        </a>
    </div>

        <div class="col-4 offset-7">
            <form method="GET" action="{{ route('getDTR') }}">
                <div class="d-flex">
                    <input type="number" name="id" class="form-control" placeholder="Enter Employee ID" value="{{Request::input('id')}}" required>
                    <select name="month" class="form-control">
                        <option value="1" @if($current_month==1) selected @endif>January</option>
                        <option value="2" @if($current_month==2) selected @endif>February</option>
                        <option value="3" @if($current_month==3) selected @endif>March</option>
                        <option value="4" @if($current_month==4) selected @endif>April</option>
                        <option value="5" @if($current_month==5) selected @endif>May</option>
                        <option value="6" @if($current_month==6) selected @endif>June</option>
                        <option value="7" @if($current_month==7) selected @endif>July</option>
                        <option value="8" @if($current_month==8) selected @endif>August</option>
                        <option value="9" @if($current_month==9) selected @endif>September</option>
                        <option value="10" @if($current_month==10) selected @endif>October</option>
                        <option value="11" @if($current_month==11) selected @endif>November</option>
                        <option value="12" @if($current_month==12) selected @endif>December</option>
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        @isset($days)
            <!--<h4 class="mt-4">Showing results from employe #<strong>{{Request::input('id')}}</strong> on <strong>{{date('F', strtotime($days[1]['date']))}}</strong></h4>
            -->

            <div class="col-12 d-flex mt-4">
                <div class="container col-6 table-responsive mt-2">
                    <div class="container">
                        <h3 class="text-center">DepEd-Gingoog</h3>
                        <h6 class="text-center" style="margin-top: -10px">DAILY TIME RECORD</h6>
                        <p class="text-center" style="margin-top: -10px">From: {{ date('m/d/y', strtotime($days[1]['date'])) }} To: {{ date('m/d/y', strtotime($days[count($days)]['date'])) }}</p>

                        <div>
                            <p>Name:</p>
                            <p style="margin-top: -15px">Position:</p>
                            <p style="margin-top: -15px">Department:</p>
                            <div class="d-flex" style="margin-top: -15px">
                                <p class="col-4">Regular Time: Regular</p>
                                <p class="col-4 offset-4">Payroll No.: <u> {{Request::input('id')}} &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead class=" text-info">
                            <th class="text-center" colspan="2">
                                WORKING
                            </th>
                            <th class="text-center" colspan="2">
                                AM
                            </th>
                            <th class="text-center" colspan="2">
                                PM
                            </th>
                            <th class="text-center" colspan="2">
                                HOURS
                            </th>
                        </thead>
                        <thead class=" text-info">
                            <th class="text-center">
                                Date
                            </th>
                            <th class="text-center">
                                Days
                            </th>
                            <th class="text-center">
                                In 1
                            </th>
                            <th class="text-center">
                                Out 1
                            </th>
                            <th class="text-center">
                                In 2
                            </th>
                            <th class="text-center">
                                Out 2
                            </th>
                            <th class="text-center">
                                UT
                            </th>
                            <th class="text-center">
                                OT
                            </th>
                        </thead>
                        <tbody>
                        @foreach ($days as $day)
                            <tr>
                                <td class="text-center">
                                    {{ date('d - M', strtotime($day['date'])) }}
                                </td>
                                <td class="text-center">
                                    {{ date('D', strtotime($day['date'])) }}
                                </td>
                                <td class="text-center">
                                    {{ $day['in1']!=null ? date('h:i a', strtotime($day['in1'])) : ' '}}
                                </td>
                                <td class="text-center">
                                    {{ $day['out1']!=null ? date('h:i a', strtotime($day['out1'])) : ' '}}
                                </td>
                                <td class="text-center">
                                    {{ $day['in2']!=null ? date('h:i a', strtotime($day['in2'])) : ' '}}  
                                </td>
                                <td class="text-center">
                                    {{ $day['out2']!=null ? date('h:i a', strtotime($day['out2'])) : ' '}}
                                </td>
                                <td class="text-center">
                                    
                                </td>
                                <td class="text-center">
                                    
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="container" style="margin-top: -10px;">
                        <div class="d-flex">
                            <p class="col-4">A = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                            <p class="col-4">ROT = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                            <p class="col-4">LOT = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                        </div>
                        <div class="d-flex" style="margin-top: -15px">
                            <p class="col-4">U = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                            <p class="col-4">SOT = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                        </div>
                        <p class="text-center" style="margin-bottom: 35px">I Certify on my honor that the above is a true and correct report<br> of the hours work performed, record of which was daily at<br> the time of arrival and departure from office.</p>
                        <hr>
                        <p class="text-center" style="margin-top: -15px">Signature</p>
                    </div>
                    <p class="text-center" style="margin-top: -10px">==============================================================</p>
                    <p class="text-center mb-4" style="margin-top: -15px">VERIFIED as to the prescribed office hours</p>
                    <hr>
                    <p class="text-center" style="margin-top: -15px">Incharge</p>
                    <p style="margin-top: -15px">>>>>>EMPLOYEE'S COPY</p>
                </div>
                <div class="container col-6 table-responsive mt-2">
                    <div class="container">
                        <h3 class="text-center">DepEd-Gingoog</h3>
                        <h6 class="text-center" style="margin-top: -10px">DAILY TIME RECORD</h6>
                        <p class="text-center" style="margin-top: -10px">From: {{ date('m/d/y', strtotime($days[1]['date'])) }} To: {{ date('m/d/y', strtotime($days[count($days)]['date'])) }}</p>

                        <div>
                            <p>Name:</p>
                            <p style="margin-top: -15px">Position:</p>
                            <p style="margin-top: -15px">Department:</p>
                            <div class="d-flex" style="margin-top: -15px">
                                <p class="col-4">Regular Time: Regular</p>
                                <p class="col-4 offset-4">Payroll No.: <u> {{Request::input('id')}} &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead class=" text-info">
                            <th class="text-center" colspan="2">
                                WORKING
                            </th>
                            <th class="text-center" colspan="2">
                                AM
                            </th>
                            <th class="text-center" colspan="2">
                                PM
                            </th>
                            <th class="text-center" colspan="2">
                                HOURS
                            </th>
                        </thead>
                        <thead class=" text-info">
                            <th class="text-center">
                                Date
                            </th>
                            <th class="text-center">
                                Days
                            </th>
                            <th class="text-center">
                                In 1
                            </th>
                            <th class="text-center">
                                Out 1
                            </th>
                            <th class="text-center">
                                In 2
                            </th>
                            <th class="text-center">
                                Out 2
                            </th>
                            <th class="text-center">
                                UT
                            </th>
                            <th class="text-center">
                                OT
                            </th>
                        </thead>
                        <tbody>
                        @foreach ($days as $day)
                            <tr>
                                <td class="text-center">
                                    {{ date('d - M', strtotime($day['date'])) }}
                                </td>
                                <td class="text-center">
                                    {{ date('D', strtotime($day['date'])) }}
                                </td>
                                <td class="text-center">
                                    {{ $day['in1']!=null ? date('h:i a', strtotime($day['in1'])) : ' '}}
                                </td>
                                <td class="text-center">
                                    {{ $day['out1']!=null ? date('h:i a', strtotime($day['out1'])) : ' '}}
                                </td>
                                <td class="text-center">
                                    {{ $day['in2']!=null ? date('h:i a', strtotime($day['in2'])) : ' '}}  
                                </td>
                                <td class="text-center">
                                    {{ $day['out2']!=null ? date('h:i a', strtotime($day['out2'])) : ' '}}
                                </td>
                                <td class="text-center">
                                    
                                </td>
                                <td class="text-center">
                                    
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="container" style="margin-top: -10px;">
                        <div class="d-flex">
                            <p class="col-4">A = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                            <p class="col-4">ROT = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                            <p class="col-4">LOT = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                        </div>
                        <div class="d-flex" style="margin-top: -15px">
                            <p class="col-4">U = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                            <p class="col-4">SOT = <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                        </div>
                        <p class="text-center" style="margin-bottom: 35px">I Certify on my honor that the above is a true and correct report<br> of the hours work performed, record of which was daily at<br> the time of arrival and departure from office.</p>
                        <hr>
                        <p class="text-center" style="margin-top: -15px">Signature</p>
                    </div>
                    <p class="text-center" style="margin-top: -10px">==============================================================</p>
                    <p class="text-center mb-4" style="margin-top: -15px">VERIFIED as to the prescribed office hours</p>
                    <hr>
                    <p class="text-center" style="margin-top: -15px">Incharge</p>
                    <p style="margin-top: -15px">>>>>>PERSONNEL'S COPY</p>
                    <p style="margin-top: -15px">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp RECORDED BY: <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                    <p style="margin-top: -15px">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp DATE  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp : <u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</u></p>
                </div>
            </div>

            @else
            <div class="text-center" style="opacity: 0.3; margin-top: 15%;">
                <h3>You may enter the Employee Id</h3>
                <h3>and choose a Month</h3>
            </div>

        @endisset

    </div>
</div>
@endsection
