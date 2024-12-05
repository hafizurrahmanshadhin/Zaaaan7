<?php

namespace App\Services\Web\Backend\Setting;

use Exception;
use Illuminate\Support\Facades\File;

class MailService
{
    /**
     * Update the email configuration in the .env file.
     *
     * This method takes an array of email configuration data, updates the relevant
     * mail settings in the `.env` file, and saves the changes. It handles the update
     * for settings like mailer, host, port, username, password, encryption, and
     * the 'from' address.
     *
     * @param  array  $data  An associative array containing the new email settings.
     * @return bool          Returns `true` if the .env file was successfully updated, `false` otherwise.
     */
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
