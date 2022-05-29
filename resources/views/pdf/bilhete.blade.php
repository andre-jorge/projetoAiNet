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

  @foreach($bilhetes as $bilhete)
  <div style="border: 2px solid black">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <td align="left" style="padding-top: 20px;">
                      <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td width="40%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                            Bilhete nº{{$bilhete->id}}
                          </td>
                          <td width="60%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                          Cliente: {{$bilhete->Recibo->nome_cliente}}
                          </td>
                        </tr>
                        <tr>
                          <td width="45%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                            Filme: {{$bilhete->Sessao->Filmes->titulo}}
                          </td>
                          <td width="55%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                          Sala: {{$bilhete->Sessao->Salas->nome}}
                          </td>
                        </tr>
                        <tr>
                          <td width="45%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                            ___Data___|     Hora <br>
                            {{$bilhete->Sessao->data}} | {{$bilhete->Sessao->horario_inicio}}
                          </td>
                          <td width="55%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                          Fila | Posição <br>
                          {{$bilhete->Lugar->fila}} - {{$bilhete->Lugar->posicao}}
                          </td>
                        </tr>
                        <tr>
                          <td width="100%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 15px 10px 5px 10px;">
                            Estado: {{$bilhete->estado}}
                          </td>
                        </tr>
                      </table>
                    </td>
                    </table>  
                    </div>                    
                      @endforeach
                      </div>
  </body>
</html>