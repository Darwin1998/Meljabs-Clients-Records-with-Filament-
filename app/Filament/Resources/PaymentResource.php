<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class PaymentResource extends Resource
{


    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Shop';







    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.full_name'),
                TextColumn::make('amount')->formatStateUsing(fn (string $state): string => __("₱".$state)),
                TextColumn::make('date')->date('F j, Y'),
                TextColumn::make('status'),
                TextColumn::make('created_at')->date('F j, Y')->label('Created at')->sortable(),
                TextColumn::make('received_by'),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                            ->options([
                                'paid' => 'Paid',
                                'unpaid' => 'Unpaid',]),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until')
                    ])
                    ->query(function ($query , array $data){
                        return $query
                            ->when($data['created_from'],
                                fn($query) => $query->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'],
                                fn($query) => $query->whereDate('created_at', '>=', $data['created_until']));
                    })
            ])
            ->actions([

            ])
            ->bulkActions([

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
            'index' => Pages\ListPayments::route('/'),


        ];
    }

}
