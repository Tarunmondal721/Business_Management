<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>

<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial, Helvetica, sans-serif;">

    <!-- Header -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#667eea,#764ba2); padding:40px 20px; text-align:center;">
        <tr>
            <td>
                <h1 style="color:white; font-size:26px; margin:0; font-weight:700;">Admin Panel</h1>
                <p style="color:#e2e8f0; margin:8px 0 0; font-size:15px;">Secure Access • Protected System</p>
            </td>
        </tr>
    </table>

    <!-- Main Content Wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 15px;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width:600px; background:white; border-radius:16px; overflow:hidden; box-shadow:0 8px 25px rgba(0,0,0,0.12);">

                    <!-- Gradient Banner -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#667eea,#764ba2); padding:40px 20px; text-align:center;">
                            <div style="width:80px; height:80px; background:rgba(255,255,255,0.25); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                                <span style="font-size:38px; color:white;">🔐</span>
                            </div>
                            <h2 style="color:white; margin:0; font-size:24px; font-weight:700;">Password Reset Request</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 30px 50px; text-align:center;">
                            <h3 style="color:#2d3748; font-size:20px; margin-top:0;">Hello Admin,</h3>

                            <p style="color:#4a5568; font-size:15px; line-height:1.6; margin:0 0 30px;">
                                We received a request to reset the password for your admin account.
                                Click the button below to create a new password.
                            </p>

                            <!-- Reset Button -->
                            <a href="{{ url('admin/reset-password/' . $token) }}"
                               style="display:inline-block; background:linear-gradient(135deg,#667eea,#764ba2); color:white; padding:14px 38px; font-size:16px; border-radius:40px; text-decoration:none; font-weight:600; box-shadow:0 5px 20px rgba(102,126,234,0.4);">
                                Reset Password Now
                            </a>

                            <p style="color:#718096; font-size:13px; margin-top:30px;">
                                This link will expire in <strong>10 minutes</strong> for security reasons.
                            </p>

                            <hr style="border:none; border-top:1px solid #e2e8f0; margin:40px 0;">

                            <p style="color:#a0aec0; font-size:13px; margin:0;">
                                If you didn’t request a password reset, simply ignore this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#1a202c; padding:25px 30px; text-align:center;">
                            <p style="color:#718096; font-size:12px; margin:0;">
                                © {{ date('Y') }} Admin Panel — All Rights Reserved<br>
                                This is an automated message. Do not reply.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
