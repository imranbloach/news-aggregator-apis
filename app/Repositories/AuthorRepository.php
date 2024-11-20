<?php
namespace App\Repositories;

use App\Models\Author;

class AuthorRepository
{
    public function getAll()
    {
        return Author::all();
    }

    public function create($data)
    {
        return Author::create($data);
    }

    public function findById($id)
    {
        return Author::findOrFail($id);
    }

    public function update($id, $data)
    {
        $author = $this->findById($id);
        $author->update($data);
        return $author;
    }

    public function delete($id)
    {
        $author = $this->findById($id);
        $author->delete();
    }
}
