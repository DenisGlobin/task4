<?php

namespace App\Policies;

use App\Document;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function view(?User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can create documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (isset($user)) ? true : false;
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        if ($user->id === $document->user_id) {
            if ($document->status === 'draft') {
                // Allow the user to edit the document
                return true;
            } else {
                return Response::deny('You cannot edit this document because it has already been published.', 400);
            }
        } else {
            return Response::deny('You do not own this document.', 403);
        }
    }

    /**
     * Determine whether the user can publish the document.
     *
     * @param User $user
     * @param Document $document
     * @return Response
     */
    public function publish(User $user, Document $document)
    {
        return $user->id === $document->user_id
            ? true
            : Response::deny('You do not own this document.', 403);
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can restore the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function restore(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function forceDelete(User $user, Document $document)
    {
        //
    }
}
