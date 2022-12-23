<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait CanDeleteModel
{
    use LivewireAlert;

    public function deleteModel(Model $model, string $successMessage = 'Supprimé avec succès', string $failureMessage = 'Erreur lors de la suppression'): void
    {
        try {
            $model->delete();
            $this->alert('success', $successMessage);
        } catch (QueryException) {
            $this->alert('error', $failureMessage);
        }
    }

    public function deleteMedia(Media $media): void
    {
        $fileName = $media->filename;
        if ($media->delete()) {
            $this->refreshData();
            $this->alert('success', "Le fichier {$fileName} a été supprimé avec succès");
        } else {
            $this->alert('error', "Erreur lors de la suppression du fichier {$fileName}");
        }
    }

}
