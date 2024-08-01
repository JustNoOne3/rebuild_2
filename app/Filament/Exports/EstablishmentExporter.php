<?php

namespace App\Filament\Exports;

use App\Models\Establishment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EstablishmentExporter extends Exporter
{
    protected static ?string $model = Establishment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('est_name'),
            ExportColumn::make('est_street'),
            ExportColumn::make('region_id'),
            ExportColumn::make('province_id'),
            ExportColumn::make('city_id'),
            ExportColumn::make('barangay_id'),
            ExportColumn::make('est_nature'),
            ExportColumn::make('est_products'),
            ExportColumn::make('est_class'),
            ExportColumn::make('est_tin'),
            ExportColumn::make('est_sss'),
            ExportColumn::make('est_payment'),
            ExportColumn::make('est_yearImplemented'),
            ExportColumn::make('est_numworkMale'),
            ExportColumn::make('est_numworkFemale'),
            ExportColumn::make('est_numworkManager'),
            ExportColumn::make('est_numworkSupervisor'),
            ExportColumn::make('est_numworkRanks'),
            ExportColumn::make('est_numworkTotal'),
            ExportColumn::make('est_permit'),
            ExportColumn::make('est_govId'),
            ExportColumn::make('est_owner'),
            ExportColumn::make('est_designation'),
            ExportColumn::make('est_fax'),
            ExportColumn::make('est_contactNum'),
            ExportColumn::make('est_email'),
            ExportColumn::make('est_status'),
            ExportColumn::make('est_acknowledgement'),
            ExportColumn::make('est_certIssuance'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your establishment export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
