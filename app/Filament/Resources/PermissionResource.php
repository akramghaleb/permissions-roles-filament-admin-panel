<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Permission;
use stdClass;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 63;

    // Main Title
    // protected static ?string $title = 'About';
    public static function getPluralModelLabel(): string
    {
        return __('Permission.PluralModelLabel');
    }

    public static function getModelLabel(): string
    {
        return __('Permission.ModelLabel');
    }

    // Group Name
    // protected static ?string $navigationGroup = 'General Settings';
    public static function getNavigationGroup(): string
    {
        return __('Permission.group');
    }





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->unique()
                        ->required()
                        ->label(__('Permission.name')),
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
                    ->label(__('Permission.name')),
                TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->label(__('Permission.created_at')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePermissions::route('/'),
        ];
    }
}
