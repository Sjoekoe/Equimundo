<?php
namespace EQM\Http\Controllers\Users;

use EQM\Core\Mailers\UserMailer;
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

    public function __construct(UserMailer $mailer, UserRepository $users)
    {
        $this->mailer = $mailer;
        $this->users = $users;
    }

    public function index()
    {
        return view('users.settings.index');
    }

    public function update(Request $request, SettingsUpdater $updater)
    {
        $updater->update(auth()->user(), $request);

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
                $this->mailer->sendInvitation(auth()->user(), $email);
            }
        }

        session()->put('success', trans('sessions.invitations_send'));

        return back();
    }
}
