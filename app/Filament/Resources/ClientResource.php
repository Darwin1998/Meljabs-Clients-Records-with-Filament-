<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers\PaymentsRelationManager;
use App\Models\Client;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'first_name';

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('first_name')
                            ->required(),

                        TextInput::make('last_name')
                            ->required(),

                        TextInput::make('contact_number')
                            ->required()
                            ->regex('((^(\+)(\d){12}$)|(^\d{11}$))'),

                        Select::make('barangay_id')
                            ->relationship('barangay', 'name')
                            ->required(),

                        DatePicker::make('installation_date')
                            ->required(),

                        TextInput::make('amount')
                            ->required()
                            ->numeric(true)
                            ->label('Installation Fee'),

                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->default('active')
                            ->disablePlaceholderSelection(),

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

                TextColumn::make('status')
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state))),

                TextColumn::make('barangay.name')
                    ->searchable(),

                TextColumn::make('installation_date')
                    ->date($format = 'F j, Y'),

                TextColumn::make('amount')
                    ->formatStateUsing(fn (string $state): string => __('₱' . $state))
                    ->label('Installation Fee'),

            ])->defaultSort('created_at', 'desc')
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

    protected static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
