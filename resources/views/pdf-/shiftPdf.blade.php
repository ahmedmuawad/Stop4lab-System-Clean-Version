@extends('layouts.pdf_2')
@section('title')
    {{ __('Shift') }}-{{ date('Y-m-d') }}
@endsection
@section('content')
    <style>
        .title {
            font-size: 20px;
            background-color: #dddddd;
            border: 1px solid black !important;
            margin-bottom: 10px;
            font-family: 'arial';
        }

        .table {
            margin-top: 20px;
            font-family: 'arial';
        }

        .accounting_header {
            border: 2px solid black;
            background-color: #F0F0F0;
            font-family: 'arial';
        }

        th {
            font-family: 'arial';
        }
    </style>
      @php
      $shift->employees = $shift->Usershift;
      $shift->employees = array_column($shift->employees->toArray(), 'employees');
      
  @endphp
       <div class="accounting_header mb-3" style="margin-bottom:10px !important">
        <h2 align="center">{{ $info_settings['name'] }} </h2>
    </div>
    <table width="100%">
        <thead>
            <tr class="title">
                <th colspan="3" align="center">
                    {{ $shift->name }} - {{ get_system_date() }}
                </th>
            </tr>
            <tr>
                <th>{{ __('starting_at') }}</th>
                <th>{{ __('ending_at') }}</th>
                <th>{{ __('employee') }}</th>
            </tr>
        </thead>
        <tbody>
          
            <tr>
                <td>
                    {{ $shift['start_at'] }}
                </td>
                <td>
                    {{ $shift['end_at'] }}
                </td>
                {{-- {{dd($shift->employees[0]->name)}} --}}
                <td rowspan="{{count($shift->employees)}}">
                    @foreach ($shift->employees as $employee)
                        <b style="margin-left:2px;margin-right:2px;margin-top:10px"><p style="font-weight: bold !important">
                                {{ $employee['user']['name'] }}
                        </p> </b>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
@endsection
