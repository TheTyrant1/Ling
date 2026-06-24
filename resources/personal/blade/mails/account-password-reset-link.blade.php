<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Reset your password</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light dark">
  <meta name="supported-color-schemes" content="light dark">
  <style type="text/css">
    @font-face {
        font-family: "Roboto";
        src: url("{{ asset('resources/web/fonts/roboto/Roboto-VariableFont_wdth,wght.woff2') }}") format("woff2");
        font-weight: 100 900;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: "Inter";
        src: url("{{ asset('resources/web/fonts/inter/Inter-VariableFont_opsz,wght.woff2') }}") format("woff2");
        font-weight: 100 900;
        font-style: normal;
        font-display: swap;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        padding: 0;
        width: 100% !important;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        background-color: #f4f4f5;
        font-family: "Roboto", "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    table, td { border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }

    img { border: 0; height: auto; outline: none; text-decoration: none; display: block; }

    h1, p { margin: 0; padding: 0; }

    @media (prefers-color-scheme: dark) {
        body   { background-color: #09090b !important; }
        .bg    { background-color: #09090b !important; }
        .card  { background-color: #18181b !important; }
        .title { color: #ffffff !important; }
        .body  { color: #d4d4d8 !important; }
        .body-muted { color: #71717a !important; }
        .btn   { background-color: #ffffff !important; color: #09090b !important; }
        .divider-line { border-top-color: #27272a !important; }
        .footer { color: #52525b !important; }
        .footer-strong { color: #a1a1aa !important; }
    }

    @media only screen and (max-width: 620px) {
        .card-td  { padding: 24px 20px !important; }
        .outer-td { padding: 32px 16px !important; }
    }
  </style>
</head>

<body>
  <table class="bg" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
         style="background-color:#f4f4f5;">
    <tr>
      <td class="outer-td" align="center"
          style="padding: 48px 24px;">

        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="max-width:600px; width:100%;">

          <tr>
            <td align="center" style="padding-bottom: 28px;">
              <img src="{{ asset('assets/personal/images/mail/logo.svg') }}"
                   alt="Ling" width="56"
                   style="width:56px; height:auto; display:inline-block;" />
            </td>
          </tr>

          <tr>
            <td style="padding:0;">
              <div class="card"
                   style="background-color:#ffffff;
                          border-radius:16px;
                          overflow:hidden;">

                <div class="card-td"
                     style="padding: 40px 40px 36px 40px;">

                    <h1 class="title"
                        style="font-family:'Roboto','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                               font-size:22px; font-weight:700; line-height:1.3;
                               color:#09090b; text-align:center;
                               margin:0 0 28px 0; padding:0;">
                      Reset your password
                    </h1>

                    <p class="body"
                       style="font-family:'Roboto','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                              font-size:15px; line-height:1.65; color:#3f3f46;
                              margin:0 0 16px 0; padding:0;">
                      Hello {{ $user->name }},
                    </p>

                    <p class="body"
                       style="font-family:'Roboto','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                              font-size:15px; line-height:1.65; color:#3f3f46;
                              margin:0 0 32px 0; padding:0;">
                        You are receiving this email because a password reset request was made for your account.
                    </p>

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                      <tr>
                        <td align="center" style="padding-bottom: 32px;">
                          <a href="{{ $resetUrl }}" class="btn" target="_blank"
                             style="display:inline-block;
                                    background-color:#09090b;
                                    color:#ffffff;
                                    font-family:'Roboto','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                    font-size:14px; font-weight:700; line-height:1.2;
                                    text-decoration:none;
                                    padding:13px 36px;
                                    border-radius:100px;">
                            Reset password
                          </a>
                        </td>
                      </tr>
                    </table>

                    <p class="body"
                       style="font-family:'Roboto','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                              font-size:14px; line-height:1.65; color:#71717a;
                              margin:0 0 16px 0; padding:0;">
                      This password reset link will expire in {{ $expireMinutes }} minutes.
                    </p>

                    <p class="body body-muted"
                       style="font-family:'Roboto','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                              font-size:14px; line-height:1.65; color:#71717a;
                              margin:0 0 28px 0; padding:0;">
                      If you did not request a password reset, no further action is required.
                    </p>

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                      <tr>
                        <td class="divider-line"
                            style="border-top:1px solid #e4e4e7; font-size:0; line-height:0;
                                   padding-bottom:24px;">&nbsp;</td>
                      </tr>
                    </table>

                    <p class="footer"
                       style="font-family:'Roboto','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                              font-size:13px; line-height:1.5; color:#a1a1aa;
                              text-align:left; margin:0; padding:0;">
                      Best regards,<br />
                      <strong class="footer-strong" style="color:#71717a; font-weight:600;">Ling</strong>
                    </p>

                </div>
              </div>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
