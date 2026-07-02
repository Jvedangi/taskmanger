<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;

class TaskNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $subjectLine;
    /**
     * Create a new message instance.
     */
    public function __construct(Task $task, $subjectLine)
    {
        $this->task = $task;
        $this->subjectLine = $subjectLine;
    }

    public function build(){
        return $this->subject($this->subjectLine)->cc(['vedangij@softcell.com'])->markdown('email.tasks.notification');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.tasks.notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
