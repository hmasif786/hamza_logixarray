<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fxrates extends CI_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('Fxrate');
        $this->load->helper('ratelimit');
    } 

	public function index()
	{
		$this->load->view('view');
	}

    public function get_rates ()
    {
        $result = $this->Fxrate->last_record();
        if($result['date'] != date('Y-m-d')) { // Cron Jobs Require Cpanel
            $ch = curl_init();
            $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            );
            $url = 'https://api.exchangerate.host/latest?base=GBP&symbols=USD,EUR,SEK,CAD,AUD,AED,TRY';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
        
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $response = curl_exec($ch);
            $response = json_decode($response);
            $data = array();
            if($response->success == 1) {
                $data = array(
                    'AED' => $response->rates->AED,
                    'AUD' => $response->rates->AUD,
                    'CAD' => $response->rates->CAD,
                    'EUR' => $response->rates->EUR,
                    'SEK' => $response->rates->SEK,
                    'TRY' => $response->rates->TRY,
                    'USD' => $response->rates->USD,
                    'date' => $response->date,
                );
                $this->Fxrate->saverecords($data);
            } else {
                echo $response->error;
            }
        }
    }

    public function currency_conversion ()
    {
        $this->get_rates();
        $result = $this->Fxrate->last_record();
        $order_currency = $this->input->post('order_currency');
        $amount = $this->input->post('amount');
        if ($order_currency == 'AED')
            return $amount * $result['AED'];
        else if ($order_currency == 'AUD')
            return $amount * $result['AUD'];
        else if ($order_currency == 'CAD')
            return $amount * $result['CAD'];
        else if ($order_currency == 'EUR')
            return $amount * $result['EUR'];
        else if ($order_currency == 'SEK')
            return $amount * $result['SEK'];
        else if ($order_currency == 'TRY')
            return $amount * $result['TRY'];
        else
            return $amount * $result['USD'];
    }

    public function vendors_rates ()
    {
        limitRequests('key', 1, 60);  //throttler is supported in CI 4
        $result = $this->Fxrate->fx_data();
        echo json_encode($result);
    }
}
