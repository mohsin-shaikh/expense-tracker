<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Activity;

class RecentActivity extends Widget implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $view = 'filament.widgets.recent-activity';

    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Activity::latest()->take(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('subject.title')
                ->label('Title'),
            Tables\Columns\BadgeColumn::make('subject_type')
                ->enum([
                    'expense' => 'Expense',
                    'income' => 'Income',
                ])
                ->colors([
                    'danger' => 'expense',
                    'success' => 'income',
                ])
                ->label('Type'),
            Tables\Columns\TextColumn::make('subject.category.name')
                ->label('Category'),
            Tables\Columns\TextColumn::make('subject.amount')
                ->getStateUsing(fn ($record): string => '₹ ' . $record->subject->amount)
                ->label('Amount'),
            Tables\Columns\TextColumn::make('subject.entry_date')
                ->label('Entry Date')
                ->date(),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
