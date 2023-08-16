<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;

class CancelSubscriptionsCreateBefore21April extends Command
{
    protected $signature = 'cancel:subscriptions-create-before-date';

    protected $description = 'Cancel subscriptions create before 2023-04-13 8:30 PM';

    private const MAX_COUNT_ITERATION = 3000;

    public function handle(StripeService $stripeService): int
    {
        $endCreatedTimeStamp = Carbon::parse('2023-04-13 8:30 PM')->timestamp;

        Log::info(__CLASS__ . '_command started');

        $iteration = 0;
        $isException = false;

        do {
            try {
                $subscriptions = $stripeService->getAllSubscriptionBeforeDate($endCreatedTimeStamp);
                foreach ($subscriptions->autoPagingIterator($iteration) as $subscription) {
                    if ($subscription->items->data[0]->plan->nickname === 'Daily Subscription Plan') {
                        if (!$subscription->isDeleted()) {
                            Log::info(__CLASS__ . '_id = ', [$subscription->id]);
                            $retrieved = $stripeService->getSubscriptionById($subscription->id);
                            $stripeService->cancelSubscriptionById($retrieved->id);
                        }
                    }
                }
                $isException = false;
            } catch (ApiErrorException $exception) {
                Log::info(__CLASS__ . '_exception _id = ', [$exception->getMessage()]);
                $isException = true;
            }
            $iteration++;
            Log::info(__CLASS__ . '_iterations = ', [$iteration]);
            if ($iteration > self::MAX_COUNT_ITERATION) {
                break;
            }
        } while ($isException);

        Log::info(__CLASS__ . '_ended');

        return 0;
    }
}
