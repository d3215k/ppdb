<?php

namespace App\Filament\Resources;

use App\Enums\UserType;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Settings\SettingSekolah;
use App\Traits\EnsureOnlyAdminCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    use EnsureOnlyAdminCanAccess;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Akses Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options(UserType::class),
                Forms\Components\Toggle::make('aktif')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\ToggleColumn::make('aktif'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Impersonate::make(),
                Tables\Actions\Action::make('reset')
                    ->icon('heroicon-m-lock-open')
                    ->color('danger')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->modalHeading(
                        fn (User $record) => 'Reset Password ' . $record->name
                    )
                    ->modalDescription(fn (SettingSekolah $setting) => 'Setelah direset, password menjadi ' . $setting->nomor_hp_cs)
                    ->action(fn (User $record, SettingSekolah $setting) => $record->resetPassword($setting->nomor_hp_cs)),
                Tables\Actions\DeleteAction::make()
                        ->iconButton()
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
