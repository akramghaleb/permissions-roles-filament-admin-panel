<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Table;
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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'الاعدادات';

    //protected static bool $shouldRegisterNavigation = false;

    protected static ?int $navigationSort = 1;


    protected static ?string $pluralModelLabel = 'المستخدمين';
    protected static ?string $modelLabel = 'مستخدم';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191)->label('الاسم'),
                Forms\Components\Toggle::make('is_admin')
                    ->required()->label('مستخدم رئيسي'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191)->label('الايميل'),
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
                    )->label('كلمة المرور'),
                CheckboxList::make('roles')
                    ->relationship('roles','name')
                    ->columns(2)
                    ->helperText('Only Choose One!')->label('الصلاحية')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم'),
                Tables\Columns\IconColumn::make('is_admin')
                    ->sortable()
                    ->searchable()
                    ->boolean()->label('مستخدم رئيسي'),
                TextColumn::make('roles.name')->sortable()->searchable()->label('الصلاحية'),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()->label('الايميل'),
                TextColumn::make('deleted_at')->dateTime('d-M-Y')->sortable()->searchable()->label('تاريخ الحذف'),
                TextColumn::make('created_at')->dateTime('d-M-Y')->sortable()->searchable()->label('تاريخ الانشاء'),
            ])
            ->filters([
                TrashedFilter::make(),
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
