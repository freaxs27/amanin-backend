<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back') 
                ->action(function () {
                    return redirect()->route('filament.admin.resources.reports.index');
                }),
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->color('danger'),
        ];
    }
}

