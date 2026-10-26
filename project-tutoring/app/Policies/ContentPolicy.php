<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;

class ContentPolicy
{
    /**
     * Materi boleh diubah oleh Admin atau Guru pemilik course tempat materi itu berada.
     */
    public function update(User $user, Content $content): bool
    {
        return $user->can('update', $content->course);
    }

    public function delete(User $user, Content $content): bool
    {
        return $this->update($user, $content);
    }
}
