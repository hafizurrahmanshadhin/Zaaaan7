<?php

namespace App\Http\Controllers\Web\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Backend\EmailSettingRequest;
use App\Services\Backend\Setting\MailService;
use Illuminate\Http\Request;

class MailController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function index()
    {
        return view('backend.layouts.settings.mail');
    }

    public function store(EmailSettingRequest $emailSettingRequest)
    {

        $data = $emailSettingRequest->only([
            'mail_mailer', 
            'mail_host', 
            'mail_port', 
            'mail_username', 
            'mail_password', 
            'mail_encryption', 
            'mail_from_address'
        ]);

        $isUpdated = $this->mailService->updateMailConfig($data);

        if ($isUpdated) {
            return back()->with('t-success', 'Updated successfully');
        } else {
            return back()->with('t-error', 'Failed to update');
        }
    }
}
