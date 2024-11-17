<?php

namespace App\Filament\Resources\LaporanResource\Pages;

use App\Filament\Resources\LaporanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class ListLaporans extends ListRecords
{
    protected static string $resource = LaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_all')
            ->label('Export')
            ->color('success')
            ->action(function () {
                return Excel::download(new LaporanExport, 'laporan_all.xlsx');
            }),
            // Actions\CreateAction::make(),
        ];
    }

}
