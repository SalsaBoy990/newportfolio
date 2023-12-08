<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer extends Trongate
{

    private const INPUT_FIELDS = ['name', 'email', 'subject', 'message'];

    private string $name;
    private string $email;
    private string $subject;
    private string $message;
	private string $template_to_use = 'clean';

    private PHPMailer $mailer;


    public function __construct($module_name = null)
    {
        parent::__construct($module_name);

        $this->name = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';

        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = true;
        $this->mailer->Host = "127.0.0.1"; // SMTP server address for MailCatcher
//        $this->mailer->Mailer = "mail";
//        $this->mailer->SMTPAuth = true; // turn on SMTP authentication
//        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 1025; // 587
//        $this->mailer->Username = '';
//        $this->mailer->Password = '';

        $this->module('a-validate');
    }


    function contact()
    {

        $data = $this->_get_data_from_post();
        $data['form_location'] = str_replace('/contact', '/submit', current_url());
        $data['view_file'] = 'contact';

        $this->template($this->template_to_use, $data);
    }

    function thanks() {
        $data['view_file'] = 'thanks';

        $this->template($this->template_to_use, $data);
    }


    function submit()
    {

        $submit = post('submit');

        // post requests needs validation
        if (mb_strtolower($submit) == 'submit') {

            // rules
            $this->validation_helper->set_rules('name', 'Your name', 'required|text|min_length[3]');
            $this->validation_helper->set_rules('email', 'Your email', 'required|valid_email');
            $this->validation_helper->set_rules('subject', 'Subject', 'required|text|min_length[5]|max_length[150]');
            $this->validation_helper->set_rules('message', 'Message', 'required|text|min_length[20]|max_length[3000]');


            // run the validation tests
            $result = $this->validation_helper->run();

            if ($result === true) {

                $submitted = $this->_get_data_from_post();

                // send email
                try {

                    $this->mailer->setFrom($submitted['email'], $submitted['name']);
                    $this->mailer->addAddress('gulandras90@gmail.com', 'András');

                    $this->mailer->Subject = $submitted['subject'];
                    $this->mailer->Body = $submitted['message'];

                    $this->mailer->send();

                    $message = 'Your message successfully sent!';
                    set_flashdata($message);

                } catch (Exception $e) {
                    print_r($e);
                    die;
                }

                unset($_POST);
                header('Location: ' . BASE_URL . 'mailer/thanks');
            }

            $this->contact();
        }

    }

    private function _get_data_from_post()
    {
        return $this->validate->_get_data_from_post(self::INPUT_FIELDS);
    }

    private function _configure_phpmailer()
    {

    }

}
