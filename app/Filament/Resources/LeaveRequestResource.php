<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Models\LeaveRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('User')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('type')
                ->label('Leave Type')
                ->options([
                    'sick' => 'Sick Leave',
                    'vacation' => 'Vacation Leave',
                    'personal' => 'Personal Leave',
                ])
                ->required()
                ,

            Forms\Components\DatePicker::make('start_date')
                ->label('Start Date')
                ->required(),

            Forms\Components\DatePicker::make('end_date')
                ->label('End Date')
                ->required(),

            Forms\Components\Textarea::make('reason')
                ->label('Reason')
                ->nullable(),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->default('pending')
                ->required(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('user.name')
                ->label('Employee')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('start_date')
                ->label('Start')
                ->date(),

            Tables\Columns\TextColumn::make('end_date')
                ->label('End')
                ->date(),

            Tables\Columns\TextColumn::make('reason')
                ->limit(50),

            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'primary' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ])
                ->sortable(),
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
