<?php
include(BASE_PATH."/libs/Mailer/src/PHPMailer.php");
include(BASE_PATH."/libs/Mailer/src/SMTP.php");
include(BASE_PATH."/libs/Mailer/src/Exception.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../config/config.php';

class EmailService {
    private $mailer;
    
    public function __construct() {
        $this->mailer = new PHPMailer(true);
        
        // Configuración del servidor PHP. Ahora se obtienen las credenciales del archivo config
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->Host = EMAIL_HOST;
        $this->mailer->Port = EMAIL_PUERTO;
        $this->mailer->Username = EMAIL_MAIL;
        $this->mailer->Password = EMAIL_CLAVE;
        $this->mailer->SMTPSecure = EMAIL_CERTIFICADO;
        $this->mailer->CharSet = 'UTF-8';
    }

    public function enviarCorreo_RecuperarClave($email, $resetToken) {
        try {
            // Configuración del correo
            $this->mailer->setFrom('recursoshumanos.noresponder@gmail.com', 'Recursos Humanos');
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Restablece tu contraseña';

            // Obtener enlace para restablecer contraseña con el token
            $resetLink = "http://localhost/appweb_cs_2c_2024/GRUPO3/proyecto_rrhh/public/reset_password?token=" . $resetToken;

            // Preparar correo
            $emailTemplate = $this->getPasswordResetTemplate($resetLink);
            $this->mailer->Body = $emailTemplate;

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar el correo: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    public function enviarCorreo_NotificacionVacaciones($email, $nombre, $fechaInicio, $fechaFin, $aprobada, $motivo = '') {
        try {
            $this->mailer->setFrom('recursoshumanos.noresponder@gmail.com', 'Recursos Humanos');
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            
            if ($aprobada) {
                $this->mailer->Subject = '¡¡¡Solicitud de vacaciones APROBADA!!!';
                $template = $this->getVacacionesAprobadasTemplate($nombre, $fechaInicio, $fechaFin);
            } else {
                $this->mailer->Subject = 'Solicitud de vacaciones rechazada.';
                $template = $this->getVacacionesRechazadasTemplate($nombre, $fechaInicio, $fechaFin, $motivo);
            }
            
            $this->mailer->Body = $template;
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar el correo: " . $this->mailer->ErrorInfo);
            return false;
        }
    }
    
    private function getVacacionesAprobadasTemplate($nombre, $fechaInicio, $fechaFin) {
        $fechaInicioFormat = date('d/m/Y', strtotime($fechaInicio));
        $fechaFinFormat = date('d/m/Y', strtotime($fechaFin));
        
        return <<<HTML
        <!DOCTYPE html>
        <html>
        <body style="background-color:#f6f9fc;padding:10px 0">
            <table align="center" width="100%" style="max-width:37.5em;background-color:#ffffff;border:1px solid #f0f0f0;padding:45px">
                <tr>
                    <td>
                        <p style="font-family:Arial;color:#404040">
                            Hola {$nombre},
                        </p>
                        <p style="font-family:Arial;color:#404040">
                            ¡Tu solicitud de vacaciones fue aprobada!
                        </p>
                        <p style="font-family:Arial;color:#404040">
                            Período aprobado:
                            <br>
                            Desde: {$fechaInicioFormat}
                            <br>
                            Hasta: {$fechaFinFormat}
                        </p>
                        <p style="font-family:Arial;color:#404040">
                            ¡Que disfrutes tu descanso! :D
                            <br>
                            El equipo de Recursos Humanos.
                        </p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        HTML;
    }
    
    private function getVacacionesRechazadasTemplate($nombre, $fechaInicio, $fechaFin, $motivo) {
        $fechaInicioFormat = date('d/m/Y', strtotime($fechaInicio));
        $fechaFinFormat = date('d/m/Y', strtotime($fechaFin));
        
        $motivoHtml = $motivo ? "<p style='font-family:Arial;color:#404040'>Motivo: {$motivo}</p>" : "";
        
        return <<<HTML
        <!DOCTYPE html>
        <html>
        <body style="background-color:#f6f9fc;padding:10px 0">
            <table align="center" width="100%" style="max-width:37.5em;background-color:#ffffff;border:1px solid #f0f0f0;padding:45px">
                <tr>
                    <td>
                        <p style="font-family:Arial;color:#404040">
                            Hola {$nombre},
                        </p>
                        <p style="font-family:Arial;color:#404040">
                            Tu solicitud de vacaciones para el período:
                            <br>
                            Desde: {$fechaInicioFormat}
                            <br>
                            Hasta: {$fechaFinFormat}
                            <br>
                            Fue rechazada.
                        </p>
                        {$motivoHtml}
                        <p style="font-family:Arial;color:#404040">
                            Si tenés alguna duda no dudes en ponerte en contacto con nosotros.
                        </p>
                        <p style="font-family:Arial;color:#404040">
                            Saludos,
                            <br>
                            El equipo de Recursos Humanos
                        </p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        HTML;
    }

    // Plantilla HTML para el correo
    private function getPasswordResetTemplate($resetLink) {
        return <<<HTML
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
    <meta name="x-apple-disable-message-reformatting" />
</head>
<body style="background-color:#f6f9fc;padding:10px 0">
    <table align="center" width="100%" border="0" cellPadding="0" cellSpacing="0" role="presentation" style="max-width:37.5em;background-color:#ffffff;border:1px solid #f0f0f0;padding:45px">
        <tbody>
            <tr style="width:100%">
                <td>
                    <table align="center" width="100%" border="0" cellPadding="0" cellSpacing="0" role="presentation">
                        <tbody>
                            <tr>
                                <td>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:'Open Sans', 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;font-weight:300;color:#404040">
                                        Hola,
                                    </p>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:'Open Sans', 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;font-weight:300;color:#404040">
                                        Alguien acaba de solicitar un cambio de contraseña para tu cuenta. Si fuiste vos, podés establecer una nueva contraseña acá:
                                    </p>
                                    <a href="{$resetLink}" style="line-height:100%;text-decoration:none;display:block;max-width:100%;background-color:#007ee6;border-radius:4px;color:#fff;font-family:'Open Sans', 'Helvetica Neue', Arial;font-size:15px;text-align:center;width:210px;padding:14px 7px;margin:16px 0" target="_blank">
                                        Restablecer contraseña
                                    </a>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:'Open Sans', 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;font-weight:300;color:#404040">
                                        Si no querés cambiar tu contraseña o no solicitaste este cambio, simplemente ignora y elimina este mensaje.
                                    </p>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:'Open Sans', 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;font-weight:300;color:#404040">
                                        El enlace expira en 6 horas. Recordá que podés pedir uno nuevo en nuestra página por si lo necesitas.
                                    </p>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:'Open Sans', 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;font-weight:300;color:#404040">
                                        ¡Saludos! El equipo de Recursos Humanos.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
HTML;
    }
}