<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

// INSERT VERSION NUMBER INSIDE SETTINGS TABLE
$settings_data = array( 'value' => '5.0');
$CI->db->where('key', 'version');
$CI->db->update('settings', $settings_data);


// CREATING PAGSEGURO_TRANSACTION TABLE
$pagseguro_transaction_fields = array(
	'id' => array(
		'type' => 'INT',
		'constraint' => 11,
		'unsigned' => TRUE,
		'auto_increment' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'id_user' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'id_courses' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'amount' => array(
		'type' => 'DOUBLE',
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'document' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'status' => array(
		'type' => 'INT',
		'constraint' => '11',
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	)
);
$CI->dbforge->add_field($pagseguro_transaction_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('pagseguro_transaction', TRUE);

// INSERT pagseguro INSIDE SETTINGS TABLE

$pagseguro = array( 'key' => 'pagseguro', 'value' => '[{"active":"1","mode":"sandbox","email":"SEU_EMAIL_PAGSEGURO","token":"SEU_TOKEN_PAGSEGURO"}]' );
$CI->db->insert('settings', $pagseguro);

?>

