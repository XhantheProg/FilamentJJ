<?php

namespace App\Observers;

use App\Models\Category;
use Filament\Notifications\Notification;
use App\Models\User;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $superAdmins = User::role('super_admin')->get();

        Notification::make()
            ->title('Nueva categoría creada: ' . $category->name)
            ->body('Se ha creado una nueva categoría en el sistema.')
            ->success()
            ->icon('heroicon-o-check-circle')
            ->sendToDatabase($superAdmins);
    }


    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
