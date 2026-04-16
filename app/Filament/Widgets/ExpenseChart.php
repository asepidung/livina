<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class ExpenseChart extends ChartWidget
{
    use InteractsWithPageFilters;

    // Heading di Chart JANGAN pakai static
    protected ?string $heading = 'Distribusi Pengeluaran';

    // Sort di Chart WAJIB pakai static
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $bulan = $this->tableFilters['bulan'] ?? now()->format('m');
        $tahun = $this->tableFilters['tahun'] ?? now()->format('Y');

        $data = Expense::query()
            ->select('category_id', DB::raw('SUM(biaya) as total'))
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
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
