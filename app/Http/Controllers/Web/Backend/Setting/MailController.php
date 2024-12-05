<?php

namespace App\Http\Controllers\Web\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Backend\EmailSettingRequest;
use App\Services\Web\Backend\Setting\MailService;

class MailController extends Controller
{
    protected $mailService;


    /**
     * Constructor for the MailController.
     *
     * Injects the MailService to be used for updating mail configuration.
     *
     * @param  MailService  $mailService
     * @return void
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }


    /**
     * Display the email settings view.
     *
     * This method returns the view for configuring email settings, typically
     * used to display the form where users can enter their mail configuration.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.layouts.settings.mail');
    }



    /**
     * Handle the incoming request to update the email settings.
     *
     * This method validates the request using the `EmailSettingRequest` form request,
     * extracts the necessary email configuration data, and calls the `updateMailConfig`
     * method of the `MailService` to update the `.env` file.
     *
     * @param  EmailSettingRequest  $emailSettingRequest
     * @return \Illuminate\Http\RedirectResponse
     */
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
