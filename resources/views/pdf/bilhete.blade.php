<!DOCTYPE html>
<html>

<head>
  <title>Recibo</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    body,
    table,
    td,
    a {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    table,
    td {
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }
    img {
      -ms-interpolation-mode: bicubic;
    }
    
    /* RESET STYLES */
    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
    }
    table {
      border-collapse: collapse !important;
    }
    body {
      height: 100% !important;
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;
    }
    
    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }
    
    /* MEDIA QUERIES */
    @media screen and (max-width: 480px) {
      .mobile-hide {
        display: none !important;
      }
      .mobile-center {
        text-align: center !important;
      }
      .align-center {
        max-width: initial !important;
      }
      h1 {
        display: inline-block;
        margin-right: auto !important;
        margin-left: auto !important;
      }
    }
    @media screen and (min-width: 480px) {
      .mw-50 {
        max-width: 50%;
      }
    }
    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] {
      margin: 0 !important;
    }
    :root {
      --purple: #5a3aa5;
      --pink: #1b6fb9;
      --blue: #2cbaef;
      --green: #23c467;
    }
  </style>
  </head>

  <body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <td align="left" style="padding-top: 20px;">
                      <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                            Recibo nº{{$recibo->id}}
                          </td>
                        </tr>
                        @endforeach
                        <tr>
                          <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                            Total Iva
                          </td>
                          <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 5px 10px;">
                          {{$recibo->iva}}
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" style="padding-top: 20px;">
                      <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 2px solid #eeeeee; border-bottom: 2px solid #eeeeee;">
                            TOTAL
                          </td>
                          <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 2px solid #eeeeee; border-bottom: 2px solid #eeeeee;">
                          {{$recibo->preco_total_com_iva}}
                          </td>
                        </tr>
                      </table>
  </body>
</html>