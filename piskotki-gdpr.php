<?php
/*
 * Plugin Name:       piskotkiGDPR
 * Plugin URI:        https://piskotki-gdpr.pakt.si/
 * Description:       Celovita rešitev piškotkov za spletne strani (pripravljeno po smernicah GDPR uredbe).
 * Version:           1.0
 * Requires at least: 6.2
 * Requires PHP:      7.2
 * Author:            Agencija Pakt d.o.o.
 * Author URI:        https://www.pakt.si/
 * License:           The MIT License
 * License URI:       https://opensource.org/licenses/MIT
 */
add_action('admin_menu', 'piskotkiGDPR_nastavitve');


// Dodajanje vtičnika piskotkiGDPR v skrbniški vmesnik WordPressa.
function piskotkiGDPR_nastavitve() {
  add_options_page(
    'piskotkiGDPR Nastavitve',
    'piskotkiGDPR',
    'manage_options',
    'piskotki-gdpr',
    'piskotkiGDPR_nastavitve_stran'
  );

  add_action('admin_init', 'piskotkiGDPR_registracija');
}


// Izbris ali posodobitev možnosti piskotkovGDPR na podlagi določene predpone ($pfx)
function piskotkiGDPR_delete() {
  $pfx = 'piskotki-gdpr';

  update_option($pfx .'-zavesa', false);
  update_option($pfx .'-barva-zavese', 'rgba(0,0,0,.3)');
  update_option($pfx .'-lokacija', 'spodaj-desno');
  update_option($pfx .'-senca-okna', '0 10px 20px 0 rgba(0,0,0,.5)');
  update_option($pfx .'-zaobljenost-okna', '20px');
  update_option($pfx .'-barva-ozadja', 'rgba(0,0,0,.7)');
  update_option($pfx .'-animacija', true);
  update_option($pfx .'-ime-strani', get_bloginfo('name'));
  update_option($pfx .'-trajanje-piskotka', 30);
  update_option($pfx .'-barva-ikone', '#fff');
  update_option($pfx .'-barva-pisave', '#fff');
  update_option($pfx .'-velikost-pisave', '14px');
  update_option($pfx .'-naslov', 'Spletno mesto uporablja piškotke');
  update_option($pfx .'-besedilo', 'S piškotki zagotavljamo boljšo uporabniško izkušnjo, enostavnejši pregled vsebin, analizo uporabe, oglasne sisteme in funkcionalnosti. S klikom na »Strinjam se« dovoljuješ vse namene obdelave. Posamezne namene lahko izbiraš na strani -');
  update_option($pfx .'-barva-povezave', '#fff');
  update_option($pfx .'-ime-povezave-pogoji', 'Nastavitve');
  update_option($pfx .'-povezava-pogoji', '/piskotki/');
  update_option($pfx .'-velikost-povezave', '14px');
  update_option($pfx .'-besedilo-gumba', 'Strinjam se');
  update_option($pfx .'-barva-gumba', '#1be195');
  update_option($pfx .'-zaobljenost-gumba', '100px');
  update_option($pfx .'-barva-gumba-povezave', 'spodaj-desno');
  update_option($pfx .'-velikost-gumba-povezave', '16px');

  wp_redirect(admin_url('options-general.php?page=piskotki-gdpr'));
  exit;
}
add_action('admin_post_piskotkiGDPR_delete', 'piskotkiGDPR_delete');


// Funkcija prikazuje stran za nastavitve piskotkovGDPR v skrbniškem vmesniku WordPressa. Vsebuje obrazec za shranjevanje sprememb nastavitev, vključno s polji za upravljanje skupine nastavitev in strani. Poleg tega se na strani prikaže tudi obrazec za ponastavitev privzetih nastavitev.
function piskotkiGDPR_nastavitve_stran() {
  ?>
  <div class="wrap">
    <h1></h1>
      <form method="post" action="options.php">
      <?php
      settings_fields('piskotki-gdpr-nastavitve'); // settings group name
      do_settings_sections('piskotki-gdpr'); // page slug
      ?>
      <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Potrdi spremembe'); ?>" />
    </form>

    <br>
    <hr>

    <p><?php echo date('Y'); ?> © <a target="_blank" href="https://www.pakt.si/">Agencija Pakt</a>. Vse pravice pridržane. <svg fill="#ccc" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><path d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z"/></svg> <a class="toggle" href="#">Privzete nastavitve vtičnika</a></p>

    <div class="default" style="display: none;">
      <br>
      <h2>Privzete nastavitve</h2>

      <!-- Privzete vrednosti -->
      <p>Nastavite okno s piškotki na privzete nastavitve:</p>
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="piskotkiGDPR_delete">
        <?php wp_nonce_field('piskotkiGDPR_delete_nonce', 'piskotkiGDPR_delete_nonce'); ?>        
        <input name="custom_button" class="button button-secondary" type="submit" value="<?php esc_attr_e('Nastavi privzete nastavitve'); ?>" />
      </form>
      <br>
    </div>

    <br>
  </div>

  <script>
    jQuery(document).ready(function($) {
      jQuery('.color').wpColorPicker();
    });

    jQuery('.toggle').click(function(e) {
      e.preventDefault();    
      jQuery('.default').toggle();
    });
  </script>

  <style>
    /* */
  </style>
  <?php
}


// Registracija skripte za barvno izbiranje (wp-color-picker) v skrbniški vmesnik WordPressa.
function piskotkiGDPR_enqueue_color_picker($hook_suffix) {
  wp_enqueue_style('wp-color-picker');
  wp_enqueue_script('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'piskotkiGDPR_enqueue_color_picker');


// Registracija skript in stilov za piskotkiGDPR iz zunanjega vira. Ta funkcija se izvede na javni strani WordPressa.
function piskotkiGDPR_skripte() {
  wp_register_script('piskotkigdpr', plugin_dir_url( __FILE__ ) .'/public/js/piskotkigdpr.min.js', array(), '0.1', false);

  // Dev
  // wp_register_script(
  //     'piskotkigdpr', 'https://cdn.jsdelivr.net/gh/agencija-pakt/piskotki-gdpr/piskotkigdpr.min.js',
  //     array(), '0.1', false);
  
  wp_enqueue_script('piskotkigdpr');

  // Dev
  // wp_enqueue_style(
  //   'piskotkigdpr', 'https://cdn.jsdelivr.net/gh/agencija-pakt/piskotki-gdpr/piskotkigdpr.min.css',
  //   array(), '0.1', 'all');

  wp_enqueue_style('piskotkigdpr', plugin_dir_url(__FILE__) .'/public/css/piskotkigdpr.min.css', array(), '0.1', 'all');
}
add_action('wp_enqueue_scripts', 'piskotkiGDPR_skripte');


// Registrirane različne sekcije in polja nastavitev, skupaj z njihovimi imeni in povezavami. Vsako polje ima tudi registrirano nastavitev.
function piskotkiGDPR_registracija() {
	$page_slug = 'piskotki-gdpr';
	$option_group = 'piskotki-gdpr-nastavitve';

  $piskotkiGDPR_nastavitve = get_option($option_group) ?: array();

  add_settings_section(
    'piskotki-gdpr-sekcija', // ID
    '', // title (optional)
    'piskotkiGDPR_nastavitve_sekcija_opis', // callback function to display the section (optional)
    $page_slug
  );

  // Zavesa
  add_settings_field(
    'piskotki-gdpr-zavesa',
    'Prikaži zaveso',
    'piskotkiGDPR_nastavitve_zavesa',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-zavesa');

  // Barva zavese
  add_settings_field(
    'piskotki-gdpr-barva-zavese',
    'Barva zavese',
    'piskotkiGDPR_nastavitve_barva_zavese',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-barva-zavese');

  // Lokacija
  add_settings_field(
    'piskotki-gdpr-lokacija',
    'Lokacija',
    'piskotkiGDPR_nastavitve_lokacija',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-lokacija');

  // Senca okna
  add_settings_field(
    'piskotki-gdpr-senca-okna',
    'Senca okna',
    'piskotkiGDPR_nastavitve_senca_okna',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-senca-okna');

  // Zaobljenost okna
  add_settings_field(
    'piskotki-gdpr-zaobljenost-okna',
    'Zaobljenost okna',
    'piskotkiGDPR_nastavitve_zaobljenost_okna',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-zaobljenost-okna');

  // Barva ozadja
  add_settings_field(
    'piskotki-gdpr-barva-ozadja',
    'Barva ozadja',
    'piskotkiGDPR_nastavitve_barva_ozadja',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-barva-ozadja');

  // Animacija
  add_settings_field(
    'piskotki-gdpr-animacija',
    'Animacija',
    'piskotkiGDPR_nastavitve_animacija',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-animacija');

  // Ime strani
  add_settings_field(
    'piskotki-gdpr-ime-strani',
    'Ime Strani',
    'piskotkiGDPR_nastavitve_ime_strani',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-ime-strani');

  // Trajanje piškotka
  add_settings_field(
    'piskotki-gdpr-trajanje-piskotka',
    'Trajanje Piskotka',
    'piskotkiGDPR_nastavitve_trajanje_piskotka',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-trajanje-piskotka');

  // Barva ikone
  add_settings_field(
    'piskotki-gdpr-barva-ikone',
    'Barva Ikone',
    'piskotkiGDPR_nastavitve_barva_ikone',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-barva-ikone');

  // Barva pisave
  add_settings_field(
    'piskotki-gdpr-barva-pisave',
    'Barva Pisave',
    'piskotkiGDPR_nastavitve_barva_pisave',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-barva-pisave');

  // Veliksot povezave
  add_settings_field(
    'piskotki-gdpr-velikost-pisave',
    'Velikost Pisave',
    'piskotkiGDPR_nastavitve_velikost_pisave',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-velikost-pisave');

  // Naslov
  add_settings_field(
    'piskotki-gdpr-naslov',
    'Naslov',
    'piskotkiGDPR_nastavitve_naslov',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-naslov');

  // Besedilo
  add_settings_field(
    'piskotki-gdpr-besedilo',
    'Besedilo',
    'piskotkiGDPR_nastavitve_besedilo',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-besedilo');

  // Barva povezave
  add_settings_field(
    'piskotki-gdpr-barva-povezave',
    'Barva povezave',
    'piskotkiGDPR_nastavitve_barva_povezave',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-barva-povezave');

  // Ime povezave pogoji
  add_settings_field(
    'piskotki-gdpr-ime-povezave-pogoji',
    'Ime povezave pogoji',
    'piskotkiGDPR_nastavitve_ime_povezave_pogoji',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-ime-povezave-pogoji');

  // Povezava pogoji
  add_settings_field(
    'piskotki-gdpr-povezava-pogoji',
    'Povezava Pogoji',
    'piskotkiGDPR_nastavitve_povezava_pogoji',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-povezava-pogoji');

  // Veliksot povezave
  add_settings_field(
    'piskotki-gdpr-velikost-povezave',
    'Velikost povezave',
    'piskotkiGDPR_nastavitve_velikost_povezave',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-velikost-povezave');

  // Besedilo gumba
  add_settings_field(
    'piskotki-gdpr-besedilo-gumba',
    'Besedilo gumba',
    'piskotkiGDPR_nastavitve_besedilo_gumba',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-besedilo-gumba');

  // Barva gumba
  add_settings_field(
    'piskotki-gdpr-barva-gumba',
    'Barva gumba',
    'piskotkiGDPR_nastavitve_barva_gumba',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-barva-gumba');

  // Zaobljenost gumba
  add_settings_field(
    'piskotki-gdpr-zaobljenost-gumba',
    'Zaobljenost gumba',
    'piskotkiGDPR_nastavitve_zaobljenost_gumba',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-zaobljenost-gumba');

  // Barva gumba povezave
  add_settings_field(
    'piskotki-gdpr-barva-gumba-povezave',
    'Barva gumba povezave',
    'piskotkiGDPR_nastavitve_barva_gumba_povezave',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-barva-gumba-povezave');

  // Velikost gumba povezave
  add_settings_field(
    'piskotki-gdpr-velikost-gumba-povezave',
    'Velikost gumba povezave',
    'piskotkiGDPR_nastavitve_velikost_gumba_povezave',
    $page_slug,
    'piskotki-gdpr-sekcija'
  );
  register_setting($option_group, 'piskotki-gdpr-velikost-gumba-povezave');
}


// Prikaz opisa sekcije na strani nastavitev piskotkovGDPR
function piskotkiGDPR_nastavitve_sekcija_opis() {
  echo '
  <br>
  <img style="margin: 0 auto; max-width: 285px;" loading="lazy" src="'. plugin_dir_url(__FILE__) .'admin/images/piskotkigdpr.png?v=1" alt="Piškotki GDPR logo" width="285">
  <p>Celovita rešitev piškotkov za spletne strani (pripravljeno po smernicah GDPR uredbe).</p>
  <p>Za več informacij o <strong>nastavitvah vtičnika</strong> in <strong>omejevanju piškotkov</strong> obiščite uradno spletno stran vtičnika - <a target="_blank" href="https://piskotki-gdpr.pakt.si/">piskotki-gdpr.pakt.si</a>.<br>
  <i>Tam boste našli tudi pripravljena besedila za strani: <code>pogoje uporabe</code>, <code>zasebnost</code> in <code>piškotke</code>, ki so profesionalno oblikovana in skladna z zakonodajo</i>.</p>
  <br>
  <hr>
  ';
}


// Polja vnosa in izpisa nastavitev vtičnika
function piskotkiGDPR_nastavitve_zavesa() {
  $zavesa = get_option('piskotki-gdpr-zavesa') ?: 0;
  ?>
  <input type="checkbox" id="zaveta" name="piskotki-gdpr-zavesa" value="1" <?php checked($zavesa, 1); ?>>
  <p class="description" id="tagline-description">Zavesa zasenči celotno stran in izpostavi okno s piškotki.</p>
  <?php
}

function piskotkiGDPR_nastavitve_barva_zavese() {
  $barva_zavese = get_option('piskotki-gdpr-barva-zavese') ?: 'rgba(0,0,0,.3)';
  ?>
  <input type="text" class="color" name="piskotki-gdpr-barva-zavese" value="<?php echo esc_attr($barva_zavese); ?>">
  <p class="description" id="tagline-description">Izberite barvo zavese, če je zavesa omogočena (priporočano prosojnost).</p>
  <?php
}

function piskotkiGDPR_nastavitve_lokacija() {
  $lokacija = get_option('piskotki-gdpr-lokacija') ?: 'spodaj-desno';
  ?>
  <select name="piskotki-gdpr-lokacija">
    <option value="zgoraj-levo" <?php selected($lokacija, 'zgoraj-levo'); ?>>Zgoraj levo</option>
    <option value="zgoraj" <?php selected($lokacija, 'zgoraj'); ?>>Zgoraj</option>
    <option value="zgoraj-desno" <?php selected($lokacija, 'zgoraj-desno'); ?>>Zgoraj desno</option>
    <option value="desno" <?php selected($lokacija, 'desno'); ?>>Desno</option>
    <option value="spodaj-desno" <?php selected($lokacija, 'spodaj-desno'); ?>>Spodaj desno</option>
    <option value="spodaj" <?php selected($lokacija, 'spodaj'); ?>>Spodaj</option>
    <option value="spodaj-levo" <?php selected($lokacija, 'spodaj-levo'); ?>>Spodaj levo</option>
    <option value="levo" <?php selected($lokacija, 'levo'); ?>>Levo</option>
  </select>
  <p class="description" id="tagline-description">Lokacija okna na zaslonu.</p>
  <?php
}

function piskotkiGDPR_nastavitve_senca_okna() {
  $senca_okna = get_option('piskotki-gdpr-senca-okna') ?: '0 10px 20px 0 rgba(0,0,0,.15)';
  ?>
  <input type="text" class="regular-text" name="piskotki-gdpr-senca-okna" value="<?php echo esc_attr($senca_okna); ?>">
  <p class="description" id="tagline-description">Senca okna - prvi del pozicija, drugi del barva (<a target="_blank" href="https://shorturl.at/rAHYZ">Orodje</a>).</p>
  <?php
}


function piskotkiGDPR_nastavitve_zaobljenost_okna() {
  $zaobljenost_okna = get_option('piskotki-gdpr-zaobljenost-okna') ?: '20px';
  ?>
  <input type="text" class="regular-text" name="piskotki-gdpr-zaobljenost-okna" value="<?php echo esc_attr($zaobljenost_okna); ?>">
  <p class="description" id="tagline-description">Kako močno želite zaobljeno obliko (zaobljenost robov) okna?</p>
  <?php
}

function piskotkiGDPR_nastavitve_barva_ozadja() {
  $barva_ozadja = get_option('piskotki-gdpr-barva-ozadja') ?: 'rgba(0,0,0,.7)';
  ?>
  <input type="text" class="color" name="piskotki-gdpr-barva-ozadja" value="<?php echo esc_attr($barva_ozadja); ?>">
  <p class="description" id="tagline-description">Kakšna barva želite, da je okno?</p>
  <?php
}

function piskotkiGDPR_nastavitve_animacija() {
  $animacija = get_option('piskotki-gdpr-animacija') ?: 0;
  ?>
  <input type="checkbox" name="piskotki-gdpr-animacija" value="1" <?php checked($animacija, 1); ?> />
  <p class="description" id="tagline-description">Animacija za večjo izpostavljenost okna <i>(deluje samo na robovih strani - lokacija)</i>.
</p>
  <?php
}

function piskotkiGDPR_nastavitve_ime_strani() {
  $ime_strani = get_option('piskotki-gdpr-ime-strani') ?: parse_url(get_site_url(), PHP_URL_HOST);
  ?>
  <input type="text" name="piskotki-gdpr-ime-strani" value="<?php echo esc_attr($ime_strani); ?>">
  <p class="description" id="tagline-description">Ime vaše strani (npr. povezava.si).</p>
  <?php
}

function piskotkiGDPR_nastavitve_trajanje_piskotka() {
  $trajanje_piskotka = get_option('piskotki-gdpr-trajanje-piskotka') ?: '30';
  ?>
  <input type="number" min="1" name="piskotki-gdpr-trajanje-piskotka" value="<?php echo esc_attr($trajanje_piskotka); ?>">
  <p class="description" id="tagline-description">Trajanje zapadlosti piškotkov (v dneh).</p>
  <?php
}

function piskotkiGDPR_nastavitve_barva_ikone() {
  $barva_ikone = get_option('piskotki-gdpr-barva-ikone') ?: '#fff';
  ?>
  <input type="text" class="color" name="piskotki-gdpr-barva-ikone" value="<?php echo esc_attr($barva_ikone); ?>">
  <p class="description" id="tagline-description">Barva ikone (piškot) v oknu.</p>
  <?php
}

function piskotkiGDPR_nastavitve_barva_pisave() {
  $barva_pisave = get_option('piskotki-gdpr-barva-pisave') ?: '#fff';
  ?>
  <input type="text" class="color" name="piskotki-gdpr-barva-pisave" value="<?php echo esc_attr($barva_pisave); ?>">
  <p class="description" id="tagline-description">Barva besedil v oknu.</p>
  <?php
}

function piskotkiGDPR_nastavitve_velikost_pisave() {
  $velikost_pisave = get_option('piskotki-gdpr-velikost-pisave') ?: '14px';
  ?>
  <input type="text" name="piskotki-gdpr-velikost-pisave" value="<?php echo esc_attr($velikost_pisave); ?>">
  <p class="description" id="tagline-description">Velikost besedil v oknu (v pikslih).</p>
  <?php
}

function piskotkiGDPR_nastavitve_naslov() {
  $naslov = get_option('piskotki-gdpr-naslov') ?: 'Spletno mesto uporablja piškotke';
  ?>
  <input type="text" name="piskotki-gdpr-naslov" value="<?php echo esc_attr($naslov); ?>">
  <p class="description" id="tagline-description">Besedilo glavnega naslova v oknu.</p>
  <?php
}

function piskotkiGDPR_nastavitve_besedilo() {
  $besedilo = get_option('piskotki-gdpr-besedilo') ?: 'S piškotki zagotavljamo boljšo uporabniško izkušnjo, enostavnejši pregled vsebin, analizo uporabe, oglasne sisteme in funkcionalnosti. S klikom na »Strinjam se« dovoljuješ vse namene obdelave. Posamezne namene lahko izbiraš na strani - ';
  ?>
  <textarea name="piskotki-gdpr-besedilo"><?php echo esc_textarea($besedilo); ?></textarea>
  <p class="description" id="tagline-description">Podporno besedilo v oknu.</p>
  <?php
}

function piskotkiGDPR_nastavitve_barva_povezave() {
  $barva_povezave = get_option('piskotki-gdpr-barva-povezave') ?: '#fff';
  ?>
  <input type="text" class="color" name="piskotki-gdpr-barva-povezave" value="<?php echo esc_attr($barva_povezave); ?>">
  <p class="description" id="tagline-description">Barva povezave, ki pelje na splošne pogoje o piškotkih.</p>
  <?php
}

function piskotkiGDPR_nastavitve_ime_povezave_pogoji() {
  $ime_povezave_pogoji = get_option('piskotki-gdpr-ime-povezave-pogoji') ?: 'Nastavitve';
  ?>
  <input type="text" name="piskotki-gdpr-ime-povezave-pogoji" value="<?php echo esc_attr($ime_povezave_pogoji); ?>">
  <p class="description" id="tagline-description">Besedilo povezave, ki pelje na splošne pogoje o piškotkih.</p>
  <?php
}

function piskotkiGDPR_nastavitve_povezava_pogoji() {
  $povezava_pogoji = get_option('piskotki-gdpr-povezava-pogoji') ?: '/piskotki/';
  ?>
  <input type="text" name="piskotki-gdpr-povezava-pogoji" value="<?php echo esc_attr($povezava_pogoji); ?>">
  <p class="description" id="tagline-description">Povezava do splošnih pogojev - piškotki.</p>
  <?php
}

function piskotkiGDPR_nastavitve_velikost_povezave() {
  $velikost_povezave = get_option('piskotki-gdpr-velikost-povezave') ?: '14px';
  ?>
  <input type="text" name="piskotki-gdpr-velikost-povezave" value="<?php echo esc_attr($velikost_povezave); ?>">
  <p class="description" id="tagline-description">Velikost povezave, ki pelje na splošne pogoje o piškotkih (v pikslih).</p>
  <?php
}

function piskotkiGDPR_nastavitve_besedilo_gumba() {
  $besedilo_gumba = get_option('piskotki-gdpr-besedilo-gumba') ?: 'Strinjam se';
  ?>
  <input type="text" name="piskotki-gdpr-besedilo-gumba" value="<?php echo esc_attr($besedilo_gumba); ?>">
  <p class="description" id="tagline-description">Besedilo na gumbu (se strinjam).</p>
  <?php
}

function piskotkiGDPR_nastavitve_barva_gumba() {
  $barva_gumba = get_option('piskotki-gdpr-barva-gumba') ?: '#1be195';
  ?>
  <input type="text" class="color" name="piskotki-gdpr-barva-gumba" value="<?php echo esc_attr($barva_gumba); ?>">
  <p class="description" id="tagline-description">Barva gumba.</p>
  <?php
}

function piskotkiGDPR_nastavitve_zaobljenost_gumba() {
  $zaobljenost_gumba = get_option('piskotki-gdpr-zaobljenost-gumba') ?: '100px';
  ?>
  <input type="text" name="piskotki-gdpr-zaobljenost-gumba" value="<?php echo esc_attr($zaobljenost_gumba); ?>">
  <p class="description" id="tagline-description">Kako močno želite zaobljeno obliko (zaobljenost robov) gumba?</p>
  <?php
}

function piskotkiGDPR_nastavitve_barva_gumba_povezave() {
  $barva_gumba_povezave = get_option('piskotki-gdpr-barva-gumba-povezave') ?: '#4c4c4c';
  ?>
  <input type="text" class="color" name="piskotki-gdpr-barva-gumba-povezave" value="<?php echo esc_attr($barva_gumba_povezave); ?>">
  <p class="description" id="tagline-description">Barva besedila na gumbu.</p>
  <?php
}

function piskotkiGDPR_nastavitve_velikost_gumba_povezave() {
  $velikost_gumba_povezave = get_option('piskotki-gdpr-velikost-gumba-povezave') ?: '16px';
  ?>
  <input type="text" name="piskotki-gdpr-velikost-gumba-povezave" value="<?php echo esc_attr($velikost_gumba_povezave); ?>">
  <p class="description" id="tagline-description">Velikost besedila na gumbu (v pikslih).</p>
  <?php
}


// Prenos nastavitev Wordpress -> Vtičnik
function piskotkiGDPR_script() {
  ?>
  <script>
    /* Nastavitve vtičnika piskotkiGDPR */
    piskotkiGDPR({
      zavesa: <?php echo (get_option('piskotki-gdpr-zavesa') == '1') ? 'true' : 'false'; ?>,
      barvaZavese: '<?php echo esc_js(get_option('piskotki-gdpr-barva-zavese', 'rgba(0,0,0,.3)')); ?>',
      lokacija: '<?php echo esc_js(get_option('piskotki-gdpr-lokacija', 'spodaj-desno')); ?>',
      sencaOkna: '<?php echo esc_js(get_option('piskotki-gdpr-senca-okna', '0 10px 20px 0 rgba(0,0,0,.15)')); ?>',
      zaobljenostOkna: '<?php echo esc_js(get_option('piskotki-gdpr-zaobljenost-okna', '20px')); ?>',
      barvaOzadja: '<?php echo esc_js(get_option('piskotki-gdpr-barva-ozadja', 'rgba(0,0,0,.7)')); ?>',
      animacija: <?php echo (get_option('piskotki-gdpr-animacija') == '1') ? 'true' : 'false'; ?>,
      imeStrani: '<?php echo esc_js(get_option('piskotki-gdpr-ime-strani', get_bloginfo('name'))); ?>',
      trajanjePiskotka: '<?php echo esc_js(get_option('piskotki-gdpr-trajanje-piskotka', '30')); ?>',
      barvaIkone: '<?php echo esc_js(get_option('piskotki-gdpr-barva-ikone', '#fff')); ?>',
      barvaPisave: '<?php echo esc_js(get_option('piskotki-gdpr-barva-pisave', '#fff')); ?>',
      velikostPisave: '<?php echo esc_js(get_option('piskotki-gdpr-velikost-pisave', '16')); ?>',
      naslov: '<?php echo esc_js(get_option('piskotki-gdpr-naslov', 'Spletno mesto uporablja piškotke')); ?>',
      besedilo: '<?php echo esc_js(get_option('piskotki-gdpr-besedilo', 'S piškotki zagotavljamo boljšo uporabniško izkušnjo, enostavnejši pregled vsebin, analizo uporabe, oglasne sisteme in funkcionalnosti. S klikom na »Strinjam se« dovoljuješ vse namene obdelave. Posamezne namene lahko izbiraš na strani - ')); ?>',
      barvaPovezave: '<?php echo esc_js(get_option('piskotki-gdpr-barva-povezave', '#fff')); ?>',
      imePovezavePogoji: '<?php echo esc_js(get_option('piskotki-gdpr-ime-povezave-pogoji', 'Nastavitve')); ?>',
      povezavaPogoji: '<?php echo esc_js(get_option('piskotki-gdpr-povezava-pogoji', '/piskotki/')); ?>',
      velikostPovezave: '<?php echo esc_js(get_option('piskotki-gdpr-velikost-povezave', '14px')); ?>',
      besediloGumba: '<?php echo esc_js(get_option('piskotki-gdpr-besedilo-gumba', 'Strinjam se')); ?>',
      barvaGumba: '<?php echo esc_js(get_option('piskotki-gdpr-barva-gumba', '#1be195')); ?>',
      zaobljenostGumba: '<?php echo esc_js(get_option('piskotki-gdpr-zaobljenost-gumba', '100px')); ?>',
      barvaGumbaPovezave: '<?php echo esc_js(get_option('piskotki-gdpr-barva-gumba-povezave', '#4c4c4c')); ?>',
      velikostGumbaPovezave: '<?php echo esc_js(get_option('piskotki-gdpr-velikost-gumba-povezave', '16px')); ?>'
    });
  </script>
  <?php
}
add_action('wp_footer', 'piskotkiGDPR_script');
