<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

     protected static ?string $recordTitleAttribute = 'first_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('received_by')->required(),
                    TextInput::make('amount')->numeric()->required(),
                    TextInput::make('payment_mode')->required(),
                    Select::make('status')->options([
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid'
                    ])->required(),
                    DatePicker::make('date')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.full_name'),
                TextColumn::make('amount')->formatStateUsing(fn (string $state): string => __("₱".$state)),
                TextColumn::make('date')->date('F j, Y'),
                TextColumn::make('status'),
                TextColumn::make('created_at')->dateTime('F j, Y  g:i:s A')->label('Created at')->sortable(),
                TextColumn::make('received_by'),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()

            ])
            ->actions([
                Tables\Actions\EditAction::make()->button(),

            ]);
    }


    protected function getTableContentFooter(): ?View
    {
        return view('filament.clients.footer');
    }

}
