<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
  die;
}

$pfx = 'piskotki-gdpr';
delete_option($pfx);

delete_option($pfx .'-zavesa');
delete_option($pfx .'-barva-zavese');
delete_option($pfx .'-lokacija');
delete_option($pfx .'-senca-okna');
delete_option($pfx .'-zaobljenost-okna');
delete_option($pfx .'-barva-ozadja');
delete_option($pfx .'-animacija');
delete_option($pfx .'-ime-strani');
delete_option($pfx .'-trajanje-piskotka');
delete_option($pfx .'-barva-ikone');
delete_option($pfx .'-barva-pisave');
delete_option($pfx .'-velikost-pisave');
delete_option($pfx .'-naslov');
delete_option($pfx .'-besedilo');
delete_option($pfx .'-barva-povezave');
delete_option($pfx .'-ime-povezave-pogoji');
delete_option($pfx .'-povezava-pogoji');
delete_option($pfx .'-velikost-povezave');
delete_option($pfx .'-besedilo-gumba');
delete_option($pfx .'-barva-gumba');
delete_option($pfx .'-zaobljenost-gumba');
delete_option($pfx .'-barva-gumba-povezave');
delete_option($pfx .'-velikost-gumba-povezave');