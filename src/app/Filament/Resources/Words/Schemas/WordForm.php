<?php

namespace App\Filament\Resources\Words\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('section_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name_uz')
                    ->required(),
                TextInput::make('name_ru')
                    ->required(),
            ]);
    }
}
