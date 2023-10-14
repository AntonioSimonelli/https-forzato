<?php
/**
* Plugin Name: HTTPS Forzato
* Description: Il plugin impone all'utente l'uso del protocollo https.
* Version: 0.1
* Author: Antonio Simonelli
* Author URI: http://digilander.libero.it/a.simonelli
**/

function hf_forza(){
	$scheme = $_SERVER['REQUEST_SCHEME'];
	$hf_url = "https://".$_SERVER['SERVER_NAME'];
	$options = get_option( 'hf_opzioni' );
	if(isset($options['hf_url']))$hf_url = $options['hf_url'];
	if($scheme == "http"){
		//header("location: $hf_url");
		echo "<script>window.location='{$options['hf_url']}'</script>";
	}
}
add_action("init", "hf_forza");
do_action('hf_forza');

function hf_aggiungi_pagina_impostazioni() {
    add_options_page( 'HTTPS Forzato', 'HTTPS Forzato', 'manage_options', 'https-forzato', 'hf_pagina_impostazioni' );
}
add_action( 'admin_menu', 'hf_aggiungi_pagina_impostazioni' );

function hf_pagina_impostazioni(){
	?>
	<form action=options.php method=post>
	<?php
	settings_fields( 'hf_opzioni' );
    do_settings_sections( 'hf_plugin' ); ?>
	<input class="button button-primary" type=submit value=Salva>
	</form>
	<?php
}

function hf_registra_impostazioni(){
	register_setting( 'hf_opzioni', 'hf_opzioni', 'hf_opzioni_validazione' );
    add_settings_section( 'hf_sezione', 'Pagina di reindirizzamento', 'hf_sezione_titolo', 'hf_plugin' );
	add_settings_field( 'hf_url', 'Indirizzo', 'hf_url', 'hf_plugin', 'hf_sezione' );	
}
add_action( 'admin_init', 'hf_registra_impostazioni' );

function hf_sezione_titolo(){
	echo "Inserire l'indirizzo di reindirizzamento";
}

function hf_url(){
    $options = get_option( 'hf_opzioni' );
    echo "<input id='hf_url' name='hf_opzioni[hf_url]' type='text' value='" . esc_attr( $options['hf_url'] ) . "' />";
}