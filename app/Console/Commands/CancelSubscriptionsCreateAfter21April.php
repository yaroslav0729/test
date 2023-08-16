<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancelSubscriptionsCreateAfter21April extends Command
{
    protected $signature = 'cancel:subscriptions-create-after-date';

    protected $description = 'Cancel subscriptions create after 2023-04-13 8:30 PM';

    public function handle(StripeService $stripeService): int
    {
        $endCreatedTimeStamp = Carbon::parse('2023-04-13 8:30 PM')->timestamp;

        $subscriptions = $stripeService->getAllSubscriptionAfterDate($endCreatedTimeStamp);

        foreach ($subscriptions->autoPagingIterator() as $subscription) {
            if ($subscription->items->data[0]->plan->nickname === 'Daily Subscription Plan') {
                if (!$subscription->isDeleted()) {
                    $retrieved = $stripeService->getSubscriptionById($subscription->id);
                    try {
                        Log::info('id', [$retrieved->id]);
                        $stripeService->cancelSubscriptionById($retrieved->id);
                    } catch (\Exception $e) {
                        Log::info('sss', [$retrieved]);
                        Log::info('message', [$e->getMessage()]);
                    }
                }
            }
        }

        return 0;
    }
}
