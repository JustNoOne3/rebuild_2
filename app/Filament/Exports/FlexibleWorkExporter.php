<?php

namespace App\Filament\Exports;

use App\Models\FlexibleWork;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class FlexibleWorkExporter extends Exporter
{
    protected static ?string $model = FlexibleWork::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('fwa_startDate'),
            ExportColumn::make('fwa_endDate'),
            ExportColumn::make('fwa_type'),
            ExportColumn::make('fwa_typeSpecify'),
            ExportColumn::make('fwa_reason'),
            ExportColumn::make('fwa_reasonSpecify'),
            ExportColumn::make('fwa_affectedWorkers'),
            ExportColumn::make('fwa_agreement'),
            ExportColumn::make('fwa_owner'),
            ExportColumn::make('fwa_designation'),
            ExportColumn::make('fwa_contact'),
            ExportColumn::make('fwa_estabId'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your flexible work export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
