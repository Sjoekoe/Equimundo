<?php
namespace EQM\Http\Controllers\Users;

use EQM\Core\Mailers\UserMailer;
use EQM\Events\InvitationWasSent;
use EQM\Models\Invites\FriendInvitesRepository;
use EQM\Models\Users\Settings\SettingsUpdater;
use EQM\Models\Users\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Input;

class SettingController extends Controller
{
    /**
     * @var \EQM\Core\Mailers\UserMailer
     */
    private $mailer;

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @var \EQM\Models\Invites\FriendInvitesRepository
     */
    private $invites;

    public function __construct(UserMailer $mailer, UserRepository $users, FriendInvitesRepository $invites)
    {
        $this->mailer = $mailer;
        $this->users = $users;
        $this->invites = $invites;
    }

    public function index()
    {
        return view('users.settings.index');
    }

    public function update(Request $request)
    {
        $this->users->updateSettings(auth()->user(), $request->all());

        session()->put('success', 'Settings saved');

        return back();
    }

    public function invite()
    {
        return view('users.settings.invite');
    }

    public function postInvite(Request $request)
    {
        foreach ($request->get('emails') as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && ! $this->users->findByEmail($email)) {
                $this->invites->create(auth()->user(), $email);
                $this->mailer->sendInvitation(auth()->user(), $email);
                event(new InvitationWasSent());
            }
        }

        session()->put('success', trans('sessions.invitations_send'));

        return back();
    }
}
