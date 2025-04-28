<?php

namespace App\Filament\App\Resources\VacancyResource\Pages;

use App\Filament\App\Resources\VacancyResource;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class ListVacancies extends ListRecords
{
    protected static string $resource = VacancyResource::class;
    public function table(Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Администратор')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Название вакансии')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->date()
                    ->sortable(),

                TextColumn::make('work_date')
                    ->label('Дата подработки')
                    ->date()
                    ->sortable(),

                TextColumn::make('hours')
                    ->label('Часов в смену')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Стоимость')
                    ->money('RUB')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name', function ($query) {
                        $query->where('role_id', 2);
                    })
                    ->label('Администратор вакансии'),

                Filter::make('work_date')
                    ->form([
                        DatePicker::make('work_from')
                            ->label('С даты'),
                        DatePicker::make('work_until')
                            ->label('По дату'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['work_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('work_date', '>=', $date),
                            )
                            ->when(
                                $data['work_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('work_date', '<=', $date),
                            );
                    }),

                Filter::make('price')
                    ->form([
                        TextInput::make('min_price')
                            ->label('Минимальная цена')
                            ->numeric(),
                        TextInput::make('max_price')
                            ->label('Максимальная цена')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_price'],
                                fn (Builder $query, $price): Builder => $query->where('price', '>=', $price),
                            )
                            ->when(
                                $data['max_price'],
                                fn (Builder $query, $price): Builder => $query->where('price', '<=', $price),
                            );
                    }),
            ])
            ->defaultSort('work_date', 'asc');
    }
}
