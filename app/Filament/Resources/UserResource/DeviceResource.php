<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DeviceResource extends Resource
{
    // Tell Filament which model this resource controls
    protected static ?string $model = Device::class;

    // Navigation settings
    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected static ?string $navigationLabel = 'Devices';
    protected static ?string $modelLabel = 'Device';
    protected static ?string $pluralModelLabel = 'Devices';

    // Define the form schema used when creating or editing a device
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Dropdown for selecting a user who doesn't already have a device
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship(
                        name: 'user',
                        titleColumnName: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->doesntHave('device') // only users without devices
                    )
                    ->searchable()
                    ->required(),

                // Text input for device ID with uniqueness check
                Forms\Components\TextInput::make('device_id')
                    ->label('Device ID')
                    ->required()
                    ->unique(ignoreRecord: true) // allow editing without breaking unique rule
                    ->maxLength(255),
            ]);
    }

    // Define the table displayed in the Devices page
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Display user name
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                // Display device ID
                Tables\Columns\TextColumn::make('device_id')
                    ->label('Device ID')
                    ->searchable()
                    ->sortable(),

                // Display when the device was registered
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // No extra relations in this resource
    public static function getRelations(): array
    {
        return [];
    }

    // Routing pages for listing, creating, editing
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}
