<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\DatePicker;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm($form)
    {
        return $form
            ->schema([
                // Filter Dari Tanggal langsung dipasang tanpa dibungkus Section
                DatePicker::make('startDate')
                    ->label('Dari Tanggal')
                    ->default(now()->startOfMonth())
                    ->live(), // Biar otomatis refresh data

                // Filter Sampai Tanggal
                DatePicker::make('endDate')
                    ->label('Sampai Tanggal')
                    ->default(now()->endOfMonth())
                    ->live(), // Biar otomatis refresh data
            ])
            ->columns(2); // Bikin sejajar kiri-kanan
    }
}
