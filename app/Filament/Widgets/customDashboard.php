<?php

// app/Filament/Widgets/CustomDashboard.php
namespace App\Filament\Widgets;

use Filament\Widgets\DashboardWidget;
use App\Filament\Widgets\MonthlyChart; // Pastikan sudah membuat MonthlyChart sebelumnya
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\YourOtherWidget; // Ganti dengan widget lain yang kamu buat

class CustomDashboard extends DashboardWidget
{
    protected static ?string $heading = 'My Custom Dashboard';

    // Tentukan urutan widget yang ingin ditampilkan di dashboard
    protected function getWidgets(): array
    {
        return [
            MonthlyChart::class, // Widget pertama (paling kiri)
            StatsOverviewWidget::class, // Widget kedua
            YourOtherWidget::class, // Widget ketiga
        ];
    }
}
