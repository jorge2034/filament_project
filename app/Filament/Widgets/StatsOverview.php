<?php

namespace App\Filament\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEmployees = User::all()->count();
        $totalHolidays = Holiday::where('type','pending')->get()->count();
        $totalTimesheets = Timesheet::all()->count();
        return [
            Stat::make('Empleados', $totalEmployees)
            ->description('32k increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
            ->color('success'),
            Stat::make('Vacaciones pendientes', $totalHolidays),
            Stat::make('Timesheets', $totalTimesheets),
        ];
    }
}
