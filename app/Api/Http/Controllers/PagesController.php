<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Http\Controller;
use EQM\Http\Requests\CompetitionRequest;
use EQM\Models\Competitions\EloquentCompetition;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class PagesController extends Controller
{
    /**
     * @var \Illuminate\Mail\Mailer
     */
    private $mail;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    public function competition(CompetitionRequest $request)
    {
        $competition = new EloquentCompetition([
            'email' => $request->get('email'),
        ]);

        $competition->save();

        $this->mail->queue('emails.competition', [
            'q1' => $request->get('q1'),
            'q2' => $request->get('q2'),
            'q3' => $request->get('q3'),
            'email' => $request->get('email'),
            'name' => $request->get('name'),
        ], function(Message $message) {
            $message->to('info@equimundo.com')->subject('Wedstrijd LGCT 2016');
        });

        return response('success', 200);
    }
}
