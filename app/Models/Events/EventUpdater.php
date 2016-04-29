<?php
namespace EQM\Models\Events;

use EQM\Core\Database\CanMakeDatabaseTransactions;
use EQM\Core\Database\TransactionManager;
use EQM\Models\Addresses\AddressRepository;

class EventUpdater
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

    public function update(Event $event, array $values)
    {
        return $this->transaction(function() use ($event, $values) {
            $address = $this->addresses->update($event->address(), $values);
            $event = $this->events->update($event, $address, $values);
            
            return $event;
        });
    }
}
