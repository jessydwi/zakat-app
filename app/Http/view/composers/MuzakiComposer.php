<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class MuzakiComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();

        if ($user) {
            $jumlahNotifikasiBelumDibaca = Notifikasi::where('user_id', $user->id)
                ->where('status_baca', false)
                ->count();
        } else {
            $jumlahNotifikasiBelumDibaca = 0;
        }

        $view->with('jumlahNotifikasiBelumDibaca', $jumlahNotifikasiBelumDibaca);
    }
}
