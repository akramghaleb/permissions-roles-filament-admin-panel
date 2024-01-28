<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Filament\Resources\RoleResource\RelationManagers\PermissionsRelationManager;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;
use stdClass;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Settings';


    protected static ?int $navigationSort = 62;

    // Main Title
    // protected static ?string $title = 'About';
    public static function getPluralModelLabel(): string
    {
        return __('Role.PluralModelLabel');
    }

    public static function getModelLabel(): string
    {
        return __('Role.ModelLabel');
    }

    // Group Name
    // protected static ?string $navigationGroup = 'General Settings';
    public static function getNavigationGroup(): string
    {
        return __('Role.group');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->label(__('Role.name')),
                    MultiSelect::make('permissions')
                        ->relationship('permissions','name')
                        ->preload()
                        ->required()
                        ->label(__('Role.permissions')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->getStateUsing(static
                function (stdClass $rowLoop): string {
                    return (string) $rowLoop->iteration;
                })->label('#'),
                //TextColumn::make('id')->sortable()->label('#'),
                TextColumn::make('name')->sortable()->searchable()
                    ->label(__('Role.name')),
                TextColumn::make('created_at')->dateTime('d-M-Y')
                    ->sortable()
                    ->label(__('Role.created_at')),
            ])
            ->defaultSort('created_at', 'desc')
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
