<?php

namespace App\Filament\Resources\Words\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WordInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('section_id')
                    ->numeric(),
                TextEntry::make('name_uz'),
                TextEntry::make('name_ru'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
