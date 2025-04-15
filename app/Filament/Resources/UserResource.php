<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;




class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                ->required()
                ->maxLength(255),

         TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
   /*
            TextInput::make('api_token')
                ->label('API Token')
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->nullable(),
*/
/*TextInput::make('api_token')
    ->label('API Token')
    ->helperText('Copy this token manually if needed.')
    ->disabled()
    //->copyable()
    ,

*/



            Select::make('role')
                ->required()
                ->options([
                    'admin' => 'Admin',
                    'employee' => 'Employee',
                ])
               // ->default('employee')
               ->required(),

            DateTimePicker::make('email_verified_at')
                ->label('Email Verified At')
                ->nullable(),

            TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255)
                ->dehydrated(fn ($state) => filled($state)) // Only save if input
                ->label('Password'),


                Select::make('location_id')
                ->label('Location')
                ->relationship('location', 'name') // 'name' is the column in locations table
                ->searchable()
                ->required()
                ->preload(),
                //->visible(fn (Forms\Get $get) => $get('role') === 'employee'),
            
            

            ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('role')->sortable()->searchable(),
              //  TextColumn::make('email_verified_at')->dateTime()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                
                
                TextColumn::make('location.name')
                ->label('Location')
                ->sortable()
                ->searchable()
                ,
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()?->role === 'admin'),
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






    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->role === 'admin' || auth()->user()?->role === 'hr';
    }
    

// Only admin can view the list of users
public static function canViewAny(): bool
{
    return auth()->user()?->role === 'admin';
}





    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
