<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailService
{
    private const FROM_EMAIL = "test@gmail.com";

    public function __construct(protected MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    
    /**
     * send mail
     *
     * @params $dataArr
     *
     * @return mixed
     */
    public function sendMail($dataArr)
    {
        $email = (new Email())
            ->from(self::FROM_EMAIL)
            ->to($dataArr['to'])
            ->replyTo(self::FROM_EMAIL)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($dataArr['subject'])
            ->text($dataArr['body']);
            //->html($dataArr['body']);
        
        try {
            $response = $this->mailer->send($email);
        } catch(TransportExceptionInterface $e) {
            $response = $e->getMessage();
        } catch(\Exception $e) {
            $response = $e->getMessage();
        }

        return $response;
    }
}
