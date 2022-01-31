<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Income;
use App\Models\Expense;

class StatsOverview extends BaseWidget
{
    protected int $total_income = 0;
    protected int $total_expense = 0;
    protected int $total_revenue = 0;

    protected function getCards(): array
    {
        $this->total_expense = (new Expense())->TotalExpense();
        $this->total_income = (new Income())->TotalIncome();
        $this->total_revenue = $this->total_income - $this->total_expense;

        return [
            Card::make('Total Income', '₹ ' . $this->total_income),
            Card::make('Total Expense', '₹ ' . $this->total_expense),
            Card::make('Total Revenue', '₹ ' .  $this->total_revenue)
                ->description($this->total_revenue > 0 ? 'Profit' : 'Loss')
                ->descriptionIcon($this->total_revenue > 0 ? 'heroicon-s-trending-up' : 'heroicon-s-trending-down')
                ->color($this->total_revenue > 0 ? 'success' : 'danger'),
        ];
    }
}
