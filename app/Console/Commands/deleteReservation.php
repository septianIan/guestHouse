<?php

namespace App\Console\Commands;

use App\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class deleteReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'menghapus/mengcencel tamu yang sudah lewat tanggal check in';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reser = Reservation::where([
            ['arrivaleDate', '<', Carbon::now()->format('Y-m-d')],
            ['status', '!=', ['checkIn', 'checkOut']]
        ])->first();
        $reser->delete();
    }
}
