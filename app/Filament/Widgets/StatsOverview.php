<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Income;
use App\Models\Expense;
use Squire\Models\Currency;

class StatsOverview extends BaseWidget
{
    protected float $total_income = 0;
    protected float $total_expense = 0;
    protected float $total_revenue = 0;

    protected function formatAmount($value)
    {
        $currency = auth()->user()->currency ? auth()->user()->currency : 'usd';
        return Currency::find($currency)->format($value, true);
    }

    protected function getCards(): array
    {
        $this->total_expense = (new Expense())->TotalExpense();
        $this->total_income = (new Income())->TotalIncome();
        $this->total_revenue = $this->total_income - $this->total_expense;

        return [
            Card::make('Total Income', $this->formatAmount($this->total_income)),
            Card::make('Total Expense', $this->formatAmount($this->total_expense)),
            Card::make('Total Revenue', $this->formatAmount($this->total_revenue))
            // ->description($this->total_revenue > 0 ? 'Profit' : 'Loss')
            // ->descriptionIcon($this->total_revenue > 0 ? 'heroicon-s-trending-up' : 'heroicon-s-trending-down')
            // ->color($this->total_revenue > 0 ? 'success' : 'danger'),
        ];
    }
}
