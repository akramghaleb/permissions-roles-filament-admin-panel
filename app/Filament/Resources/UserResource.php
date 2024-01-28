<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use stdClass;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 61;

    // Main Title
    // protected static ?string $title = 'About';
    public static function getPluralModelLabel(): string
    {
        return __('User.PluralModelLabel');
    }

    public static function getModelLabel(): string
    {
        return __('User.ModelLabel');
    }

    // Group Name
    // protected static ?string $navigationGroup = 'General Settings';
    public static function getNavigationGroup(): string
    {
        return __('User.group');
    }

    // global search function
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->columns(2)->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191)
                    ->label(__('User.name')),
                Forms\Components\Toggle::make('is_admin')
                    ->required()
                    ->label(__('User.is_admin')),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191)
                    ->label(__('User.email')),
                TextInput::make('password')
                    ->password()
                    ->maxLength(191)
                    ->dehydrateStateUsing(static fn (null|string $state): null|string =>
                    filled($state) ? Hash::make($state): null,
                    )->required(static fn (Page $livewire): bool =>
                        $livewire instanceof CreateUser,
                    )->dehydrated(static fn (null|string $state): bool =>
                    filled($state),
                    )->label(static fn (Page $livewire): string =>
                    ($livewire instanceof EditUser) ? 'كلمة المرور جديدة' : 'كلمة المرور'
                    )->label(__('User.password')),
                CheckboxList::make('roles')
                    ->relationship('roles','name')
                    ->columns(2)
                    ->helperText('Only Choose One!')
                    ->label(__('User.roles'))
                ->required(),
                ]),
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
                Tables\Columns\TextColumn::make('name')
                ->label(__('User.name')),
                Tables\Columns\IconColumn::make('is_admin')
                    ->sortable()
                    ->boolean()
                    ->label(__('User.is_admin')),
                TextColumn::make('roles.name')->sortable()->searchable()->label(__('User.roles')),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label(__('User.email')),
                TextColumn::make('created_at')->dateTime('d-M-Y')->sortable()->searchable()
                    ->label(__('User.created_at')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class
        ];
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
