<?php
/**
 * Created by PhpStorm.
 * User: Sebastien
 * Date: 25/02/2016
 * Time: 10:57
 */

class ContactHandler
{

    protected $request;
    protected $form;
    protected $mailer;

    /**
     * Initialize the handler with the form and the request
     * @param Form $form
     * @param Request $request
     * @param $mailer
     */
    public function __construct(Form $form, Request $request, $mailer)
    {
        $this->form = $form;
        $this->request = $request;
        $this->mailer = $mailer;
    }

    /**
     * Process form
     * @return boolean
     */
    public function process()
    {
        // Check the method
        if ('POST' == $this->request->getMethod())
        {
            // Bind value with form
            $this->form->bindRequest($this->request);

            $data = $this->form->getData();
            $this->onSuccess($data);

            return true;
        }
        return false;
    }

    /**
     * Send mail to notify the administrator that a contact is added
     * @param array $data
     */
    protected function onSuccess()
    {
        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('New contact added !')
            ->setFrom('crud-contact@no-reply.com')
            ->setTo('seb.joly@live.fr')
            ->setBody('New contact added !');

        $this->mailer->send($message);
    }
}