<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal')
                    ->required(),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable() // Biar bisa dicari dengan diketik
                    ->preload()    // Biar data langsung muncul pas diklik
                    ->required()
                    // INI FITUR TAMBAH KATEGORI INSTAN (+)
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nama Kategori Baru')
                            ->required()
                            ->unique('categories', 'name'),
                    ]),

                TextInput::make('keterangan'),

                TextInput::make('odo')
                    ->label('Odometer')
                    ->numeric(),

                TextInput::make('biaya')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'), // Tambahin prefix biar cakep pas input
            ]);
    }
}
