<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Filament\Resources\RoleResource\RelationManagers\PermissionsRelationManager;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'الاعدادات';


    protected static ?int $navigationSort = 2;

    //protected static ?string $navigationLabel = 'الاذونات';

    protected static ?string $pluralModelLabel = 'الصلاحيات';
    protected static ?string $modelLabel = 'صلاحية';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                    ->unique(ignoreRecord: true)
                    ->required()->label('الاسم'),
                    MultiSelect::make('permissions')
                    ->relationship('permissions','name')
                    ->preload()
                    ->required()->label('الاذونات'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('#'),
                TextColumn::make('name')->sortable()->searchable()->label('الاسم'),
                TextColumn::make('created_at')->dateTime('d-M-Y')->sortable()->searchable()->label('تاريخ الانشاء'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PermissionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
