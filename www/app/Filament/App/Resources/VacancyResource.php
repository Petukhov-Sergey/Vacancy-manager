<?php
namespace App\Filament\App\Resources;

use App\Filament\App\Resources\VacancyResource\Pages\ViewVacancy;
use Filament\Resources\Resource;

class VacancyResource extends Resource
{
    protected static ?string $model = \App\Models\Vacancy::class;

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\App\Resources\VacancyResource\Pages\ListVacancies::route('/'),
        ];
    }

}
