<!-- THIS EMAIL WAS BUILT AND TESTED WITH LITMUS http://litmus.com -->
<!-- IT WAS RELEASED UNDER THE MIT LICENSE https://opensource.org/licenses/MIT -->
<!DOCTYPE html>
<html>

<head>
  <title>Your invoice for HealthPlanG purchase</title>
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

    <!-- HIDDEN PREHEADER TEXT -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Open Sans, Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
      Descrição
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;">
            <tr>
              <td align="center" height="6" style="background-image: linear-gradient(to right, #1b6fb9, #5a3aa5); background-color: #1b6fb9;" bgcolor="#1b6fb9"></td>
            </tr>
          </table>
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:800px;">
            <tr>
              <td align="center" valign="top" style="background-color: #ffffff; font-size:0; padding: 35px 35px 0;" bgcolor="#ffffff">
              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 0 15px 20px 15px; background-color: #ffffff;" bgcolor="#ffffff">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                  <tr>
                    <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                      <img src="http://healthplang.com/App_Themes/GHP/images/icon-check-mark.png" width="125" height="120" style="display: block; border: 0px;" /><br>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                      <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777; padding: 0 30px;">
                        DESCRIÇÃO
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" style="padding-top: 20px;">
                      <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                            Recibo #
                          </td>
                          <td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                          {{$recibo->id}}
                          </td>
                        </tr>
                        <tr>
                          <td width="45%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                            Data Recibo
                          </td>
                          <td width="55%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 15px 10px 5px 10px;">
                          {{$recibo->data}}
                          </td>
                        </tr>
                        <tr>
                          <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                            Nome Cliente
                          </td>
                          <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 5px 10px;">
                          {{$recibo->nome_cliente}}
                          </td>
                        </tr>
                        <tr>
                          <td width="75%" align="left" style="border-bottom: 2px solid #eeeeee; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px 20px 10px;">
                            Tipo Pagamento
                          </td>
                          <td width="25%" align="left" style="border-bottom: 2px solid #eeeeee; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 5px 10px 20px 10px;">
                          {{$recibo->tipo_pagamento}}
                          </td>
                        </tr>
                        <tr>
                          <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; line-height: 24px; padding: 20px 10px 5px 10px;">
                            <span style="font-style: italic;">Bilhete Cinema</span> (1)
                          </td>
                          <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 20px 10px 5px 10px;">
                          {{$recibo->preco_total_sem_iva}}
                          </td>
                        </tr>
                        <tr>
                          <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                            Iva
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
                    </td>
                  </tr>
                </table>
              </td>
            </tr>     
    </table>
  </body>
</html>