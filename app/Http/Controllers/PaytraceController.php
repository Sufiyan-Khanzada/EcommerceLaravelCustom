<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use App\Models\State;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\Cart;
use Exception;

class PaytraceController extends Controller
{
   // private $intigratorID = "9730a74dje8d";

   private $intigratorID = "9247917g833V";

   private $auth_server = "https://api.paytrace.com";
   // private $auth_server = "https://api.sandbox.paytrace.com";
   protected $token;
   protected $restricted_place;
   protected $cart_contents;
   protected $cart_needToUpdate;
   protected $user;
   protected $Shipping_rate;
   protected $california_tax;
   protected $others_contents;
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $this->token = Session::get('token');
         $this->restricted_place = Session::get('restricted_place');
         $this->cart_contents =  array_filter(Session::get('cart_contents'), function ($key) {
            return !in_array($key, ['total_items', 'cart_total', 'handling_fee']);
         }, ARRAY_FILTER_USE_KEY);
         $this->others_contents =  array_filter(Session::get('cart_contents'), function ($key) {
            return in_array($key, ['total_items', 'cart_total', 'handling_fee']);
         }, ARRAY_FILTER_USE_KEY);
         $this->cart_needToUpdate = Session::get('cart_needToUpdate');
         $this->Shipping_rate = Session::get('Shipping_rate');
         $this->california_tax = Session::get('california_tax');
         $this->user = auth()->guard('customer')->user();

         return $next($request);
      });
   }

   private  function gClient()
   {
      $client = new \GuzzleHttp\Client();
      //   dd($client);
      return $client;
   }

   public function api_token()
   {
      $client = $this->gClient();
      // dd($client);
      // // DRY
      // $auth_server = 'https://api.paytrace.com';
      // $auth_server =

      // // send a request to the authentication server
      // // note: normally, you'd store the username/password in a more secure fashion!
      $res = $client->post($this->auth_server."/oauth/token", [
         'form_params' => [
            // 'username' => 'Ammadkhan405@gmail.com', 
            // 'password' => 'ASDasd123',
            'username' => 'Joyce3965',
            // 'password' => 'Grouchy5766!',
            'password' => 'Dunoon@5766!!',
            'grant_type' => 'password',
         ]
      ]);

      // return $res->getStatusCode();
      // dd($res);
      if ($res->getStatusCode() == 200) {
         $body = $res->getBody();
         $json = json_decode($body->getContents());
         $token = $json->access_token;
         return $token;
      } else {

         return false;
      }
   }


   private  function validRequest($arr = false)
   {


      $data = [];
      //   dd($this->cart_contents);
      if (empty($this->cart_contents) || $this->restricted_place  == 'true' || $this->token == null) {
         $data['error'] = true;
         $data['api_error'] = 'unable to process request';
      }
      //   if ($this->cart_needToUpdate == true) {
      //       $data['cart_error'] = true;
      //       $data['cart'] = 'update';
      //       $data['api_error'] = 'Cart Need to Refresh.';
      //   }
      $ass = $this->api_token();
      //   dd($ass);
      // dd($ass);
      if ($this->api_token() == false || $this->api_token() == '') {
         $data['error'] = true;
         $data['api_error'] = 'The provided authorization grant is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.';
      }
      if (!empty($data) || $data != []) {
         if ($arr == true) {
            return $data;
            exit;
         } else {
            echo json_encode($data);
            exit;
         }
      }
   }

   public function sendPayment(Request $request)
   {
      // dd($this->cart_contents);
      $formData = $request->form_data;
      // dd($formData);
      // Parse the query string into an associative array
      parse_str($formData, $formDataArray);
      dd($formDataArray);
      // Dump the array to see the result
      // dd($formDataArray);
      //  dd($this->validRequest());
      $this->validRequest();
      $token = $this->api_token();
      $client = $this->gClient();

      //   print_r($token);
      //     print_r("1");
      //   die();
      if (!empty($token)) {

         $user_email = $this->user->email;
         $customer = $this->user;
         $shipping_cost = $this->Shipping_rate['cost'];
         $california_Tax = $this->california_tax['cost'];
         $cart  = $this->cart_contents;

         $cname = $customer->fname . " " . $customer->lname;
         if ($formDataArray['addrchk'] == 0) {
            $addr1 = $customer->address1;
            $addr2 = $customer->address2;
            $zip = $customer->postalcode;
            $city = $customer->city;
            $state = State::where('id', $customer->state_id)->pluck('iso2')->first() ?? '';
            $country = Country::where('id', $customer->country_id)->pluck('iso2')->first() ?? '';
            //   dd($formDataArray);


         }

         if ($formDataArray['addrchk'] == 1) {
            $addr1 = $formDataArray['address1'];
            $addr2 = $formDataArray['address2'];
            $zip = $formDataArray['postcode'];
            $state = State::where('id', $formDataArray['state'])->pluck('iso2')->first() ?? '';
            $country = Country::where('id', $formDataArray['country'])->pluck('iso2')->first() ?? '';
         }

         // print_r($this->cart->contents());
         // echo $this->session->userdata('Shipping_rate');
         $total_price = 0;
         $total_handling = 0;
         // $total_tax = 0;

         foreach ($cart as $index => $item) {

            // $total_price += $item['subtotal'];
            $total_handling += $item['handling_fee'];
            // $total_tax += $item['tax'];
         }
         // dd($california_Tax);
         if ($california_Tax == '-1') {
            $ctax = 0;
         } else {
            $ctax = $california_Tax;
         }
         //  dd($ctax);
         $grand_total = $this->others_contents['cart_total'] + $total_handling + $shipping_cost + $ctax;
         //  dd($formDataArray);
         $year = substr($formDataArray['year'], 2);
         //  dd($year);
         // dd($california_Tax);
         $sale_data = [
            'amount' => floatval($grand_total),
            'tax_amount' => floatval($california_Tax),
            'credit_card' => [
               'number' => $formDataArray['cc'],
               'expiration_month' => $formDataArray['month'],
               'expiration_year' => $year
            ],
            'integrator_id' => $this->intigratorID,
            'csc' => $formDataArray['csc'],
            'billing_address' => [
               'name' => $cname,
               'street_address' => $addr1,
               'street_address2' => $addr2,
               'city' => $city,
               'state' => $state,
               'zip' => $zip,
               'country' => $country,
            ]
         ];

         // dd($this->user->status);
         // dd($sale_data);
         try {
            // dd($this->intigratorID);
            // try {
               $res = $client->request('POST', $this->auth_server."/v1/transactions/sale/keyed", [
                   'headers' => ['Authorization' => "Bearer $token"],
                   'json' => $sale_data // Use 'json' instead of 'data' if the data needs to be sent as JSON
               ]);
         //   } catch (ClientException $e) {
         //       $responseBody = $e->getResponse()->getBody()->getContents();
         //       // dd($responseBody); // Or use another method to log/display the full response
         //   }
         // dd($res);
         if ($res->getStatusCode() == 200) {
           
            $responseData = $res->getBody()->getContents();
            $json = json_decode($responseData);

            $message = '';
            $orderStatus = $this->user->status == 3 ? 2 : 3;
            // dd($orderStatus);
            $query = DB::table('orders')->where('transaction_id', $json->transaction_id)->get();
            if ($query->isEmpty()) {
               $data = array(
                  'customer_email' => $user_email,
                  'payment_id' => $json->transaction_id,
                  'transaction_id' => $json->transaction_id,
                  'sub_total' => $this->others_contents['cart_total'],
                  'shipping_cost' => $shipping_cost,
                  'handling_fee' => $total_handling,
                  'tax' => ($california_Tax != -1) ? $california_Tax : 0.00,
                  'timestamp' => date('Y-m-d H:i:s'),
                  'order_status' => $orderStatus,
                  'transaction_status' => 'complete',
                  'additional_note' => '', //$this->session->userdata('additional_note'),
                  'transection_type' => 'paytrace'
               );

               $order = Order::create($data);
               // dd($order);
               $insert_id = $order->order_id;
               $data2 = array();


// dd($this->cart_contents);
               foreach ($this->cart_contents as $key => $value) {
                  $data2[] = array(
                     'product_id' => $value['id'],
                     'product_quantity' => $value['qty'],
                     'product_price' => $value['price'],
                     'handling_fee' => $value['handling_fee'],
                     'tax' => $value['tax'],
                     'order_id' => $insert_id,
                     'optional_info' => $value['options']['optional_info']
                  );
               }

               $insert_products = DB::table('orderitems')->insert($data2);
               // redirect(base_url('/'), 'refresh');

               // return true;

               if ($insert_products) {
                  $orderStatus = ($this->user->status == 1);
                  $orders_email = DB::table('orders')
                     ->where('customer_email', $this->user->email)
                     ->where('payment_id', $json->transaction_id)
                     ->orderBy('order_id', 'desc')
                     ->first();


                  $client = DB::table('users')->select('email')->first();

                  // $message = '<!DOCTYPE html><html><body>';
                  // $message .='<p>Customer Email:'.$orders_email['customer_email'].'</p>';
                  // $message .='<p>Order ID: #'.$orders_email['order_id'].'</p>';

                  // $message .='<p>Team at firequick</p>';
                  // $message .='</body></html>';
                  $order_id = $orders_email->order_id;
                  $orderitems = DB::table('orderitems')
                     ->join('products', 'orderitems.product_id', '=', 'products.product_id')
                     ->where('orderitems.order_id', $order_id)
                     ->select('orderitems.*', 'products.title')
                     ->get();


                  $orders = DB::table('orders')->where('order_id', $order_id)->first();
                  $customers = DB::table('customers')->where('email', $orders->customer_email)->first();
                  $states = DB::table('states')->where('id', $customers->state_id)->first();
                  $time = strtotime($orders->timestamp);
                  $dateInLocal = date("d-m-Y", $time);





                  // MAIL SENDING STARTS HERE 



                  //             $htmlitems = '';
                  //             foreach ($orderitems as $k => $v) {
                  //                $this->db->select('image_id');
                  //                $this->db->from('products');
                  //                $this->db->where('product_id', $v['product_id']);
                  //                $R = $this->db->get();
                  //                $HTMLimage_id = $R->result_array()[0];
                  //                $htmlitems .= ' <tr style="border-collapse:collapse">
                  //              <td align="left" style="Margin:0;padding-top:5px;padding-bottom:10px;padding-left:20px;padding-right:20px">
                  //                 <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                  //                    <tr style="border-collapse:collapse">
                  //                       <td class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;width:180px">
                  //                          <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                             <tr style="border-collapse:collapse">
                  //                                <td class="es-m-txt-c" align="center" style="padding:0;Margin:0;font-size:0px">
                  //                                   <img class="p_image" src="' . base_url('admin/assets/images') . "/" . $HTMLimage_id['image_id'] . '" alt="Natural Balance L.I.D., sale 30%" title="Natural Balance L.I.D., sale 30%" width="126" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" height="168">
                  //                                </td>
                  //                             </tr>
                  //                          </table>
                  //                       </td>
                  //                    </tr>
                  //                 </table>

                  //                 <table cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                    <tr style="border-collapse:collapse">
                  //                       <td align="left" style="padding:0;Margin:0;width:360px">
                  //                          <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                             <tr style="border-collapse:collapse">
                  //                                <td align="left" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px">
                  //                                   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" role="presentation">
                  //                                      <tr style="border-collapse:collapse">
                  //                                         <td style="padding:0;Margin:0">
                  //                                            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333"><strong class="p_name">' . $v["title"] . '</strong></p>
                  //                                         </td>
                  //                                         <td style="padding:0;Margin:0;text-align:center" width="15%">
                  //                                            <p class="p_quantity" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">' . $v["product_quantity"] . '</p>
                  //                                         </td>
                  //                                         <td style="padding:0;Margin:0;text-align:center" width="30%">
                  //                                            <p class="p_price" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">$' . $v["product_price"] . '</p>
                  //                                         </td>
                  //                                      </tr>
                  //                                   </table>
                  //                                </td>
                  //                             </tr>
                  //                             <tr style="border-collapse:collapse">
                  //                                <td align="left" style="padding:0;Margin:0">
                  //                                   <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#999999" class="p_option">' . $v["color"] . '</p>
                  //                                </td>
                  //                             </tr>
                  //                             <tr style="border-collapse:collapse">
                  //                                <td align="left" style="padding:0;Margin:0">
                  //                                   <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#999999" class="p_option_s">' . $v["size"] . '</p>
                  //                                </td>
                  //                             </tr>
                  //                          </table>
                  //                       </td>
                  //                    </tr>
                  //                 </table>

                  //              </td>
                  //            </tr>
                  //  <tr style="border-collapse:collapse">
                  //     <td align="left" style="padding:0;Margin:0">
                  //        <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //           <tr style="border-collapse:collapse">
                  //              <td align="center" valign="top" style="padding:0;Margin:0;width:600px">
                  //                 <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                    <tr style="border-collapse:collapse">
                  //                       <td align="center" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px">
                  //                          <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                             <tr style="border-collapse:collapse">
                  //                                <td style="padding:0;Margin:0;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px"></td>
                  //                             </tr>
                  //                          </table>
                  //                       </td>
                  //                    </tr>
                  //                 </table>
                  //              </td>
                  //           </tr>
                  //        </table>
                  //     </td>
                  //  </tr>';
                  //             }




                  //                      $m1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                  // <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;font-family:arial, helvetica neue, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
                  //    <head>
                  //       <meta charset="UTF-8">
                  //       <meta content="width=device-width, initial-scale=1" name="viewport">
                  //       <meta name="x-apple-disable-message-reformatting">
                  //       <meta http-equiv="X-UA-Compatible" content="IE=edge">
                  //       <meta content="telephone=no" name="format-detection">
                  //       <title>New Customer Order</title>
                  //       <style type="text/css">
                  //          @media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:left; line-height:120%!important } h2 { font-size:26px!important; text-align:left; line-height:120%!important } h3 { font-size:20px!important; text-align:left; line-height:120%!important } h1 a { font-size:30px!important; text-align:left } h2 a { font-size:26px!important; text-align:left } h3 a { font-size:20px!important; text-align:left } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c 
                  //          h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-left-width:0px!important; border-right-width:0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } 
                  //          .es-m-p0 { padding:0!important } .es-m-p0r { padding-right:0!important } .es-m-p0l { padding-left:0!important } .es-m-p0t { padding-top:0!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-m-p5 { padding:5px!important } .es-m-p5t { padding-top:5px!important } .es-m-p5b { padding-bottom:5px!important } .es-m-p5r { padding-right:5px!important } .es-m-p5l { padding-left:5px!important 
                  //          } .es-m-p10 { padding:10px!important } .es-m-p10t { padding-top:10px!important } .es-m-p10b { padding-bottom:10px!important } .es-m-p10r { padding-right:10px!important } .es-m-p10l { padding-left:10px!important } .es-m-p15 { padding:15px!important } .es-m-p15t { padding-top:15px!important } .es-m-p15b { padding-bottom:15px!important } .es-m-p15r { padding-right:15px!important } .es-m-p15l { padding-left:15px!important } .es-m-p20 { padding:20px!important } .es-m-p20t { padding-top:20px!important } .es-m-p20r { padding-right:20px!important } .es-m-p20l { padding-left:20px!important } .es-m-p25 { padding:25px!important } .es-m-p25t { padding-top:25px!important } .es-m-p25b { padding-bottom:25px!important } .es-m-p25r { padding-right:25px!important } .es-m-p25l { padding-left:25px!important } .es-m-p30 { padding:30px!important } .es-m-p30t { padding-top:30px!important } .es-m-p30b { padding-bottom:30px!important } .es-m-p30r { 
                  //          padding-right:30px!important } .es-m-p30l { padding-left:30px!important } .es-m-p35 { padding:35px!important } .es-m-p35t { padding-top:35px!important } .es-m-p35b { padding-bottom:35px!important } .es-m-p35r { padding-right:35px!important } .es-m-p35l { padding-left:35px!important } .es-m-p40 { padding:40px!important } .es-m-p40t { padding-top:40px!important } .es-m-p40b { padding-bottom:40px!important } .es-m-p40r { padding-right:40px!important } .es-m-p40l { padding-left:40px!important } }#outlook a {	padding:0;}.ExternalClass {	width:100%;}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div {	line-height:100%;}.es-button {	mso-style-priority:100!important;	text-decoration:none!important;}a[x-apple-data-detectors] 
                  //          {	color:inherit!important;	text-decoration:none!important;	font-size:inherit!important;	font-family:inherit!important;	font-weight:inherit!important;	line-height:inherit!important;}.es-desk-hidden {	display:none;	float:left;	overflow:hidden;	width:0;	max-height:0;	line-height:0;	mso-hide:all;}
                  //       </style>
                  //    </head>
                  //    <body style="width:100%;font-family:arial, helvetica neue, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
                  //       <div class="es-wrapper-color" style="background-color:#F6F6F6">
                  //          <table class="es-wrapper" cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top">
                  //             <tr style="border-collapse:collapse">
                  //                <td valign="top" style="padding:0;Margin:0">
                  //                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                  //                      <tr style="border-collapse:collapse">
                  //                         <td class="es-adaptive" align="center" style="padding:0;Margin:0">
                  //                            <table class="es-content-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td align="left" style="padding:10px;Margin:0">
                  //                                     <table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="left" style="padding:0;Margin:0;width:580px">
                  //                                              <table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td class="es-infoblock es-m-txt-c" align="center" style="padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC">
                  //                                                       <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:22px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:26px;color:#FF4000"><strong><span style="white-space:nowrap">Call 760-377-5766,&nbsp;1-855-FPI-FIRE (374-3473)</span></strong></p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;font-size:0">
                  //                                                       <table cellspacing="0" cellpadding="0" width="100%" height="100%" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td style="padding:0;Margin:0;border-bottom:3px solid #DFDDDC;background:none;height:1px;width:100%;margin:0px"></td>
                  //                                                          </tr>
                  //                                                       </table>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                            </table>
                  //                         </td>
                  //                      </tr>
                  //                   </table>
                  //                   <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                  //                      <tr style="border-collapse:collapse">
                  //                         <td align="center" style="padding:0;Margin:0">
                  //                            <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td style="padding:10px;Margin:0;background-color:#FFFFFF" bgcolor="#ffffff" align="left">
                  //                                     <table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                  //                                              <table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="center" style="padding:5px;Margin:0;font-size:0px">
                  //                                                       <a href="https://www.firequick.com/" target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#1376C8"><img src="https://hjyjbx.stripocdn.email/content/guids/CABINET_6adf9eda672b807f147ae669e070aeca/images/59031597362584415.png" alt width="279" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" class="adapt-img" height="61"></a>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                            </table>
                  //                         </td>
                  //                      </tr>
                  //                   </table>
                  //                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                  //                      <tr style="border-collapse:collapse">
                  //                         <td align="center" style="padding:0;Margin:0">
                  //                            <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#2F130A;width:600px" cellspacing="0" cellpadding="0" bgcolor="#2f130a" align="center">
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;background-color:#FF4000" bgcolor="#ff4000" align="left">
                  //                                     <table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                  //                                              <table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td class="es-m-txt-c es-m-p0" align="center" style="padding:0;Margin:0">
                  //                                                       <h2 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:24px;font-style:normal;font-weight:normal;color:#FFFFFF"><strong>New Customer Order</strong></h2>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td class="es-m-txt-c es-m-p0" align="center" style="padding:10px;Margin:0">
                  //                                                       <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:24px;color:#FFFFFF">Hello Admin</p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                            </table>
                  //                         </td>
                  //                      </tr>
                  //                   </table>
                  //                   <table class="es-wrapper" cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;background-repeat:repeat;background-position:center top">
                  //                      <tr style="border-collapse:collapse">
                  //                         <td valign="top" style="padding:0;Margin:0">
                  //                            <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td align="center" style="padding:0;Margin:0">
                  //                                     <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px">
                  //                                              <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                  //                                                       <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td align="left" style="padding:0;Margin:0">
                  //                                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:27px;color:#FF4000">Order ID:<strong>&nbsp;' . $orders["order_id"] . ',&nbsp;(' . $dateInLocal . ')</strong></p>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                  //                                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:27px;color:#333333">You have Received an order from <strong>user ' . $customers["fname"] . " " . $customers["lname"] . '</strong>. The Order is as follow</p>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                       </table>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="left" style="Margin:0;padding-bottom:10px;padding-top:20px;padding-left:20px;padding-right:20px;background-position:center center">
                  //                                              <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;width:178px">
                  //                                                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                          <tr class="es-mobile-hidden" style="border-collapse:collapse">
                  //                                                             <td align="left" style="padding:0;Margin:0">
                  //                                                                <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif">ITEM</h4>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                       </table>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                              <table cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="left" style="padding:0;Margin:0;width:362px">
                  //                                                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td align="left" style="padding:0;Margin:0">
                  //                                                                <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" role="presentation">
                  //                                                                   <tr style="border-collapse:collapse">
                  //                                                                      <td style="padding:0;Margin:0;font-size:13px">
                  //                                                                         <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333"><strong>NAME</strong></p>
                  //                                                                      </td>
                  //                                                                      <td style="padding:0;Margin:0;text-align:center;font-size:13px;line-height:13px" width="15%">
                  //                                                                         <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333"><strong>QTY</strong></p>
                  //                                                                      </td>
                  //                                                                      <td style="padding:0;Margin:0;text-align:center;font-size:13px;line-height:13px" width="30%">
                  //                                                                         <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333"><strong>PRICE</strong></p>
                  //                                                                      </td>
                  //                                                                   </tr>
                  //                                                                </table>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                       </table>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="left" style="padding:0;Margin:0">
                  //                                              <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="center" valign="top" style="padding:0;Margin:0;width:600px">
                  //                                                       <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td align="center" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px">
                  //                                                                <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                                   <tr style="border-collapse:collapse">
                  //                                                                      <td style="padding:0;Margin:0;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px"></td>
                  //                                                                   </tr>
                  //                                                                </table>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                       </table>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>';

                  //                      $m1 .= $htmlitems;

                  //                      $m1 .= '<tr style="border-collapse:collapse">
                  //                                  <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:40px">
                  //                                     <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td valign="top" align="center" style="padding:0;Margin:0;width:540px">
                  //                                              <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="right" class="es-m-txt-c" style="padding:0;Margin:0">
                  //                                                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="right" role="presentation">
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td style="padding:0;Margin:0;text-align:right;line-height:150%">
                  //                                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">Subtotal (' . count($orderitems) . ' items):</p>
                  //                                                             </td>
                  //                                                             <td style="padding:0;Margin:0;text-align:right;font-size:18px;line-height:27px">
                  //                                                                <p class="p_subtotal" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">$' . $orders['sub_total'] . '</p>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td style="padding:0;Margin:0;text-align:right;font-size:18px;line-height:27px">
                  //                                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:27px;color:#333333"><strong>Shipping:</strong></p>
                  //                                                             </td>
                  //                                                             <td style="padding:0;Margin:0;text-align:right;font-size:18px;line-height:27px;color:#008000">
                  //                                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333"><strong class="p_rate_shipping">
                  //                                                                   $' . $orders["shipping_cost"] . '&nbsp;<span style="font-size:10px">via FeDEX </span></strong>
                  //                                                                </p>
                  //                                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:15px;color:#333333"><strong class="p_rate_shipping">Ground Home Delivery</strong></p>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td style="padding:0;Margin:0;text-align:right;font-size:18px;line-height:27px">
                  //                                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">Handling Charges:</p>
                  //                                                             </td>
                  //                                                             <td style="padding:0;Margin:0;text-align:right;font-size:18px;line-height:27px">
                  //                                                                <p class="p_discount" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">$' . $orders['handling_fee'] . '</p>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td style="padding:0;Margin:0;text-align:right;font-size:18px;line-height:27px">
                  //                                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">Tax:</p>
                  //                                                             </td>
                  //                                                             <td style="padding:0;Margin:0;text-align:right;font-size:18px;line-height:27px">
                  //                                                                <p class="p_tax" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">$' . $orders["tax"] . '</p>
                  //                                                             </td>
                  //                                                          </tr>
                  //                                                       </table>
                  //                                                       <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#38761D"><br></p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td align="left" style="padding:0;Margin:0">
                  //                                     <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="center" valign="top" style="padding:0;Margin:0;width:600px">
                  //                                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="center" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px">
                  //                                                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td style="padding:0;Margin:0;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px"></td>
                  //                                                          </tr>
                  //                                                       </table>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td align="left" style="padding:0;Margin:0;padding-bottom:20px;padding-left:20px;padding-right:20px;background-position:center top">
                  //                                     <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                  //                                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="right" class="es-m-txt-r" style="padding:0;Margin:0;padding-left:20px;padding-right:20px">
                  //                                                       <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:5px;color:#333333"><strong>Payment Method: <span class="p_order_total">Credit/Debit Card</span></strong></p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td align="left" style="padding:0;Margin:0;padding-bottom:20px;padding-left:20px;padding-right:20px;background-position:center top">
                  //                                     <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                  //                                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="right" class="es-m-txt-r" style="padding:0;Margin:0;padding-left:20px;padding-right:20px">
                  //                                                       <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:20px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:30px;color:#333333"><strong>Order Total: <span class="p_order_total">$' . number_format($orders['shipping_cost'] + $orders['tax'] + $orders['handling_fee'] + $orders['sub_total'], 2, ".", ",") . '</span></strong></p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px">
                  //                                     <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="left" style="padding:0;Margin:0;width:560px">
                  //                                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="left" style="padding:0;Margin:0">
                  //                                                       <h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#333333"><strong>Customer Details</strong></h3>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                  //                                                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                          <tr style="border-collapse:collapse">
                  //                                                             <td style="padding:0;Margin:0;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px"></td>
                  //                                                          </tr>
                  //                                                       </table>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="left" class="es-m-txt-c" style="padding:0;Margin:0">
                  //                                                       <p class="p_order" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:24px;color:#333333"><strong>Email: ' . $customers["email"] . '</strong></p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="left" class="es-m-txt-c" style="padding:0;Margin:0">
                  //                                                       <p class="p_order" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:24px;color:#333333"><strong>Phone: ' . $customers["phone"] . '</strong></p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px">
                  //                                     <table cellpadding="0" cellspacing="0" align="left" class="es-left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:270px">
                  //                                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="left" class="es-m-txt-c" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px">
                  //                                                       <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333"><strong>Shipping address</strong></p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td align="left" class="es-m-txt-c" style="padding:0;Margin:0">
                  //                                                       <p class="p_s_address" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#333333">' . $customers["city"] . ',<br>' . $customers["address1"] . "&nbsp;" . $customers["address2"] . '<br>' . $states["name"] . '</p>
                  //                                                    </td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>

                  //                                  </td>
                  //                               </tr>
                  //                            </table>
                  //                         </td>
                  //                      </tr>
                  //                   </table>
                  //                </td>
                  //             </tr>
                  //          </table>
                  //          <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                  //             <tr style="border-collapse:collapse">
                  //                <td align="center" style="padding:0;Margin:0">
                  //                   <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                  //                      <tr style="border-collapse:collapse">
                  //                         <td align="left" style="padding:0;Margin:0">
                  //                            <table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                  //                                     <table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td align="center" style="padding:0;Margin:0;padding-bottom:40px;padding-left:40px;padding-right:40px;font-size:0">
                  //                                              <table cellspacing="0" cellpadding="0" width="100%" height="100%" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                                 <tr style="border-collapse:collapse">
                  //                                                    <td style="padding:0;Margin:0;border-bottom:1px solid #EFEFEF;background:none;height:1px;width:100%;margin:0px"></td>
                  //                                                 </tr>
                  //                                              </table>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                            </table>
                  //                         </td>
                  //                      </tr>
                  //                   </table>
                  //                </td>
                  //             </tr>
                  //          </table>
                  //          <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                  //             <tr style="border-collapse:collapse">
                  //                <td align="center" style="padding:0;Margin:0">
                  //                   <table class="es-footer-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#333333;width:600px">
                  //                      <tr style="border-collapse:collapse">
                  //                         <td align="left" bgcolor="#180300" style="Margin:0;padding-top:25px;padding-bottom:25px;padding-left:40px;padding-right:40px;background-color:#180300">
                  //                            <table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                               <tr style="border-collapse:collapse">
                  //                                  <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                  //                                     <table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                  //                                        <tr style="border-collapse:collapse">
                  //                                           <td class="es-infoblock" align="center" style="padding:0;Margin:0;line-height:0px;font-size:0px;color:#CCCCCC">
                  //                                              <a target="_blank" href="https://www.firequick.com/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#CCCCCC"><img src="https://hjyjbx.stripocdn.email/content/guids/CABINET_6adf9eda672b807f147ae669e070aeca/images/59031597362584415.png" alt width="230" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" height="50"></a>
                  //                                           </td>
                  //                                        </tr>
                  //                                     </table>
                  //                                  </td>
                  //                               </tr>
                  //                            </table>
                  //                         </td>
                  //                      </tr>
                  //                   </table>
                  //                </td>
                  //             </tr>
                  //          </table>
                  //          </td></tr></table>
                  //       </div>
                  //    </body>
                  // </html>';

                  //                      // new order received
                  //                      $mail = $this->phpmailer_lib->load();
                  //                      $mail->addAddress($client['email']);
                  //                      $mail->Subject = 'New Order Received.';
                  //                      $mail->Body  = $m1;
                  //                      $mail->send();





                  //                      $customerservices = $this->db->get_where('bottom_menus', array('status' => 1, 'place' => 'customerservices'));
                  //                      $this->db->order_by("order", "asc");
                  //                      $link = '';
                  //                      foreach ($customerservices->result_array() as $value) {
                  //                         $string = str_replace(' ', '-', $value['title']); // Replaces all spaces with hyphens.
                  //                         $tit = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
                  //                         $link .= '<p style="margin: 0;-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly;font-size: 14px;font-family: arial, helvetica neue, helvetica, sans-serif;line-height: 21px;color: #ffffff;"><a href="' . base_url('page') . '/' . $value['page_id'] . '/' . $tit . '" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: arial, helvetica neue, helvetica, sans-serif;font-size: 14px;text-decoration: none;color: #ffffff;">' . $value['title'] . '</a></p>';
                  //                      }
                  //                      $link .= '<p style="margin: 0;-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly;font-size: 14px;font-family: arial, helvetica neue, helvetica, sans-serif;line-height: 21px;color: #ffffff;"><a href="' . base_url('/page/contact-us') . '" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: arial, helvetica neue, helvetica, sans-serif;font-size: 14px;text-decoration: none;color: #ffffff;">Contact Us</a></p>';

                  //                      $m = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;font-family:arial, helvetica neue, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0"><head><meta charset="UTF-8"><meta content="width=device-width, initial-scale=1" name="viewport"><meta name="x-apple-disable-message-reformatting"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="telephone=no" name="format-detection"><title>New Order at Firequick</title>
                  // 	<style type="text/css">
                  // @media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:left; line-height:120%!important } h2 { font-size:26px!important; text-align:left; line-height:120%!important } h3 { font-size:20px!important; text-align:left; line-height:120%!important } h1 a { font-size:30px!important; text-align:left } h2 a { font-size:26px!important; text-align:left } h3 a { font-size:20px!important; text-align:left } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c 
                  // h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-left-width:0px!important; border-right-width:0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } 
                  // .es-m-p0 { padding:0!important } .es-m-p0r { padding-right:0!important } .es-m-p0l { padding-left:0!important } .es-m-p0t { padding-top:0!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-m-p5 { padding:5px!important } .es-m-p5t { padding-top:5px!important } .es-m-p5b { padding-bottom:5px!important } .es-m-p5r { padding-right:5px!important } .es-m-p5l { padding-left:5px!important 
                  // } .es-m-p10 { padding:10px!important } .es-m-p10t { padding-top:10px!important } .es-m-p10b { padding-bottom:10px!important } .es-m-p10r { padding-right:10px!important } .es-m-p10l { padding-left:10px!important } .es-m-p15 { padding:15px!important } .es-m-p15t { padding-top:15px!important } .es-m-p15b { padding-bottom:15px!important } .es-m-p15r { padding-right:15px!important } .es-m-p15l { padding-left:15px!important } .es-m-p20 { padding:20px!important } .es-m-p20t { padding-top:20px!important } .es-m-p20r { padding-right:20px!important } .es-m-p20l { padding-left:20px!important } .es-m-p25 { padding:25px!important } .es-m-p25t { padding-top:25px!important } .es-m-p25b { padding-bottom:25px!important } .es-m-p25r { padding-right:25px!important } .es-m-p25l { padding-left:25px!important } .es-m-p30 { padding:30px!important } .es-m-p30t { padding-top:30px!important } .es-m-p30b { padding-bottom:30px!important } .es-m-p30r { 
                  // padding-right:30px!important } .es-m-p30l { padding-left:30px!important } .es-m-p35 { padding:35px!important } .es-m-p35t { padding-top:35px!important } .es-m-p35b { padding-bottom:35px!important } .es-m-p35r { padding-right:35px!important } .es-m-p35l { padding-left:35px!important } .es-m-p40 { padding:40px!important } .es-m-p40t { padding-top:40px!important } .es-m-p40b { padding-bottom:40px!important } .es-m-p40r { padding-right:40px!important } .es-m-p40l { padding-left:40px!important } }#outlook a {	padding:0;}.ExternalClass {	width:100%;}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div {	line-height:100%;}.es-button {	mso-style-priority:100!important;	text-decoration:none!important;}a[x-apple-data-detectors] 
                  // {	color:inherit!important;	text-decoration:none!important;	font-size:inherit!important;	font-family:inherit!important;	font-weight:inherit!important;	line-height:inherit!important;}.es-desk-hidden {	display:none;	float:left;	overflow:hidden;	width:0;	max-height:0;	line-height:0;	mso-hide:all;}</style></head><body style="width:100%;font-family:arial, helvetica neue, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0"><div class="es-wrapper-color" style="background-color:#F6F6F6"> 
                  // <table class="es-wrapper" cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top"><tr style="border-collapse:collapse"><td valign="top" style="padding:0;Margin:0"><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"><tr style="border-collapse:collapse"><td class="es-adaptive" align="center" style="padding:0;Margin:0"><table class="es-content-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px"><tr style="border-collapse:collapse"><td align="left" style="padding:10px;Margin:0">
                  // <table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td align="left" style="padding:0;Margin:0;width:580px"><table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td class="es-infoblock es-m-txt-c" align="center" style="padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:22px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:26px;color:#FF4000"><strong><span style="white-space:nowrap">Call 760-377-5766,&nbsp;1-855-FPI-FIRE (374-3473)</span></strong></p></td></tr><tr style="border-collapse:collapse">
                  // <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;font-size:0"><table cellspacing="0" cellpadding="0" width="100%" height="100%" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td style="padding:0;Margin:0;border-bottom:3px solid #DFDDDC;background:none;height:1px;width:100%;margin:0px"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top"><tr style="border-collapse:collapse"><td align="center" style="padding:0;Margin:0">
                  // <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center"><tr style="border-collapse:collapse"><td style="padding:10px;Margin:0;background-color:#FFFFFF" bgcolor="#ffffff" align="left"><table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td valign="top" align="center" style="padding:0;Margin:0;width:580px"><table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td align="center" style="padding:5px;Margin:0;font-size:0px">
                  // <a href="https://www.firequick.com/" target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#1376C8"><img src="https://hjyjbx.stripocdn.email/content/guids/CABINET_6adf9eda672b807f147ae669e070aeca/images/59031597362584415.png" alt width="279" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" class="adapt-img" height="61"></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"><tr style="border-collapse:collapse"><td align="center" style="padding:0;Margin:0">
                  // <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#2F130A;width:600px" cellspacing="0" cellpadding="0" bgcolor="#2f130a" align="center"><tr style="border-collapse:collapse"><td style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;background-color:#FF4000" bgcolor="#ff4000" align="left"><table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td class="es-m-txt-c es-m-p0" align="center" style="padding:0;Margin:0">
                  // <h2 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:24px;font-style:normal;font-weight:normal;color:#FFFFFF"><strong>New Order at Firequick</strong></h2></td></tr><tr style="border-collapse:collapse"><td class="es-m-txt-c es-m-p0" align="center" style="padding:10px;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:24px;color:#FFFFFF">Dear Firequick Customer <strong>' . $cname . '</strong></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"><tr style="border-collapse:collapse">
                  // <td align="center" style="padding:0;Margin:0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px"><tr style="border-collapse:collapse"><td align="left" style="padding:20px;Margin:0"><table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td align="left" style="padding:0;Margin:0;width:560px"><table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td class="es-m-p0" align="left" style="padding:0;Margin:0;padding-top:15px">
                  // <h3 style="Margin:0;line-height:30px;font-family:arial,helvetica neue,helvetica,sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#333333">Thank you for placing your order with us.  For your convenience, the tracking information will be emailed to you via FedEx Ground.  If you have any other further questions, please do not hesitate to call <strong><a href="tel:760-377-5766" style="font-family:arial,helvetica neue,helvetica,sans-serif;font-size:20px;text-decoration:underline;color:#ff4000;line-height:30px" target="_blank">760-377-5766</a></strong>. Thank you for your business – we appreciate it very much and look forward to serving you again in the future.  Have a great day!</h3>
                  // <p style="Margin:0;font-size:14px;font-family:arial,helvetica neue,helvetica,sans-serif;line-height:21px;color:#333333"><br></p>
                  // <h3 style="Margin:0;line-height:30px;font-family:arial,helvetica neue,helvetica,sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#333333">Regards</h3>
                  // <h3 style="Margin:0;line-height:30px;font-family:arial,helvetica neue,helvetica,sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#333333"><strong>Firequick Customer Services.</strong></h3>
                  // </td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"><tr style="border-collapse:collapse"><td align="center" style="padding:0;Margin:0"><table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                  // <tr style="border-collapse:collapse"><td align="left" style="padding:0;Margin:0"><table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td valign="top" align="center" style="padding:0;Margin:0;width:600px"><table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td align="center" style="padding:0;Margin:0;padding-bottom:40px;padding-left:40px;padding-right:40px;font-size:0"><table cellspacing="0" cellpadding="0" width="100%" height="100%" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse">
                  // <td style="padding:0;Margin:0;border-bottom:1px solid #EFEFEF;background:none;height:1px;width:100%;margin:0px"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top"><tr style="border-collapse:collapse"><td align="center" style="padding:0;Margin:0"><table class="es-footer-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#333333;width:600px"><tr style="border-collapse:collapse">
                  // <td align="left" bgcolor="#180300" style="Margin:0;padding-top:25px;padding-bottom:25px;padding-left:40px;padding-right:40px;background-color:#180300"> <!--[if mso]><table style="width:520px" cellpadding="0" cellspacing="0"><tr><td style="width:250px" valign="top"><![endif]--><table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left"><tr style="border-collapse:collapse"><td class="es-m-p0r es-m-p20b" align="center" style="padding:0;Margin:0;width:250px"><table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:10px">
                  // <h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#FF4000">Contact Us</h3></td></tr><tr style="border-collapse:collapse"><td class="es-m-txt-c" align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#FFFFFF">Firequick Products, Inc.<br>P.O. Box 910<br>Inyokern, CA 93527<br>Phone:&nbsp;<a href="tel:760-377-5766" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#FFFFFF">760-377-5766</a><br>
                  // Toll Free&nbsp;<a href="tel:855-374-3473" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#FFFFFF">855-FPI-FIRE (855-374-3473)</a><br>Fax: 760-377-5761</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#FFFFFF"><br></p></td></tr></table></td></tr></table>
                  // <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right"><tr style="border-collapse:collapse"><td class="es-m-p0r" align="center" style="padding:0;Margin:0;width:250px">
                  // <table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:10px"><h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#FF4000;text-align:center">Customer Service</h3></td></tr><tr style="border-collapse:collapse"><td class="es-m-txt-c" align="center" style="padding:0;Margin:0">';

                  //                      $m .= $link;

                  //                      $m .= '</td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"><tr style="border-collapse:collapse"><td align="center" style="padding:0;Margin:0"><table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center"><tr style="border-collapse:collapse">
                  // <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px"><table cellspacing="0" cellpadding="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table cellspacing="0" cellpadding="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr style="border-collapse:collapse"><td class="es-infoblock" align="center" style="padding:0;Margin:0;line-height:0px;font-size:0px;color:#CCCCCC">
                  // <a target="_blank" href="http://viewstripo.email/?utm_source=templates&utm_medium=email&utm_campaign=basic&utm_content=master" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#CCCCCC"><img src="https://hjyjbx.stripocdn.email/content/guids/CABINET_6adf9eda672b807f147ae669e070aeca/images/59031597362584415.png" alt width="230" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" height="50"></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>
                  // </html>';



                  //                      $mail = $this->phpmailer_lib->load();
                  //                      $mail->addAddress($orders_email['customer_email']);
                  //                      $mail->Subject = 'Order at Firequick.com';
                  //                      $mail->Body  = $m;
                  //                      $mail->send();

                  $cartService = new Cart;
                  $cartService->destroy();
                  $str = 'Order Has been Successfully Placed.';
                  $msg = base64_encode($str);
               }
            }
            print_r($responseData);
         }
         } catch (ClientException  $e) {
         
            // dd($e);
         $response = $e->getResponse();
         var_dump($response);
         die();
         $responseBodyAsString = $response->getBody()->getContents();
         print_r($responseBodyAsString);
         }
      // }
   }
}
}