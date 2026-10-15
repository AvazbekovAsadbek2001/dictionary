<?php

namespace App\Filament\Resources\Sections\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('menu_id')
                    ->relationship('menu', 'name_uz')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('name_uz')
                    ->required(),
                TextInput::make('name_ru')
                    ->required(),
            ]);
    }
}
