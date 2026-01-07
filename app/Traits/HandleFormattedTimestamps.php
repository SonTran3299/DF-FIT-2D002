<?php

namespace App\Traits;

trait HandleFormattedTimestamps
{
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y | H:i:s') : '-';
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('d/m/Y | H:i:s') : '-';
    }

    public function getFormattedDeletedAtAttribute()
    {
        return $this->deleted_at ? $this->deleted_at->format('d/m/Y | H:i:s') : null;
    }

    public function initializeHandleFormattedTimestamps()
    {
        $this->append(['formatted_created_at', 'formatted_updated_at', 'formatted_deleted_at']);
    }
}
