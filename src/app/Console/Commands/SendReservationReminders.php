<?php

namespace App\Console\Commands;

use App\Mail\ReservationReminderMail;
use App\Models\UserReservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReservationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'reminder:send-reservation';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '予約日前日の予約者にリマインドメールを送信';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $reservations = UserReservation:: where('reservation_date', $tomorrow)->get();

        foreach($reservations as $reservation){
            Mail::to($reservation->email)->send(new ReservationReminderMail($reservation));
        }
        $this->info("リマインド成功");
        return Command::SUCCESS;
    }
}
