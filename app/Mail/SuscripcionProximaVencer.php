<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Empresa;
use App\Models\Suscripcion;

class SuscripcionProximaVencer extends Mailable
{
    use Queueable, SerializesModels;

    public $empresa;
    public $suscripcion;
    public $diasRestantes;
    public $tipoAlerta;

    /**
     * Create a new message instance.
     *
     * @param Empresa $empresa
     * @param Suscripcion $suscripcion
     * @param int $diasRestantes
     * @param string $tipoAlerta ('7dias', '3dias', '1dia', 'vencido')
     */
    public function __construct(Empresa $empresa, Suscripcion $suscripcion, int $diasRestantes, string $tipoAlerta)
    {
        $this->empresa = $empresa;
        $this->suscripcion = $suscripcion;
        $this->diasRestantes = $diasRestantes;
        $this->tipoAlerta = $tipoAlerta;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->tipoAlerta) {
            '7dias' => '⏰ Tu plan de ServiLocal vence en 7 días',
            '3dias' => '⚠️ ¡URGENTE! Tu plan vence en 3 días',
            '1dia' => '🚨 ¡ÚLTIMA OPORTUNIDAD! Tu plan vence mañana',
            'vencido' => '💔 Tu plan de ServiLocal ha vencido',
            default => 'Recordatorio de Suscripción - ServiLocal',
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.suscripcion-proxima-vencer',
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
