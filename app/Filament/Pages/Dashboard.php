<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Select;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    /**
     * Kita hapus semua type-hint (Form) supaya gak bentrok sama Schema
     */
    public function filtersForm($form)
    {
        return $form
            ->schema([
                Select::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->default(now()->format('m')),
                Select::make('tahun')
                    ->label('Tahun')
                    ->options(array_combine(range(date('Y'), 2024), range(date('Y'), 2024)))
                    ->default(now()->format('Y')),
            ])
            ->columns(2);
    }
}
