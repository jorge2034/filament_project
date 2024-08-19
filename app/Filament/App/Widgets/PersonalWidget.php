<?php

namespace App\Filament\App\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PersonalWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pending', $this->getPendingHoliday(Auth::user())),
            Stat::make('Total approved', $this->getApprovedHoliday(Auth::user())),
            Stat::make('Total work', $this->getTotalWork(Auth::user())),
        ];
    }

    protected function getPendingHoliday(User $user){
        $totalPendingHoliday = Holiday::where('user_id', $user->id)
        ->where('type','pending')->get()->count();
        return $totalPendingHoliday;
    }
    protected function getApprovedHoliday(User $user){
        $totalApprovedHoliday = Holiday::where('user_id', $user->id)
        ->where('type','approved')->get()->count();
        return $totalApprovedHoliday;
    }

    protected function getTotalWork(User $user){
        $timesheets = Timesheet::where('user_id',$user->id)
        ->where('type','work')->get();

        $sum = 0;

        foreach ($timesheets as $timesheet) {
            # code...
            $startTime = Carbon::parse($timesheet->day_in);
            $endTime = Carbon::parse($timesheet->day_out);

            $totalDuration = $endTime->diffInSeconds($startTime);
            $sum+=$totalDuration;
        }
        $tiempoFormato = gmdate("H:i:s",$sum);//convierte los segundos a formato hora:minuto:segundos
        return $tiempoFormato;

    }
}
