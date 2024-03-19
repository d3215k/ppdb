<?php

namespace App\Filament\Resources\PendaftaranResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BuktiPersyaratanKhususRelationManager extends RelationManager
{
    protected static string $relationship = 'buktiPersyaratanKhusus';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('persyaratan_khusus_id')
                    ->options(function () {
                        $ids = $this->getOwnerRecord()->buktiPersyaratanKhusus->pluck('id');

                        return $this->getOwnerRecord()
                            ->jalur->persyaratanKhusus
                            ->whereNotIn('id', $ids)
                            ->pluck('nama', 'id');
                    })
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(512)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('persyaratanKhusus.nama'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('Lihat File')
                    ->button()
                    ->url(fn ($record): string => asset('storage/'.$record->file))
                    ->openUrlInNewTab(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->paginated(false);
    }
}
