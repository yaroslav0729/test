<?php
namespace App\Services;

use HubSpot\Factory as HSFactory;
use Illuminate\Support\Facades\Log;

class HubspotService
{
    private $accessToken;
    public $client;
    private $isEnabled;

    public function __construct()
    {
        $this->accessToken = config('hubspot.access_token');
        $this->client = HSFactory::createWithAccessToken($this->accessToken);
        $this->isEnabled = config('hubspot.enabled');
    }

    public function importDonations($donations)
    {
        if (!$this->isEnabled) {
            Log::info('Hubspot is not enabled');
            return;
        }

        $contactData = $this->prepareContactObject($donations[0]);
        $contact = $this->createContact($contactData);

        foreach ($donations as $donation) {
            $dealData = $this->prepareDealObject($donation);

            $deal = $this->createDeal($dealData);

            Log::info('Deal ' . $deal->getId());
            Log::info('Contact ' . $contact->getId());
            $this->associateContactToDeal($deal->getId(), $contact->getId());
        }
    }

    public function createContact($contactData)
    {
        $emailQuery = new \HubSpot\Client\Crm\Contacts\Model\PublicObjectSearchRequest();
        $emailQuery->setFilterGroups([
            (new \HubSpot\Client\Crm\Contacts\Model\FilterGroup())->setFilters([
                (new \HubSpot\Client\Crm\Contacts\Model\Filter())->setOperator('EQ')->setValue($contactData->getProperties()['email'])->setPropertyName('email'),
            ]),
        ]);

        $contacts = $this->client->crm()->contacts()->searchApi()->doSearch($emailQuery);

        if (!empty($contacts->getResults())) {
            return $contacts->getResults()[0];
        }

        $contact = $this->client->crm()->contacts()->basicApi()->create($contactData);
        return $contact;
    }

    public function createDeal($dealData)
    {
        $query = new \HubSpot\Client\Crm\Deals\Model\PublicObjectSearchRequest();
        $query->setFilterGroups([
            (new \HubSpot\Client\Crm\Deals\Model\FilterGroup())->setFilters([
                (new \HubSpot\Client\Crm\Deals\Model\Filter())->setOperator('EQ')->setValue($dealData->getProperties()['donation_i_d_'])->setPropertyName('donation_i_d_'),
            ]),
        ]);

        $deals = $this->client->crm()->deals()->searchApi()->doSearch($query);

        if (!empty($deals->getResults())) {
            return $deals->getResults()[0];
        }

        $deal = $this->client->crm()->deals()->basicApi()->create($dealData);
        return $deal;
    }

    public function associateContactToDeal($dealId, $contactId)
    {
        $association = new \HubSpot\Client\Crm\Associations\Model\BatchInputPublicAssociation();
        $association->setInputs([
            (new \HubSpot\Client\Crm\Associations\Model\PublicAssociation(['from' => $dealId, 'to' => $contactId, 'type' => 'deal_to_contact'])),
        ]);

        $this->client->crm()->associations()->batchApi()->create(
            'deals',
            'contacts',
            $association
        );
    }

    public function getDealPipeline($label)
    {
        $pipelines = $this->client->crm()->pipelines()->pipelinesApi()->getAll('deals')->getResults();
        foreach ($pipelines as $pipeline) {
            if ($pipeline->getLabel() === $label) {
                return $pipeline;
            }
        }

        return null;
    }

    public function prepareDealObject($donation)
    {
        $pipeline = $this->getDealPipeline('Website');
        $stage = $pipeline->getStages()[0];
        $object = [];
        $object['donation_i_d_'] = 'WEB' . $donation->id;
        $object['amount'] = $donation->value;
        $object['pipeline'] = $pipeline->getId();
        $object['dealstage'] = $stage->getId();
        $object['dealname'] = $donation->order->first_name . ' ' . $donation->order->last_name . ' ' . $donation->getDonationName();

        $object['donation_date'] = $donation->created_at->timezone('UTC')->startOfDay()->timestamp . '000';
        $object['time'] = $donation->created_at->format('H:i:s');
        $object['campaign_name'] = $donation->campaign ? $donation->campaign->name : 'No campaign';
        $object['program'] = $donation->campaign ? $donation->campaign->project_name : 'No program';
        $object['project_category'] = $donation->campaign ? $donation->campaign->program_name : 'No project category';
        $object['donation_type'] = $donation->campaign_category ? $donation->campaign_category->name : 'General Donation';
        $object['gift_aid_'] = $donation->order && $donation->order->gift_aid ? true : false;
        $object['remark'] = $donation->order ? $donation->order->notes : '';
        $object['order_id__web_only_'] = $donation->order ? $donation->order->order_id : '';
        $object['payment_method'] = $donation->order->pay_with;

        $dealObject = new \HubSpot\Client\Crm\Deals\Model\SimplePublicObjectInput();
        $dealObject->setProperties($object);

        return $dealObject;
    }

    public function getOwnerByEmail($email)
    {
        $owners = $this->client->crm()->owners()->ownersApi()->getPage($email)->getResults();
        foreach ($owners as $owner) {
            Log::info($owner->getEmail());
            if ($owner->getEmail() === $email) {
                return $owner->getId();
            }
        }

        return null;
    }

    public function prepareContactObject($donation)
    {
        $object = [];
        $object['firstname'] = $donation->order ? $donation->order->first_name : '';
        $object['lastname'] = $donation->order ? $donation->order->last_name : '';
        $object['email'] = $donation->email;
        $object['phone'] = '44' . ($donation->order ? $donation->order->phone : '');
        $object['zip'] = $donation->order ? $donation->order->post_code : '';
        $object['donor_address'] = $donation->order ? ($donation->order->address_1 . ' ' . $donation->order->address_2) : '';
        $object['city'] = $donation->order ? $donation->order->city : '';
        $object['country'] = $donation->order->country ? $donation->order->country : '';

        if ($donation->order->customer) {
            $object['send_email'] = $donation->order->do_email ? 'Y' : 'N';
            $object['send_text'] = $donation->order->do_sms ? 'Y' : 'N';
            $object['tele_calling'] = $donation->order->do_calls ? 'Y' : 'N';
            $object['send_mail'] = $donation->order->do_post ? 'Yes' : 'No';
        }

        $contactObject = new \HubSpot\Client\Crm\Contacts\Model\SimplePublicObjectInput();
        $contactObject->setProperties($object);

        return $contactObject;
    }
}
