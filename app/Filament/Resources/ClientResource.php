<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers\PaymentsRelationManager;
use App\Models\Barangay;
use App\Models\Client;
use App\Models\Payment;
use Filament\Forms;
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
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
// use Filament\Pages\Actions\Action;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\SelectColumn;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'first_name';

    protected static ?string $navigationGroup = 'Shop';

    protected static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('first_name')->required(),
                    TextInput::make('last_name')->required(),
                    Select::make('barangay_id')
                        ->relationship('barangay', 'name')->required(),

                    DatePicker::make('installation_date')->required(),
                    TextInput::make('amount')->required()->numeric(true)->label('Installation Fee'),
                    Select::make('payment_method')
                            ->options([
                                'gcash' => 'G-Cash',
                                'cash' => 'Cash',
                            ])
                            ->default('cash')
                            ->disablePlaceholderSelection()

                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                // ImageColumn::make('image'),
                TextColumn::make('first_name')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->searchable(),

                TextColumn::make('last_name')
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->sortable(),

                TextColumn::make('barangay.name')
                    ->searchable(),

                TextColumn::make('installation_date')
                    ->date($format = 'F j, Y'),

                TextColumn::make('amount')
                    ->formatStateUsing(fn (string $state): string => __("₱".$state))
                    ->label('Installation Fee'),


            ])->defaultSort('created_at','desc')
            ->filters([

                SelectFilter::make('barangay_id')
                    ->relationship('barangay', 'name')->label('Barangay'),

            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->color('success'),
                Tables\Actions\ViewAction::make()->button()->color('primary'),



            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
            'view' => Pages\ViewClient::route('/{record}'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }



}
