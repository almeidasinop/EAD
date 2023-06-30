<?php

$pagseguro_keys = get_settings( 'pagseguro' );
$pagseguro = json_decode( $pagseguro_keys );

$modo = $pagseguro[0]->mode;
$pagseguro_email = $pagseguro[0]->email;
$pagseguro_token = $pagseguro[0]->token;

if ( $modo = "sandbox" ) {
    $sandbox = ".sandbox";
    header( "access-control-allow-origin: https://pagseguro.uol.com.br" );
} else {
    $sandbox = "";
    header( "access-control-allow-origin: https://pagseguro.uol.com.br" );
}

//$this->crud_model->pagseguro_update_status( $id = '15', $status =  '4' );

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    $url = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/".$_POST['notificationCode']."?email=".$pagseguro_email."&token=".$pagseguro_token;

    $curl = curl_init( $url );
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    $transactions_curl = curl_exec( $curl );
    curl_close( $curl );

    $transactions = simplexml_load_string( utf8_encode( $transactions_curl ) );

    $referencia = $transactions->reference;
    $status = $transactions->status;

    $transacao_pagseguro = $transactions->code;

    //$status = 3;
    //$referencia = 15;
    if ( $status == 3 ) {
        
        $transaction = $this->crud_model->get_transactions_by_id( $transaction_id = $referencia );
        foreach ( $transaction->result_array() as $pagseguro_transaction ) {
                $id_transaction = $pagseguro_transaction['id'];
                $id_user = $pagseguro_transaction['id_user'];
                $id_courses = $pagseguro_transaction['id_courses'];
                $amount = $pagseguro_transaction['amount'];
                $status_pagseguro = $pagseguro_transaction['status'];

            if ($status_pagseguro != '3') {
                $this->crud_model->pagseguro_update_status( $id = $referencia, $status =  '3' );
            
                $lista_courses = explode( ":", $id_courses );

                for ( $i = 0; $i<sizeof( $lista_courses );
                $i++ ) {
                    $id_curso =  $lista_courses[$i];
                    $this->crud_model->add_enrol( $id_user = $id_user, $course_id = $id_curso );
                    $this->crud_model->add_payment( $id_user, $id_curso, 'pagseguro' );
                }
            }
        }
    } else {
        $this->crud_model->pagseguro_update_status( $id = $referencia, $status =  $status );
    }
}

?>