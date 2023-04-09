<?php

namespace App\Mail;

use App\Enums\EEmailType;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;

class MailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $head;
    public $template;
    public $data;


    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct($email, $data)
    {
        if ($email->type == EEmailType::Registration || $email->type == EEmailType::Forget_Password  || $email->type == EEmailType::Verify) {
            $this->template = view(['template' => $email->template], ['user' => $data->user]) . "";
        } elseif ($email->type == EEmailType::New_invoice) {
            $this->template = view(['template' => $email->template], ['user' => $data->user, 'server' => $data->server]) . "";
        }
        elseif ($email->type == EEmailType::Paid_invoice || $email->type == EEmailType::Deploying_server) {
            $this->template = view(['template' => $email->template], ['user' => $data->user, 'order' => $data->order]) . "";
        }
        $this->title = $email->title;
        $this->head = $email->head;
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('info@wilivm.com', 'Wilivm'),
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.template',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
