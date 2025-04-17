<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;


use App\Exports\AttendanceExport;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;





class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required()
                ->label('Employee'),

            Forms\Components\DatePicker::make('date')
                ->required()
                ->label('Attendance Date'),

            Forms\Components\TimePicker::make('check_in')
                ->required()
                ->label('Check-In Time'),

            Forms\Components\TextInput::make('latitude')
                ->required()
                ->label('Latitude'),

            Forms\Components\TextInput::make('longitude')
                ->required()
                ->label('Longitude'),

            Forms\Components\Select::make('location_status')
                ->options([
                    'inside' => 'Inside Geofence',
                    'outside' => 'Outside Geofence',
                ])
                ->required()
                ->label('Location Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->label('Name')
                ->searchable()
                ->sortable(),
        
            TextColumn::make('user.email')
                ->label('Email')
                ->searchable()
                ->sortable(),
        
            TextColumn::make('date')
                ->label('Date')
                ->sortable(),
        
            TextColumn::make('check_in')
                ->label('Check In'),
        
            TextColumn::make('location_status')
                ->label('Status'),
            ])//end of column



            ->filters([

                Tables\Filters\Filter::make('name')
                ->form([
                    Forms\Components\TextInput::make('name')->label('Search by Name'),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->whereHas('user', function ($q) use ($data) {
                        $q->where('name', 'like', '%' . $data['name'] . '%');
                    });
                }),
        
            Tables\Filters\Filter::make('email')
                ->form([
                    Forms\Components\TextInput::make('email')->label('Search by Email'),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->whereHas('user', function ($q) use ($data) {
                        $q->where('email', 'like', '%' . $data['email'] . '%');
                    });
                }),
        
            Tables\Filters\Filter::make('date')
                ->form([
                    Forms\Components\DatePicker::make('date')->label('Filter by Date'),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->when($data['date'], fn ($q) => $q->where('date', $data['date']));
                }),
                //
            ])//end of filter





            ->actions([
                Tables\Actions\EditAction::make(),
            ])//end of action


            ->headerActions([
                Action::make('Export to Excel')
                    ->label('Export To Excel')
                    ->color('success') // available: primary, success, danger, warning, secondary, gray
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn () => auth()->user()->role === 'admin')
                    ->action(function () {
                        return response()->streamDownload(function () {
                            echo Excel::raw(new AttendanceExport, \Maatwebsite\Excel\Excel::XLSX);
                        }, 'attendances.xlsx');
                    })
                   
                    
                    
            ])


            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);//end of bulkActions





            
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }





    public static function getEloquentQuery(): Builder
{
    $user = Auth::user();

    // If user is admin or HR, show all records
    if (in_array($user->role, ['admin', 'hr'])) {
        return parent::getEloquentQuery();
    }

    // Otherwise, show only records belonging to the logged-in user
    return parent::getEloquentQuery()->where('user_id', $user->id);
}






}
