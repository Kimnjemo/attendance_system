<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
  //  public function collection()
    //{
      //  return Attendance::all();
   // }


    public function collection()
    {
        return Attendance::with('user')->get()->map(function ($attendance) {
            return [
                'name' => $attendance->user->name,
                'email' => $attendance->user->email,
                'date' => $attendance->date,
                'check_in' => $attendance->check_in,
                'latitude' => $attendance->latitude,
                'longitude' => $attendance->longitude,
                'location_status' => $attendance->location_status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Date',
            'Check In',
            'Latitude',
            'Longitude',
            'Location Status',
        ];
    }




}
