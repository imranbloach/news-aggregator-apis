<?php

namespace App\Services;

use App\Models\Source;

class SourceService
{
    public function getAllSources()
    {
        return Source::all();
    }

    public function getSourceById($id)
    {
        return Source::findOrFail($id);
    }

    public function createSource(array $data)
    {
        return Source::create($data);
    }

    public function updateSource($id, array $data)
    {
        $source = Source::findOrFail($id);
        $source->update($data);
        return $source;
    }

    public function deleteSource($id)
    {
        $source = Source::findOrFail($id);
        $source->delete();
    }
}
