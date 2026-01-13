<?php

namespace App\Filament\Resources\Ejercicios\Pages;

use App\Filament\Resources\Ejercicios\EjercicioResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEjercicio extends EditRecord
{
    protected static string $resource = EjercicioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
