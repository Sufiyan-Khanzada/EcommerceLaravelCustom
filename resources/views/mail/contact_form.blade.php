<!-- resources/views/emails/contact_form.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        /* Responsive design for email */
        @media only screen and (max-width: 600px) {
            p, ul li, ol li, a { font-size: 16px !important; line-height: 150% !important; }
            h1 { font-size: 30px !important; text-align: left; line-height: 120% !important; }
            h2 { font-size: 26px !important; text-align: left; line-height: 120% !important; }
            h3 { font-size: 20px !important; text-align: left; line-height: 120% !important; }
            .es-menu td a { font-size: 16px !important; }
            .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size: 16px !important; }
            .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size: 16px !important; }
            .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size: 12px !important; }
            .es-adapt-td { display: block !important; width: 100% !important; }
            .adapt-img { width: 100% !important; height: auto !important; }
            .es-m-p0 { padding: 0 !important; }
            .es-m-p20b { padding-bottom: 20px !important; }
            .es-mobile-hidden, .es-hidden { display: none !important; }
        }
        #outlook a { padding: 0; }
        .ExternalClass { width: 100%; }
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
        .es-button { mso-style-priority: 100 !important; text-decoration: none !important; }
        a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important; }
        .es-desk-hidden { display: none; float: left; overflow: hidden; width: 0; max-height: 0; line-height: 0; mso-hide: all; }
    </style>
</head>
<body>
    <div style="background-color:#F6F6F6;">
        <table width="100%" style="border-collapse: collapse; padding: 0; margin: 0; background-repeat: repeat; background-position: center top;">
            <tr>
                <td valign="top" style="padding: 0; margin: 0;">
                    <table align="center" style="width: 100%; border-collapse: collapse; background-color: #FFFFFF;">
                        <tr>
                            <td align="left" style="padding: 10px; margin: 0;">
                                <table width="100%" style="border-collapse: collapse;">
                                    <tr>
                                        <td align="center" style="padding: 0; margin: 0; font-size: 0;">
                                            <a href="https://www.firequick.com/" target="_blank" style="text-decoration: underline; color: #1376C8;">
                                                <img src="https://hjyjbx.stripocdn.email/content/guids/CABINET_6adf9eda672b807f147ae669e070aeca/images/59031597362584415.png" alt="Firequick" width="279" height="61" style="display: block; border: 0; outline: none; text-decoration: none;">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table align="center" style="width: 100%; border-collapse: collapse; background-color: #FF4000;">
                        <tr>
                            <td align="center" style="padding: 30px 20px; background-color: #FF4000;">
                                <table width="100%" style="border-collapse: collapse;">
                                    <tr>
                                        <td align="center" style="padding: 0; margin: 0;">
                                            <h2 style="color: #FFFFFF; font-family: Arial, Helvetica, sans-serif;"><strong>Contact form on Firequick</strong></h2>
                                            <p style="color: #FFFFFF; font-family: Arial, Helvetica, sans-serif;">Hi Admin,</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table align="center" style="width: 100%; border-collapse: collapse; background-color: #FFFFFF;">
                        <tr>
                            <td align="left" style="padding: 20px;">
                                <table width="100%" style="border-collapse: collapse;">
                                    <tr>
                                        <td align="left" style="padding: 0 0 10px 0;">
                                            <h3 style="font-family: Arial, Helvetica, sans-serif; color: #333333;">A customer has an enquiry for you</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" style="padding: 0 0 10px 0;">
                                            <p style="font-family: Arial, Helvetica, sans-serif; color: #333333;">Name: {{ $name }}</p>
                                            <p style="font-family: Arial, Helvetica, sans-serif; color: #333333;">Email: {{ $email }}</p>
                                            <p style="font-family: Arial, Helvetica, sans-serif; color: #333333;">Message: {{ $message }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table align="center" style="width: 100%; border-collapse: collapse; background-color: #FFFFFF;">
                        <tr>
                            <td align="left" style="padding: 20px;">
                                <table width="100%" style="border-collapse: collapse;">
                                    <tr>
                                        <td align="left" style="padding: 0 0 10px 0;">
                                            <p style="font-family: Arial, Helvetica, sans-serif; color: #333333;">Best regards,<br>Firequick Team</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table align="center" style="width: 100%; border-collapse: collapse; background-color: #FFFFFF;">
                        <tr>
                            <td align="left" style="padding: 20px;">
                                <table width="100%" style="border-collapse: collapse;">
                                    <tr>
                                        <td align="left" style="padding: 0 0 10px 0;">
                                            <p style="font-family: Arial, Helvetica, sans-serif; color: #333333;">&copy; 2024 Firequick. All rights reserved.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
