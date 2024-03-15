<?php

namespace App\Events;

use App\Models\TahunPelajaran;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TahunPelajaranAktifChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tahun;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct($tahunId)
    {
        $this->tahun = TahunPelajaran::find($tahunId);
        $this->user = auth()->user();
    }

}
