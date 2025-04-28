<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Manager\Resources\VacancyResource\Pages;
use App\Filament\Manager\Resources\VacancyResource\RelationManagers;
use App\Models\Vacancy;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VacancyResource extends Resource
{
    protected static ?string $model = Vacancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название вакансии')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('published_at')
                    ->label('Дата публикации')
                    ->default(now())
                    ->required(),
                DatePicker::make('work_date')
                    ->label('Дата подработки')
                    ->required(),
                TextInput::make('hours')
                    ->label('Количество часов')
                    ->numeric()
                    ->required(),
                TextInput::make('price')
                    ->label('Оплата за смену')
                    ->numeric()
                    ->required(),
                Select::make('user_id')
                    ->label('Администратор вакансии')
                    ->relationship('user', 'name', function ($query) {
                        $query->where('role_id', 2);
                    })
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('user.name')->label('Администратор')->sortable(),
                TextColumn::make('work_date')->label('Дата подработки')->date('d.m.Y'),
                TextColumn::make('hours')->label('Часы')->sortable(),
                TextColumn::make('price1')->label('Оплата')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVacancies::route('/'),
            'create' => Pages\CreateVacancy::route('/create'),
            'edit' => Pages\EditVacancy::route('/{record}/edit'),
        ];
    }
}
