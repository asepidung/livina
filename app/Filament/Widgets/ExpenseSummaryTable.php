<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class ExpenseSummaryTable extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Rangkuman Biaya Periode Ini';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                // INI YANG DIBENERIN: Ganti tableFilters jadi filters
                $startDate = $this->filters['startDate'] ?? now()->startOfMonth();
                $endDate = $this->filters['endDate'] ?? now()->endOfMonth();

                return Expense::query()
                    ->select('category_id as id', 'category_id', DB::raw('SUM(biaya) as total'))
                    ->when($startDate, fn($query) => $query->whereDate('tanggal', '>=', $startDate))
                    ->when($endDate, fn($query) => $query->whereDate('tanggal', '<=', $endDate))
                    ->groupBy('category_id')
                    ->with('category');
            })
            ->columns([
                Tables\Columns\TextColumn::make('category.name')->label('Kategori'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->summarize(Tables\Columns\Summarizers\Sum::make()->label('Total Semua')->money('IDR')),
            ])
            ->paginated(false);
    }
}
