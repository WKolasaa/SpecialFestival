<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Repositories\UserTicketRepository;
use Dompdf\Exception;
use Resend;

class EmailService
{
    public function sendResetTokenEmail($userEmail, $token)
    {
        $resend = Resend::client('re_DF4R1gUB_CFNiNU9FrxGhNdDUCFxaK6NN');

        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => '695344@student.inholland.nl',
            'subject' => 'Token reset',
            'html' => '
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html dir="ltr" lang="en">
                
                  <head>
                    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
                  </head>
                  <div style="display:none;overflow:hidden;line-height:1px;opacity:0;max-height:0;max-width:0">Haarlem Festival reset your password<div></div>
                  </div>
                
                  <body style="background-color:#f6f9fc;padding:10px 0">
                    <table align="center" width="100%" border="0" cellPadding="0" cellSpacing="0" role="presentation" style="max-width:37.5em;background-color:#ffffff;border:1px solid #f0f0f0;padding:45px">
                      <tbody>
                        <tr style="width:100%">
                          <td>
                            <table align="center" width="100%" border="0" cellPadding="0" cellSpacing="0" role="presentation">
                              <tbody>
                                <tr>
                                  <td>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:&#x27;Open Sans&#x27;, &#x27;HelveticaNeue-Light&#x27;, &#x27;Helvetica Neue Light&#x27;, &#x27;Helvetica Neue&#x27;, Helvetica, Arial, &#x27;Lucida Grande&#x27;, sans-serif;font-weight:300;color:#404040">Hi <!-- -->'.$userEmail.'<!-- -->,</p>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:&#x27;Open Sans&#x27;, &#x27;HelveticaNeue-Light&#x27;, &#x27;Helvetica Neue Light&#x27;, &#x27;Helvetica Neue&#x27;, Helvetica, Arial, &#x27;Lucida Grande&#x27;, sans-serif;font-weight:300;color:#404040">Someone recently requested a password change for your Haarlem Festival account. If this was you, you can set a new password here:</p><a href="http://localhost/changepassword?email=' . $userEmail . '&token=' . $token . '" style="background-color:#007ee6;border-radius:4px;color:#fff;font-family:&#x27;Open Sans&#x27;, &#x27;Helvetica Neue&#x27;, Arial;font-size:15px;text-decoration:none;text-align:center;display:inline-block;width:210px;padding:14px 7px 14px 7px;line-height:100%;max-width:100%" target="_blank"><span><!--[if mso]><i style="letter-spacing: 7px;mso-font-width:-100%;mso-text-raise:21" hidden>&nbsp;</i><![endif]--></span><span style="max-width:100%;display:inline-block;line-height:120%;mso-padding-alt:0px;mso-text-raise:10.5px">Reset password</span><span><!--[if mso]><i style="letter-spacing: 7px;mso-font-width:-100%" hidden>&nbsp;</i><![endif]--></span></a>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:&#x27;Open Sans&#x27;, &#x27;HelveticaNeue-Light&#x27;, &#x27;Helvetica Neue Light&#x27;, &#x27;Helvetica Neue&#x27;, Helvetica, Arial, &#x27;Lucida Grande&#x27;, sans-serif;font-weight:300;color:#404040">If you don&#x27;t want to change your password or didn&#x27;t request this, just ignore and delete this message.</p>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:&#x27;Open Sans&#x27;, &#x27;HelveticaNeue-Light&#x27;, &#x27;Helvetica Neue Light&#x27;, &#x27;Helvetica Neue&#x27;, Helvetica, Arial, &#x27;Lucida Grande&#x27;, sans-serif;font-weight:300;color:#404040">To keep your account secure, please don&#x27;t forward this email to anyone.</p>
                                    <p style="font-size:16px;line-height:26px;margin:16px 0;font-family:&#x27;Open Sans&#x27;, &#x27;HelveticaNeue-Light&#x27;, &#x27;Helvetica Neue Light&#x27;, &#x27;Helvetica Neue&#x27;, Helvetica, Arial, &#x27;Lucida Grande&#x27;, sans-serif;font-weight:300;color:#404040">Haarlem Festival team!</p>
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
            ',
        ]);
    }

    /**
     * @throws Exception
     */
    public function sendInvoice($pdfUrl): void
    {
        $resend = Resend::client('re_DF4R1gUB_CFNiNU9FrxGhNdDUCFxaK6NN');
        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => '695344@student.inholland.nl',
            'subject' => 'Invoice',
            'html' => '
            <h1>Hey, this is your invoice!</h1>
        ', 'attachments' => [
                [
                    'filename' => 'invoice.pdf',
                    'content' => $this->downloadPDF($pdfUrl)
                ]
            ],
        ]);
    }

    /**
     * @throws Exception
     */
    public function downloadPDF($pdfUrl): bool|string
    {
        // Initialize cURL to download the PDF
        $ch = curl_init($pdfUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Execute cURL request
        $pdfData = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Check for cURL errors
        if ($pdfData === false || $httpStatus != 200) {
            throw new Exception('Error: Unable to download PDF.');
        }
        curl_close($ch);

        return chunk_split(base64_encode($pdfData));
    }

    public function sendTickets()
    { //TODO: CAll this method in checkout
        try {
            $ticketRepository = new TicketRepository();
            $userTicketRepository = new UserTicketRepository();
            $pdfService = new PDFService();
            // session_start();
            $userID = $_SESSION['userId'];
            $userTickets = $userTicketRepository->getTicketByUserID($userID);
            $ticketsObjects = [];

            foreach ($userTickets as $ticket){
                if($ticket['paid'] == 1){
                    $ticketsObjects[] = $ticketRepository->getTicketById($ticket['ticket_id']);
                }
            }

            $pdfs = [];

            foreach ($ticketsObjects as $ticketsObject) {
                $pdf = $pdfService->generatePDF($ticketsObject);

                $pdfBase64 = base64_encode($pdf);
                $pdfs[] = [
                    'filename' => 'ticket_' . $ticketsObject->getTicketId() . '.pdf',
                    'content' => $pdfBase64
                ];
            }

            //var_dump($userTickets);

            $resend = Resend::client('re_DF4R1gUB_CFNiNU9FrxGhNdDUCFxaK6NN');

            $resend->emails->send([
                'from' => 'onboarding@resend.dev',
                'to' => '695344@student.inholland.nl',
                'subject' => 'Your Tickets and Invoice',
                'html' => '
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 0; padding: 0; min-width: 100%!important; }
                            .content { width: 100%; max-width: 600px; }
                            .header { padding: 40px 30px 20px 30px; }
                            .innerpadding { padding: 30px 30px 30px 30px; }
                            .borderbottom { border-bottom: 1px solid #f2eeed; }
                            .subhead { font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px; }
                            .h1, .h2, .bodycopy { color: #153643; font-family: sans-serif; }
                            .h1 { font-size: 33px; line-height: 38px; font-weight: bold; }
                            .h2 { padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold; }
                            .bodycopy { font-size: 16px; line-height: 22px; }
                            .button { text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px; }
                            .button a { color: #ffffff; text-decoration: none; }
                            .footer { padding: 20px 30px 15px 30px; }
                            .footercopy { font-family: sans-serif; font-size: 14px; color: #ffffff; }
                            .footer a { color: #ffffff; text-decoration: underline; }
            
                            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                                body[yahoo] .hide { display: none!important; }
                                body[yahoo] .buttonwrapper { background-color: transparent!important; }
                                body[yahoo] .button a { background-color: #e05443; padding: 15px 15px 13px!important; display: block!important; }
                            }
                        </style>
                    </head>
                    <body yahoo bgcolor="#f6f8f1">
                        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <!--[if (gte mso 9)|(IE)]>
                                <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                    <td>
                                <![endif]-->
                                <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff;">
                                    <tr>
                                        <td class="header" bgcolor="#c7d8a7">
                                            <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td height="70" style="padding: 0 20px 20px 0;">
                                                        <img class="fix" src="https://resend.dev/logo.png" width="70" height="70" border="0" alt="" />
                                                    </td>
                                                </tr>
                                            </table>
                                            <!--[if (gte mso 9)|(IE)]>
                                            <table width="425" align="left" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                <td>
                                            <![endif]-->
                                            <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 425px;">
                                                <tr>
                                                    <td height="70">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td class="subhead" style="padding: 0 0 0 3px;">
                                                                    TICKETS
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="h1" style="padding: 5px 0 0 0;">
                                                                    Hey, those are your tickets!
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!--[if (gte mso 9)|(IE)]>
                                                </td>
                                            </tr>
                                            </table>
                                            <![endif]-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="innerpadding borderbottom">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td class="h2">
                                                        Your Tickets:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bodycopy">
                                                        Here are your tickets attached with this email. Please find them below.
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="footer" bgcolor="#44525f">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" class="footercopy">
                                                        &reg; Haarlem Festival 2023<br/>
                                                        <a href="#" class="unsubscribe"><font color="#ffffff">Unsubscribe</font></a>
                                                        <span class="hide"> | </span>
                                                        <a href="#"><font color="#ffffff">More Info</font></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                </tr>
                                </table>
                                <![endif]-->
                            </td>
                        </tr>
                        </table>
                    </body>
                    </html>
                ',
                'attachments' => $pdfs,
            ]);

            header("/thankyoupage");
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }
}