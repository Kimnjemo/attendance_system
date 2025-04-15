<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceSettingResource\Pages;
use App\Filament\Resources\AttendanceSettingResource\RelationManagers;
use App\Models\AttendanceSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceSettingResource extends Resource
{
    protected static ?string $model = AttendanceSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TimePicker::make('start_time')->required(),
                
                    Forms\Components\TimePicker::make('start_time')->required(),
                    Forms\Components\TimePicker::make('end_time')->required(),
                    Forms\Components\TextInput::make('radius')->numeric()->required(),
                    Forms\Components\Toggle::make('allow_late_checkin'),
                    Forms\Components\Toggle::make('use_geofence'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_time')->label('Start Time'),
                Tables\Columns\TextColumn::make('end_time')->label('End Time'),
                Tables\Columns\TextColumn::make('radius')->label('Radius'),
                Tables\Columns\IconColumn::make('allow_late_checkin')->boolean(),
                Tables\Columns\IconColumn::make('use_geofence')->boolean(),
              
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canViewAny(): bool
{
    return auth()->user()?->isAdmin(); // adjust this check as per your system
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendanceSettings::route('/'),
            'create' => Pages\CreateAttendanceSetting::route('/create'),
            'edit' => Pages\EditAttendanceSetting::route('/{record}/edit'),
        ];
    }
}
