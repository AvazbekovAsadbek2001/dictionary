<?php

namespace App\Filament\Resources\Words\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('section_id')
                    ->relationship('section', 'name_uz')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('name_uz')
                    ->required(),
                TextInput::make('name_ru')
                    ->required(),
            ]);
    }
}
