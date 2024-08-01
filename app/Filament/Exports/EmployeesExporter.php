<?php

namespace App\Filament\Exports;

use App\Models\Employees;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployeesExporter extends Exporter
{
    protected static ?string $model = Employees::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('emp_lastName'),
            ExportColumn::make('emp_firstName'),
            ExportColumn::make('emp_middleName'),
            ExportColumn::make('emp_extensionName'),
            ExportColumn::make('emp_birthday'),
            ExportColumn::make('emp_sex'),
            ExportColumn::make('emp_civilStatus'),
            ExportColumn::make('emp_houseNum'),
            ExportColumn::make('emp_street'),
            ExportColumn::make('emp_region'),
            ExportColumn::make('emp_province'),
            ExportColumn::make('emp_city'),
            ExportColumn::make('emp_barangay'),
            ExportColumn::make('emp_wage'),
            ExportColumn::make('emp_numDependents'),
            ExportColumn::make('emp_serviceLength'),
            ExportColumn::make('emp_occupation'),
            ExportColumn::make('emp_yearsExp'),
            ExportColumn::make('emp_employmentStatus'),
            ExportColumn::make('emp_shiftStart'),
            ExportColumn::make('emp_shiftEnd'),
            ExportColumn::make('emp_workHours'),
            ExportColumn::make('emp_workDays'),
            ExportColumn::make('emp_injill'),
            ExportColumn::make('emp_injNature'),
            ExportColumn::make('emp_injAffected'),
            ExportColumn::make('emp_illType'),
            ExportColumn::make('emp_illLocation'),
            ExportColumn::make('emp_dateStart'),
            ExportColumn::make('emp_dateReturned'),
            ExportColumn::make('emp_daysLost'),
            ExportColumn::make('emp_daysCharged'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
