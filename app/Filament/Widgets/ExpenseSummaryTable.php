<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class ExpenseSummaryTable extends BaseWidget
{
    protected static ?string $heading = 'Rangkuman Biaya Bulan Ini';

    protected int | string | array $columnSpan = [
        'md' => 1,
        'lg' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Expense::query()
                    // Kita alias-kan category_id sebagai 'id' supaya Filament seneng
                    ->select('category_id as id', 'category_id', DB::raw('SUM(biaya) as total'))
                    ->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year)
                    ->groupBy('category_id')
                    ->with('category')
            )
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->summarize(Tables\Columns\Summarizers\Sum::make()
                        ->label('Total Semua')
                        ->money('IDR')),
            ])
            ->paginated(false);
    }
}
