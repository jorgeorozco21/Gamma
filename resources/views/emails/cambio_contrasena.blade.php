<table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f6f8; padding: 40px 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <tr>
        <td align="center">
            <table width="100%" maxWidth="600px" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                <tr>
                    <td style="background-color: #7B1FA3; padding: 40px 30px; text-align: center;">
                        <div style="color: #e9d5ff; font-size: 14px; font-weight: bold; margin-bottom: 5px; letter-spacing: 2px;">LABORES</div>
                        <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600; letter-spacing: 0.5px;">
                            Contraseña Actualizada
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px 30px;">
                        <p style="margin: 0 0 20px 0; font-size: 18px; color: #111827; font-weight: 500;">
                            Hola, <span style="color: #7B1FA3;">{{ $usuario }}</span>
                        </p>       
                        <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.6; color: #4b5563;">
                            Te informamos que la contraseña de tu cuenta Labores ha sido cambiada correctamente. A continuación, encontrarás tus nuevos datos de acceso:
                        </p>
                        <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; margin-bottom: 30px;">
                            <tr>
                                <td style="padding: 20px;">
                                    <p style="margin: 0 0 10px 0; font-size: 15px; color: #374151;">
                                        <strong>Usuario:</strong> 
                                        <span style="font-family: monospace; font-size: 16px; background-color: #f1f5f9; padding: 2px 6px; border-radius: 4px;">{{ $usuario }}</span>
                                    </p>
                                    <p style="margin: 0; font-size: 15px; color: #374151;">
                                        <strong>Contraseña nueva:</strong> 
                                        <span style="font-family: monospace; font-size: 16px; background-color: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #7B1FA3; font-weight: bold;">{{ $contrasena }}</span>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 30px;">
                            <tr>
                                <td align="center">
                                    <a href="#" target="_blank" style="display: inline-block; background-color: #7B1FA3; color: #ffffff; padding: 14px 30px; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 6px; box-shadow: 0 2px 5px rgba(123, 31, 163, 0.3);">
                                        Ir a mi Cuenta
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" cellspacing="0" cellpadding="0" style="border-top: 1px solid #e5e7eb; padding-top: 20px;">
                            <tr>
                                <td>
                                    <p style="margin: 0 0 10px 0; font-size: 14px; line-height: 1.5; color: #6b7280; font-style: italic; text-align: center;">
                                        * Por seguridad, te recomendamos cambiar esta contraseña inmediatamente al iniciar sesión.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                        <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                            Este es un correo automático, por favor no respondas a este mensaje.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>