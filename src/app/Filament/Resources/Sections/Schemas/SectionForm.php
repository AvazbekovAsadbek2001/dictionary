<?php

namespace App\Filament\Resources\Sections\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('menu_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name_uz')
                    ->required(),
                TextInput::make('name_ru')
                    ->required(),
            ]);
    }
}
