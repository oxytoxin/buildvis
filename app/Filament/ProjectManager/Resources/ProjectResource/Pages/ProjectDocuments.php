<?php

namespace App\Filament\ProjectManager\Resources\ProjectResource\Pages;

use App\Filament\ProjectManager\Resources\ProjectResource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Storage;

class ProjectDocuments extends ManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'documents';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('file')->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        $project = $this->getRecord();

        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('created_at')->label('Upload Date')->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('upload')
                    ->form([
                        TextInput::make('name')->required(),
                        FileUpload::make('file')->required()->storeFiles(false),
                    ])
                    ->action(function ($data) {
                        $this->getRecord()->addMedia($data['file'])->setName($data['name'])->toMediaCollection('documents', 's3');
                        Notification::make()->title('Document uploaded')->success()->send();
                    }),
            ])
            ->actions([
                Action::make('download')
                    ->outlined()
                    ->button()
                    ->url(fn ($record) => $record->getUrl(), true)
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-on-square'),
                DeleteAction::make()
                    ->action(function (Media $record) {
                        Storage::delete($record->getPath());
                        $record->delete();
                        Notification::make()->title('Document deleted')->success()->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
