<?php

namespace EQM\Console\Commands;

use EQM\Core\Mailers\UserMailer;
use EQM\Models\Users\UserRepository;
use Illuminate\Console\Command;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to people who still need to activate their account';

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @var \EQM\Core\Mailers\UserMailer
     */
    private $userMailer;

    public function __construct(UserRepository $users, UserMailer $userMailer)
    {
        parent::__construct();

        $this->users = $users;
        $this->userMailer = $userMailer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = $this->users->findUnactivatedUsers();

        foreach ($users as $user) {
            $this->userMailer->sendActivationReminder($user);
            $this->users->reminded($user);
        }

        $this->info('All reminders sent!');
    }
}
