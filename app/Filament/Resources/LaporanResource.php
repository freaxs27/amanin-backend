<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanResource\Pages;
use App\Filament\Resources\LaporanResource\RelationManagers;
use App\Models\Laporan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class LaporanResource extends Resource
{
    protected static ?string $model = Laporan::class;
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?string $pluralLabel = 'Laporan';
    protected static ?string $slug = 'laporan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpan(2),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->columnSpan(2)
                    ->preserveFilenames(),
                    Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ])
                    ->label('Status')
                    ->required()
                    ->reactive()
                    ->disabled(fn ($livewire) => $livewire instanceof ViewRecord) // Disable status di View
                    ->afterStateUpdated(function ($state, $set) {
                        // Menambahkan styling warna pada status
                        $color = match ($state) {
                            'pending' => 'gray',
                            'approved' => 'blue',
                            'rejected' => 'red',
                            'completed' => 'green',
                        };
                        $set('status_color', $color); // Simpan warna status di field tersembunyi
                    }),
                Forms\Components\TextInput::make('status_color')
                    ->hidden() // Menyembunyikan warna status
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->width(50)
                    ->rowIndex(),
                Tables\Columns\ImageColumn::make('image')
                    ->searchable()
                    ->width(200)
                    ->height(200)
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Judul'),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->label('Deskripsi'),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'approved' => 'primary',
                        'completed' => 'success',
                        'rejected' => 'danger',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->searchable()
                    ->dateTime('d M Y')
                    ->label('Tanggal Dibuat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->searchable()
                    ->dateTime('d M Y')
                    ->label('Tanggal Diubah')
                    ->sortable(),       
            ])
            ->defaultSort('updated_at', 'desc')
            ->emptyStateHeading('Tidak ada laporan yang ditemukan')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',                       
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ])
                    ->label('Status')
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation(),                
                    
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make('export_bulk'),
                ]),
            ])
            ->recordAction(null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporans::route('/'),
            // 'create' => Pages\CreateLaporan::route('/create'),
            'edit' => Pages\EditLaporan::route('/{record}/edit'),
        ];
    }
}
