<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nama_peserta;
    public $email;
    public $nim;
    public $jurusan;
    public $skorReading;
    public $skorListening;
    public $totalSkor;
    public $kategori;
    public $rangeSkor;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct($nama_peserta, $email, $nim, $jurusan, $skorReading, $skorListening, $totalSkor, $kategori, $rangeSkor, $pdfPath)
    {
        $this->nama_peserta = $nama_peserta;
        $this->email = $email;
        $this->nim = $nim;
        $this->jurusan = $jurusan;
        $this->skorReading = $skorReading;
        $this->skorListening = $skorListening;
        $this->totalSkor = $totalSkor;
        $this->kategori = $kategori;
        $this->rangeSkor = $rangeSkor;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Here are the TOEIC simulation test results from TOEIC Simulation PNB!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'vendor.mail.result_email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->pdfPath)->as('TOEIC_Result.pdf')->withMime('application/pdf'),
        ];
    }
}
