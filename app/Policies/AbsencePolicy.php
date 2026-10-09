<?php

use App\Models\{Absence, User};

class AbsencePolicy
{
    public function delete(User $actor, Absence $absence): bool
    {
        return $absence->start->isFuture()
            && ($actor->id === $absence->user_id
                || $actor->id === $absence->user->manager_id);
    }
}