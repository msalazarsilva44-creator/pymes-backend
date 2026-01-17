<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Suscripción</title>
    <style>
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header .logo {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .alert-box {
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .alert-7dias {
            background-color: #fef3c7;
            border: 2px solid #f59e0b;
            color: #92400e;
        }
        .alert-3dias {
            background-color: #fee2e2;
            border: 2px solid #ef4444;
            color: #7f1d1d;
        }
        .alert-1dia {
            background-color: #fecaca;
            border: 2px solid #dc2626;
            color: #7f1d1d;
        }
        .alert-vencido {
            background-color: #f3f4f6;
            border: 2px solid #6b7280;
            color: #1f2937;
        }
        .alert-box .emoji {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .alert-box .title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .alert-box .message {
            font-size: 16px;
            line-height: 1.5;
        }
        .plan-info {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .plan-info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .plan-info-row:last-child {
            border-bottom: none;
        }
        .plan-info-label {
            font-weight: bold;
            color: #6b7280;
        }
        .plan-info-value {
            color: #111827;
            font-weight: 600;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            opacity: 0.9;
        }
        .benefits {
            background-color: #ede9fe;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .benefits h3 {
            color: #5b21b6;
            margin-top: 0;
        }
        .benefits ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .benefits li {
            padding: 8px 0;
            padding-left: 30px;
            position: relative;
        }
        .benefits li:before {
            content: "✅";
            position: absolute;
            left: 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">ServiLocal</div>
            <h1>Recordatorio de Suscripción</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p style="font-size: 18px; color: #374151;">
                Hola <strong>{{ $empresa->nombre_comercial }}</strong>,
            </p>

            <!-- Alert Box según tipo -->
            @if($tipoAlerta === '7dias')
            <div class="alert-box alert-7dias">
                <div class="emoji">⏰</div>
                <div class="title">Tu plan vence en 7 días</div>
                <div class="message">
                    Tu suscripción al plan <strong>{{ $suscripcion->plan->nombre }}</strong> vencerá 
                    el <strong>{{ $suscripcion->fecha_fin->format('d/m/Y') }}</strong>.
                    Renueva ahora para mantener tus beneficios activos.
                </div>
            </div>
            @elseif($tipoAlerta === '3dias')
            <div class="alert-box alert-3dias">
                <div class="emoji">⚠️</div>
                <div class="title">¡URGENTE! Quedan solo 3 días</div>
                <div class="message">
                    Tu suscripción al plan <strong>{{ $suscripcion->plan->nombre }}</strong> vencerá 
                    el <strong>{{ $suscripcion->fecha_fin->format('d/m/Y') }}</strong>.
                    ¡No pierdas acceso a tus beneficios premium!
                </div>
            </div>
            @elseif($tipoAlerta === '1dia')
            <div class="alert-box alert-1dia">
                <div class="emoji">🚨</div>
                <div class="title">¡Última oportunidad! Vence mañana</div>
                <div class="message">
                    Tu suscripción al plan <strong>{{ $suscripcion->plan->nombre }}</strong> vencerá 
                    <strong>MAÑANA ({{ $suscripcion->fecha_fin->format('d/m/Y') }})</strong>.
                    Renueva AHORA para evitar la interrupción de tu servicio.
                </div>
            </div>
            @elseif($tipoAlerta === 'vencido')
            <div class="alert-box alert-vencido">
                <div class="emoji">💔</div>
                <div class="title">Tu plan ha vencido</div>
                <div class="message">
                    Tu suscripción al plan <strong>{{ $suscripcion->plan->nombre }}</strong> venció 
                    el <strong>{{ $suscripcion->fecha_fin->format('d/m/Y') }}</strong>.
                    Tu cuenta ha sido revertida al <strong>Plan Gratis</strong>.
                    Renueva ahora para recuperar tus beneficios.
                </div>
            </div>
            @endif

            <!-- Plan Info -->
            <div class="plan-info">
                <div class="plan-info-row">
                    <span class="plan-info-label">Plan:</span>
                    <span class="plan-info-value">{{ $suscripcion->plan->nombre }}</span>
                </div>
                <div class="plan-info-row">
                    <span class="plan-info-label">Precio:</span>
                    <span class="plan-info-value">${{ number_format($suscripcion->precio_pagado, 2) }}</span>
                </div>
                <div class="plan-info-row">
                    <span class="plan-info-label">Tipo de período:</span>
                    <span class="plan-info-value">{{ ucfirst($suscripcion->tipo_periodo) }}</span>
                </div>
                <div class="plan-info-row">
                    <span class="plan-info-label">Fecha de vencimiento:</span>
                    <span class="plan-info-value">{{ $suscripcion->fecha_fin->format('d/m/Y') }}</span>
                </div>
                @if($tipoAlerta !== 'vencido')
                <div class="plan-info-row">
                    <span class="plan-info-label">Días restantes:</span>
                    <span class="plan-info-value" style="color: #dc2626; font-size: 20px;">
                        {{ $diasRestantes }} {{ $diasRestantes === 1 ? 'día' : 'días' }}
                    </span>
                </div>
                @endif
            </div>

            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="{{ url('/empresa/solicitar-plan') }}" class="cta-button">
                    🔄 Renovar Mi Plan Ahora
                </a>
            </div>

            <!-- Benefits Reminder -->
            @if($tipoAlerta !== 'vencido')
            <div class="benefits">
                <h3>¿Qué perderás si no renuevas?</h3>
                <ul>
                    @if($suscripcion->plan->slug === 'premium')
                    <li>Posicionamiento prioritario en el marketplace</li>
                    <li>Destacado permanente en búsquedas</li>
                    <li>Panel de métricas avanzadas</li>
                    <li>Notificaciones de clientes interesados</li>
                    <li>Galería de fotos ilimitada</li>
                    <li>Soporte prioritario</li>
                    @elseif($suscripcion->plan->slug === 'basico')
                    <li>Mejor posicionamiento que el plan gratuito</li>
                    <li>Boost de 2 días incluido</li>
                    <li>Panel de métricas básicas</li>
                    <li>Notificaciones de visitas</li>
                    @endif
                </ul>
            </div>
            @else
            <div class="benefits">
                <h3>Recupera tus beneficios renovando ahora:</h3>
                <ul>
                    <li>Vuelve a aparecer en búsquedas prioritarias</li>
                    <li>Recupera acceso a métricas</li>
                    <li>Recibe notificaciones de clientes</li>
                    <li>Mantén tu posicionamiento en el marketplace</li>
                </ul>
            </div>
            @endif

            <p style="color: #6b7280; font-size: 14px; margin-top: 30px;">
                Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.
                Estamos aquí para ayudarte a mantener tu negocio visible en ServiLocal.
            </p>

            <p style="color: #111827; margin-top: 20px;">
                Saludos,<br>
                <strong>El equipo de ServiLocal</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} ServiLocal. Todos los derechos reservados.</p>
            <p>
                <a href="{{ url('/') }}">Visitar ServiLocal</a> | 
                <a href="{{ url('/dashboard/empresa') }}">Mi Dashboard</a> | 
                <a href="{{ url('/planes') }}">Ver Planes</a>
            </p>
            <p style="font-size: 12px; color: #9ca3af; margin-top: 15px;">
                Este es un correo automático. Por favor, no respondas a este mensaje.
            </p>
        </div>
    </div>
</body>
</html>
