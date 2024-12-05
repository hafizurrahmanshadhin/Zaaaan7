<?php

namespace App\Services\Backend\Setting;

use Exception;
use Illuminate\Support\Facades\File;

class MailService
{
    public function updateMailConfig($data)
    {
        try {
            // Fetch the .env file content
            $envContent = File::get(base_path('.env'));
            $lineBreak = "\n";

            // Update the mail settings
            $envContent = preg_replace([
                '/MAIL_MAILER=(.*)\s/',
                '/MAIL_HOST=(.*)\s/',
                '/MAIL_PORT=(.*)\s/',
                '/MAIL_USERNAME=(.*)\s/',
                '/MAIL_PASSWORD=(.*)\s/',
                '/MAIL_ENCRYPTION=(.*)\s/',
                '/MAIL_FROM_ADDRESS=(.*)\s/',
            ], [
                'MAIL_MAILER=' . $data['mail_mailer'] . $lineBreak,
                'MAIL_HOST=' . $data['mail_host'] . $lineBreak,
                'MAIL_PORT=' . $data['mail_port'] . $lineBreak,
                'MAIL_USERNAME=' . $data['mail_username'] . $lineBreak,
                'MAIL_PASSWORD=' . $data['mail_password'] . $lineBreak,
                'MAIL_ENCRYPTION=' . $data['mail_encryption'] . $lineBreak,
                'MAIL_FROM_ADDRESS=' . '"' . $data['mail_from_address'] . '"' . $lineBreak,
            ], $envContent);

            // Save the changes to the .env file
            if ($envContent !== null) {
                File::put(base_path('.env'), $envContent);
            }

            return true;
        } catch (Exception $e) {
            // Log error or handle exception if needed
            return false;
        }
    }
}
