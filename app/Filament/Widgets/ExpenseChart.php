<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class ExpenseChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Distribusi Pengeluaran';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1;
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // INI YANG DIBENERIN: Ganti tableFilters jadi filters
        $startDate = $this->filters['startDate'] ?? now()->startOfMonth();
        $endDate = $this->filters['endDate'] ?? now()->endOfMonth();

        $data = Expense::query()
            ->select('category_id', DB::raw('SUM(biaya) as total'))
            ->when($startDate, fn($query) => $query->whereDate('tanggal', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal', '<=', $endDate))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Biaya',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => ['#f59e0b', '#3b82f6', '#10b981', '#ef4444', '#8b5cf6', '#6366f1', '#ec4899'],
                ],
            ],
            'labels' => $data->map(fn($item) => $item->category->name ?? 'Tanpa Kategori')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
