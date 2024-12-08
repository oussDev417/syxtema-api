<?php

namespace App\Services;

use App\Models\Newsletter;

class NewsletterService
{
    public function getAll()
    {
        return Newsletter::all();
    }

    public function create(array $data)
    {
        return Newsletter::create($data);
    }

    public function update(Newsletter $newsletter, array $data)
    {
        $newsletter->update($data);
        return $newsletter;
    }

    public function delete(Newsletter $newsletter)
    {
        return $newsletter->delete();
    }
} 