<?php

$pagseguro_keys = get_settings('pagseguro');
$pagseguro = json_decode($pagseguro_keys);

$modo = $pagseguro[0]->mode;
$pagseguro_email = $pagseguro[0]->email;
$pagseguro_token = $pagseguro[0]->token;

if ($modo = "sandbox") {
$sandbox = "";
} else {
$sandbox = "";
}
//Essa URL será acionada sempre que uma transação ocorrer
$pagseguro_url = "https://ws.pagseguro.uol.com.br/v2/checkout";

$data['email'] = $pagseguro_email;
$data['token'] = $pagseguro_token;
$data['currency'] = "BRL";

$conta = 0;


$id_item = "";
$valortotal = 0;
  
        foreach ($this->session->userdata('cart_items') as $cart_item) {
        $course_details = $this->crud_model->get_course_by_id($cart_item)->row_array();
        $instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array();
    
    $conta++;
            
            if ($course_details['discount_flag'] == 1) :
            $preco = moeda($course_details['discounted_price']);
            $valorunitario = $course_details['discounted_price'];
			else :
			$preco = moeda($course_details['price']);
            $valorunitario = $course_details['price'];
			endif;
            
            $data['itemId' . $conta] = $conta;
            $data['itemDescription' . $conta] = $course_details['title'];
            $data['itemAmount'  . $conta] = $preco;
            $data['itemQuantity' . $conta] = "1";
            $id_item .= $cart_item . ":";
            $valortotal += $valorunitario;
                        
                }
$data['currency'] = "BRL";
$data['notificationURL'] = site_url('home/retorno_pagseguro');


$id_item = substr($id_item,0,-1);

$id_transaction = $this->crud_model->add_pagseguro_transaction($id_user = $this->session->userdata('user_id'), $id_courses =  $id_item, $amount = moeda($valortotal), $status = "1");
$data['reference'] = $id_transaction;

/*
$id_item1 = explode(":",$id_item);

//for ($i=0;$i<sizeof($id_item1);$i++)
  //  {
    //  echo $id_item1[$i];
    //  echo "<br>";
    //}



echo "<b>ID User: </b>" . $this->session->userdata('user_id') . "<br>";
echo "<b>Email: </b>" . $pagseguro_email . "<br>";
echo "<b>Token: </b>" . $pagseguro_token . "<br>";
echo "<b>URL: </b>" . $pagseguro_url . "<br>";
echo "<b>Itens: </b>" . $id_item . "<br>";
echo "<b>URL Reotrno: </b>" . $data['notificationURL'] . "<br>";
echo "<b>Valor Total: </b>" . moeda($valortotal) . "<br>";
echo "Referencia: " . $data['reference'] . "<br>";
*/


$data = http_build_query($data);

$curl = curl_init($pagseguro_url);
curl_setopt($curl,CURLOPT_HTTPHEADER, Array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POSTFIELDS,$data);


$xml = curl_exec($curl);
curl_close($curl);



$xml = simplexml_load_string($xml);

echo $xml -> code;
//echo '<br>' . $data;
//echo json_encode($xml);


?>