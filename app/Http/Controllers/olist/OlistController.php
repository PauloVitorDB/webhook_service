<?php

namespace App\Http\Controllers\olist;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

class OlistController extends Controller {
   
    public function notification(Request $request) {

        $request->validate([
            'received_at' => 'required', 
            'resource' => 'required', 
            'topic' => 'required', 
            'seller_id' => 'required'
        ]);

        $client_info = getClientByServiceValue("olist", $request->seller_id);
        
        if($client_info) {

            $endpoint = $client_info['url'] . "/index.php?route=feed/olist/notificationOlist";
        
            $client = new \GuzzleHttp\Client();
    
            $req_response = $client->request('POST', $endpoint, [
                'json' => [
                    'received_at' 	=> $request->received_at,
                    'resource'      => $request->resource,
                    'sent_at'      	=> $request->sent_at,
                    'topic'  		=> $request->topic,
                    'seller_id' 	=> $request->seller_id
                ]
            ]);
    
            $statusCode = $req_response->getStatusCode();
    
            $response = array(
                'message' => $statusCode == 201 ? 'Notification received' : 'Some error on payload',
                'code'    => $statusCode
            );
    
            return response($response)
                ->setStatusCode($statusCode)
                ->withHeaders([
                    'X-Client-Name' => $client_info['name'],
                    'Content-Type:' => 'application/json'
                ]);          
        } else {
            abort(401, 'Invalid seller_id');
        }

    }

    public function authentication(Request $request) {
        
        $request->validate([
            'state' => 'required',
            'code' => 'required'
        ]);

        $email = base64_decode($request->state);
        
        $client = getClientByServiceValue("olist", $email);
         
        if($client) {
            return redirect()->away($client['url'] . '/index.php?route=feed/olist/callback&code=' . $request->code  . '&state=' . $request->state);
        } else {
            abort(401, 'Invalid client authentication');
        }
    
    }
    
}
