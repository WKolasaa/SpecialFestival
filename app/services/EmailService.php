<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Repositories\UserTicketRepository;
use Dompdf\Exception;
use Resend;
use App\Models\Ticket;

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

    public function sendInvoice($pdfContent){
        $resend = Resend::client('re_DF4R1gUB_CFNiNU9FrxGhNdDUCFxaK6NN');

        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => '695344@student.inholland.nl',
            'subject' => 'Invoice',
            'html' => '
                <h1>Hey, this is your invoice!</h1>
            ',
            'attachments' => [
                [
                    'filename' => 'invoice.pdf',
                    'content' => '/PDF/invoice.pdf'
                ]
            ],
        ]);
    }

    public function sendTickets(){ //TODO: CAll this method in checkout
        try{
            $ticketRepository = new TicketRepository();
            $userTicketRepository = new UserTicketRepository();
            $pdfService = new PDFService();
            session_start();
            $userID = $_SESSION['userId'];
            $userTickets = $userTicketRepository->getTicketByUserID($userID); //TODO: change the hardcoded shit
            $ticketsObjects = [];

            foreach ($userTickets as $ticket){
                if($ticket['paid'] == 1){
                    $ticketsObjects[] = $ticketRepository->getTicketById($ticket['ticket_id']);
                }
            }

            $pdfs = [];


            foreach ($ticketsObjects as $ticketsObject) {
                $pdf = $pdfService->generatePDF($ticketsObject);
                // Encode the PDF content as base64
                $pdfBase64 = base64_encode($pdf);
                $pdfs[] = [
                    'filename' => 'ticket_' . $ticketsObject->getTicketId() . '.pdf',
                    'content' => $pdfBase64  // Use the base64 encoded content
                ];
            }

            $resend = Resend::client('re_DF4R1gUB_CFNiNU9FrxGhNdDUCFxaK6NN');

            $resend->emails->send([
                'from' => 'onboarding@resend.dev',
                'to' => '695344@student.inholland.nl',
                'subject' => 'Invoice',
                'html' => '
            <h1>Hey, this is your invoice!</h1>
        ',
                'attachments' => $pdfs,
            ]);
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }
}