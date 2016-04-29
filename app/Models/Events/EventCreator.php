<?php
namespace EQM\Models\Events;

use EQM\Core\Database\CanMakeDatabaseTransactions;
use EQM\Core\Database\TransactionManager;
use EQM\Models\Addresses\AddressRepository;
use EQM\Models\Users\User;

class EventCreator
{
    use CanMakeDatabaseTransactions;

    /**
     * @var \EQM\Models\Addresses\AddressRepository
     */
    private $addresses;

    /**
     * @var \EQM\Models\Events\EventRepository
     */
    private $events;

    public function __construct(
        TransactionManager $transactionManager,
        AddressRepository $addresses,
        EventRepository $events
    ) {
        $this->transactionManager = $transactionManager;
        $this->addresses = $addresses;
        $this->events = $events;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Events\Event
     */
    public function create(User $user, array $values)
    {
        return $this->transaction(function() use ($user, $values) {
            $address = $this->addresses->create($values);
            $event = $this->events->createFullSizedEvent($user, $address, $values);

            return $event;
        });
    }
}
