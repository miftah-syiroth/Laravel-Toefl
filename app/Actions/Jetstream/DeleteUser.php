<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();

        // hapus semua kemungkinan roles dan permission yg dimiliki
        $user->removeRole('participant');
        $user->revokePermissionTo(['do exam', 'view status', 'registrasi kelas']);

        // hapus bukti pembayaran dan sertifikat di storage
        Storage::delete($user->receipt_of_payment); // hapus bukti pembayaran dari storage
        Storage::delete($user->certificate);

        $user->delete();
    }
}
