<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AccountReceivable;
use App\Notifications\PaymentDueReminder;
use Carbon\Carbon;

class CheckPaymentDueDates extends Command
{
    protected $signature = 'check:payment-dues';
    protected $description = 'Check and notify customers about upcoming payment dues';

    public function handle()
    {
        $accountReceivables = AccountReceivable::where('status', 'ongoing')->get();

        foreach ($accountReceivables as $ar) {
            $nextDueDate = $ar->getNextPaymentDueDate();
            
            if ($nextDueDate && $nextDueDate->diffInDays(now()) <= 3) {
                $ar->customer->user->notify(new PaymentDueReminder($ar, $nextDueDate));
            }
        }
    }
} 