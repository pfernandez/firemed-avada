<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories = array();  
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp = array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$functionof_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');
		if($of_pages_obj):
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");
		endif;
		
		//Testing 
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = STYLESHEETPATH. '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_bloginfo('template_url').'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 

		$font_sizes = array(
			'10' => '10',
			'11' => '11',
			'12' => '12',
			'13' => '13',
			'14' => '14',
			'15' => '15',
			'16' => '16',
			'17' => '17',
			'18' => '18',
			'19' => '19',
			'20' => '20',
			'21' => '21',
			'22' => '22',
			'23' => '23',
			'24' => '24',
			'25' => '25',
			'26' => '26',
			'27' => '27',
			'28' => '28',
			'29' => '29',
			'30' => '30',
			'31' => '31',
			'32' => '32',
			'33' => '33',
			'34' => '34',
			'35' => '35',
			'36' => '36',
			'37' => '37',
			'38' => '38',
			'39' => '39',
			'40' => '40',
			'41' => '41',
			'42' => '42',
		);

	$google_fonts = array(
							"0" => "Select Font",
							"Abel" => "Abel",
							"Abril Fatface" => "Abril Fatface",
							"Aclonica" => "Aclonica",
							"Acme" => "Acme",
							"Actor" => "Actor",
							"Adamina" => "Adamina",
							"Advent Pro" => "Advent Pro",
							"Aguafina Script" => "Aguafina Script",
							"Aladin" => "Aladin",
							"Aldrich" => "Aldrich",
							"Alegreya" => "Alegreya",
							"Alegreya SC" => "Alegreya SC",
							"Alex Brush" => "Alex Brush",
							"Alfa Slab One" => "Alfa Slab One",
							"Alice" => "Alice",
							"Alike" => "Alike",
							"Alike Angular" => "Alike Angular",
							"Allan" => "Allan",
							"Allerta" => "Allerta",
							"Allerta Stencil" => "Allerta Stencil",
							"Allura" => "Allura",
							"Almendra" => "Almendra",
							"Almendra SC" => "Almendra SC",
							"Amaranth" => "Amaranth",
							"Amatic SC" => "Amatic SC",
							"Amethysta" => "Amethysta",
							"Andada" => "Andada",
							"Andika" => "Andika",
							"Angkor" => "Angkor",
							"Annie Use Your Telescope" => "Annie Use Your Telescope",
							"Anonymous Pro" => "Anonymous Pro",
							"Antic" => "Antic",
							"Antic Didone" => "Antic Didone",
							"Antic Slab" => "Antic Slab",
							"Anton" => "Anton",
							"Arapey" => "Arapey",
							"Arbutus" => "Arbutus",
							"Architects Daughter" => "Architects Daughter",
							"Arimo" => "Arimo",
							"Arizonia" => "Arizonia",
							"Armata" => "Armata",
							"Artifika" => "Artifika",
							"Arvo" => "Arvo",
							"Asap" => "Asap",
							"Asset" => "Asset",
							"Astloch" => "Astloch",
							"Asul" => "Asul",
							"Atomic Age" => "Atomic Age",
							"Aubrey" => "Aubrey",
							"Audiowide" => "Audiowide",
							"Average" => "Average",
							"Averia Gruesa Libre" => "Averia Gruesa Libre",
							"Averia Libre" => "Averia Libre",
							"Averia Sans Libre" => "Averia Sans Libre",
							"Averia Serif Libre" => "Averia Serif Libre",
							"Bad Script" => "Bad Script",
							"Balthazar" => "Balthazar",
							"Bangers" => "Bangers",
							"Basic" => "Basic",
							"Battambang" => "Battambang",
							"Baumans" => "Baumans",
							"Bayon" => "Bayon",
							"Belgrano" => "Belgrano",
							"Belleza" => "Belleza",
							"Bentham" => "Bentham",
							"Berkshire Swash" => "Berkshire Swash",
							"Bevan" => "Bevan",
							"Bigshot One" => "Bigshot One",
							"Bilbo" => "Bilbo",
							"Bilbo Swash Caps" => "Bilbo Swash Caps",
							"Bitter" => "Bitter",
							"Black Ops One" => "Black Ops One",
							"Bokor" => "Bokor",
							"Bonbon" => "Bonbon",
							"Boogaloo" => "Boogaloo",
							"Bowlby One" => "Bowlby One",
							"Bowlby One SC" => "Bowlby One SC",
							"Brawler" => "Brawler",
							"Bree Serif" => "Bree Serif",
							"Bubblegum Sans" => "Bubblegum Sans",
							"Buda" => "Buda",
							"Buenard" => "Buenard",
							"Butcherman" => "Butcherman",
							"Butterfly Kids" => "Butterfly Kids",
							"Cabin" => "Cabin",
							"Cabin Condensed" => "Cabin Condensed",
							"Cabin Sketch" => "Cabin Sketch",
							"Caesar Dressing" => "Caesar Dressing",
							"Cagliostro" => "Cagliostro",
							"Calligraffitti" => "Calligraffitti",
							"Cambo" => "Cambo",
							"Candal" => "Candal",
							"Cantarell" => "Cantarell",
							"Cantata One" => "Cantata One",
							"Cardo" => "Cardo",
							"Carme" => "Carme",
							"Carter One" => "Carter One",
							"Caudex" => "Caudex",
							"Cedarville Cursive" => "Cedarville Cursive",
							"Ceviche One" => "Ceviche One",
							"Changa One" => "Changa One",
							"Chango" => "Chango",
							"Chau Philomene One" => "Chau Philomene One",
							"Chelsea Market" => "Chelsea Market",
							"Chenla" => "Chenla",
							"Cherry Cream Soda" => "Cherry Cream Soda",
							"Chewy" => "Chewy",
							"Chicle" => "Chicle",
							"Chivo" => "Chivo",
							"Coda" => "Coda",
							"Coda Caption" => "Coda Caption",
							"Codystar" => "Codystar",
							"Comfortaa" => "Comfortaa",
							"Coming Soon" => "Coming Soon",
							"Concert One" => "Concert One",
							"Condiment" => "Condiment",
							"Content" => "Content",
							"Contrail One" => "Contrail One",
							"Convergence" => "Convergence",
							"Cookie" => "Cookie",
							"Copse" => "Copse",
							"Corben" => "Corben",
							"Cousine" => "Cousine",
							"Coustard" => "Coustard",
							"Covered By Your Grace" => "Covered By Your Grace",
							"Crafty Girls" => "Crafty Girls",
							"Creepster" => "Creepster",
							"Crete Round" => "Crete Round",
							"Crimson Text" => "Crimson Text",
							"Crushed" => "Crushed",
							"Cuprum" => "Cuprum",
							"Cutive" => "Cutive",
							"Damion" => "Damion",
							"Dancing Script" => "Dancing Script",
							"Dangrek" => "Dangrek",
							"Dawning of a New Day" => "Dawning of a New Day",
							"Days One" => "Days One",
							"Delius" => "Delius",
							"Delius Swash Caps" => "Delius Swash Caps",
							"Delius Unicase" => "Delius Unicase",
							"Della Respira" => "Della Respira",
							"Devonshire" => "Devonshire",
							"Didact Gothic" => "Didact Gothic",
							"Diplomata" => "Diplomata",
							"Diplomata SC" => "Diplomata SC",
							"Doppio One" => "Doppio One",
							"Dorsa" => "Dorsa",
							"Dosis" => "Dosis",
							"Dr Sugiyama" => "Dr Sugiyama",
							"Droid Sans" => "Droid Sans",
							"Droid Sans Mono" => "Droid Sans Mono",
							"Droid Serif" => "Droid Serif",
							"Duru Sans" => "Duru Sans",
							"Dynalight" => "Dynalight",
							"EB Garamond" => "EB Garamond",
							"Eater" => "Eater",
							"Economica" => "Economica",
							"Electrolize" => "Electrolize",
							"Emblema One" => "Emblema One",
							"Emilys Candy" => "Emilys Candy",
							"Engagement" => "Engagement",
							"Enriqueta" => "Enriqueta",
							"Erica One" => "Erica One",
							"Esteban" => "Esteban",
							"Euphoria Script" => "Euphoria Script",
							"Ewert" => "Ewert",
							"Exo" => "Exo",
							"Expletus Sans" => "Expletus Sans",
							"Fanwood Text" => "Fanwood Text",
							"Fascinate" => "Fascinate",
							"Fascinate Inline" => "Fascinate Inline",
							"Federant" => "Federant",
							"Federo" => "Federo",
							"Felipa" => "Felipa",
							"Fjord One" => "Fjord One",
							"Flamenco" => "Flamenco",
							"Flavors" => "Flavors",
							"Fondamento" => "Fondamento",
							"Fontdiner Swanky" => "Fontdiner Swanky",
							"Forum" => "Forum",
							"Francois One" => "Francois One",
							"Fredericka the Great" => "Fredericka the Great",
							"Fredoka One" => "Fredoka One",
							"Freehand" => "Freehand",
							"Fresca" => "Fresca",
							"Frijole" => "Frijole",
							"Fugaz One" => "Fugaz One",
							"GFS Didot" => "GFS Didot",
							"GFS Neohellenic" => "GFS Neohellenic",
							"Galdeano" => "Galdeano",
							"Gentium Basic" => "Gentium Basic",
							"Gentium Book Basic" => "Gentium Book Basic",
							"Geo" => "Geo",
							"Geostar" => "Geostar",
							"Geostar Fill" => "Geostar Fill",
							"Germania One" => "Germania One",
							"Give You Glory" => "Give You Glory",
							"Glass Antiqua" => "Glass Antiqua",
							"Glegoo" => "Glegoo",
							"Gloria Hallelujah" => "Gloria Hallelujah",
							"Goblin One" => "Goblin One",
							"Gochi Hand" => "Gochi Hand",
							"Gorditas" => "Gorditas",
							"Goudy Bookletter 1911" => "Goudy Bookletter 1911",
							"Graduate" => "Graduate",
							"Gravitas One" => "Gravitas One",
							"Great Vibes" => "Great Vibes",
							"Gruppo" => "Gruppo",
							"Gudea" => "Gudea",
							"Habibi" => "Habibi",
							"Hammersmith One" => "Hammersmith One",
							"Handlee" => "Handlee",
							"Hanuman" => "Hanuman",
							"Happy Monkey" => "Happy Monkey",
							"Henny Penny" => "Henny Penny",
							"Herr Von Muellerhoff" => "Herr Von Muellerhoff",
							"Holtwood One SC" => "Holtwood One SC",
							"Homemade Apple" => "Homemade Apple",
							"Homenaje" => "Homenaje",
							"IM Fell DW Pica" => "IM Fell DW Pica",
							"IM Fell DW Pica SC" => "IM Fell DW Pica SC",
							"IM Fell Double Pica" => "IM Fell Double Pica",
							"IM Fell Double Pica SC" => "IM Fell Double Pica SC",
							"IM Fell English" => "IM Fell English",
							"IM Fell English SC" => "IM Fell English SC",
							"IM Fell French Canon" => "IM Fell French Canon",
							"IM Fell French Canon SC" => "IM Fell French Canon SC",
							"IM Fell Great Primer" => "IM Fell Great Primer",
							"IM Fell Great Primer SC" => "IM Fell Great Primer SC",
							"Iceberg" => "Iceberg",
							"Iceland" => "Iceland",
							"Imprima" => "Imprima",
							"Inconsolata" => "Inconsolata",
							"Inder" => "Inder",
							"Indie Flower" => "Indie Flower",
							"Inika" => "Inika",
							"Irish Grover" => "Irish Grover",
							"Istok Web" => "Istok Web",
							"Italiana" => "Italiana",
							"Italianno" => "Italianno",
							"Jim Nightshade" => "Jim Nightshade",
							"Jockey One" => "Jockey One",
							"Jolly Lodger" => "Jolly Lodger",
							"Josefin Sans" => "Josefin Sans",
							"Josefin Slab" => "Josefin Slab",
							"Judson" => "Judson",
							"Julee" => "Julee",
							"Junge" => "Junge",
							"Jura" => "Jura",
							"Just Another Hand" => "Just Another Hand",
							"Just Me Again Down Here" => "Just Me Again Down Here",
							"Kameron" => "Kameron",
							"Karla" => "Karla",
							"Kaushan Script" => "Kaushan Script",
							"Kelly Slab" => "Kelly Slab",
							"Kenia" => "Kenia",
							"Khmer" => "Khmer",
							"Knewave" => "Knewave",
							"Kotta One" => "Kotta One",
							"Koulen" => "Koulen",
							"Kranky" => "Kranky",
							"Kreon" => "Kreon",
							"Kristi" => "Kristi",
							"Krona One" => "Krona One",
							"La Belle Aurore" => "La Belle Aurore",
							"Lancelot" => "Lancelot",
							"Lato" => "Lato",
							"League Script" => "League Script",
							"Leckerli One" => "Leckerli One",
							"Ledger" => "Ledger",
							"Lekton" => "Lekton",
							"Lemon" => "Lemon",
							"Lilita One" => "Lilita One",
							"Limelight" => "Limelight",
							"Linden Hill" => "Linden Hill",
							"Lobster" => "Lobster",
							"Lobster Two" => "Lobster Two",
							"Londrina Outline" => "Londrina Outline",
							"Londrina Shadow" => "Londrina Shadow",
							"Londrina Sketch" => "Londrina Sketch",
							"Londrina Solid" => "Londrina Solid",
							"Lora" => "Lora",
							"Love Ya Like A Sister" => "Love Ya Like A Sister",
							"Loved by the King" => "Loved by the King",
							"Lovers Quarrel" => "Lovers Quarrel",
							"Luckiest Guy" => "Luckiest Guy",
							"Lusitana" => "Lusitana",
							"Lustria" => "Lustria",
							"Macondo" => "Macondo",
							"Macondo Swash Caps" => "Macondo Swash Caps",
							"Magra" => "Magra",
							"Maiden Orange" => "Maiden Orange",
							"Mako" => "Mako",
							"Marck Script" => "Marck Script",
							"Marko One" => "Marko One",
							"Marmelad" => "Marmelad",
							"Marvel" => "Marvel",
							"Mate" => "Mate",
							"Mate SC" => "Mate SC",
							"Maven Pro" => "Maven Pro",
							"Meddon" => "Meddon",
							"MedievalSharp" => "MedievalSharp",
							"Medula One" => "Medula One",
							"Megrim" => "Megrim",
							"Merienda One" => "Merienda One",
							"Merriweather" => "Merriweather",
							"Metal" => "Metal",
							"Metamorphous" => "Metamorphous",
							"Metrophobic" => "Metrophobic",
							"Michroma" => "Michroma",
							"Miltonian" => "Miltonian",
							"Miltonian Tattoo" => "Miltonian Tattoo",
							"Miniver" => "Miniver",
							"Miss Fajardose" => "Miss Fajardose",
							"Modern Antiqua" => "Modern Antiqua",
							"Molengo" => "Molengo",
							"Monofett" => "Monofett",
							"Monoton" => "Monoton",
							"Monsieur La Doulaise" => "Monsieur La Doulaise",
							"Montaga" => "Montaga",
							"Montez" => "Montez",
							"Montserrat" => "Montserrat",
							"Moul" => "Moul",
							"Moulpali" => "Moulpali",
							"Mountains of Christmas" => "Mountains of Christmas",
							"Mr Bedfort" => "Mr Bedfort",
							"Mr Dafoe" => "Mr Dafoe",
							"Mr De Haviland" => "Mr De Haviland",
							"Mrs Saint Delafield" => "Mrs Saint Delafield",
							"Mrs Sheppards" => "Mrs Sheppards",
							"Muli" => "Muli",
    "Museo"=> "Museo",
							"Mystery Quest" => "Mystery Quest",
							"Neucha" => "Neucha",
							"Neuton" => "Neuton",
							"News Cycle" => "News Cycle",
							"Niconne" => "Niconne",
							"Nixie One" => "Nixie One",
							"Nobile" => "Nobile",
							"Nokora" => "Nokora",
							"Norican" => "Norican",
							"Nosifer" => "Nosifer",
							"Nothing You Could Do" => "Nothing You Could Do",
							"Noticia Text" => "Noticia Text",
							"Nova Cut" => "Nova Cut",
							"Nova Flat" => "Nova Flat",
							"Nova Mono" => "Nova Mono",
							"Nova Oval" => "Nova Oval",
							"Nova Round" => "Nova Round",
							"Nova Script" => "Nova Script",
							"Nova Slim" => "Nova Slim",
							"Nova Square" => "Nova Square",
							"Numans" => "Numans",
							"Nunito" => "Nunito",
							"Odor Mean Chey" => "Odor Mean Chey",
							"Old Standard TT" => "Old Standard TT",
							"Oldenburg" => "Oldenburg",
							"Oleo Script" => "Oleo Script",
							"Open Sans" => "Open Sans",
							"Open Sans Condensed" => "Open Sans Condensed",
							"Orbitron" => "Orbitron",
							"Original Surfer" => "Original Surfer",
							"Oswald" => "Oswald",
							"Over the Rainbow" => "Over the Rainbow",
							"Overlock" => "Overlock",
							"Overlock SC" => "Overlock SC",
							"Ovo" => "Ovo",
							"Oxygen" => "Oxygen",
							"PT Mono" => "PT Mono",
							"PT Sans" => "PT Sans",
							"PT Sans Caption" => "PT Sans Caption",
							"PT Sans Narrow" => "PT Sans Narrow",
							"PT Serif" => "PT Serif",
							"PT Serif Caption" => "PT Serif Caption",
							"Pacifico" => "Pacifico",
							"Parisienne" => "Parisienne",
							"Passero One" => "Passero One",
							"Passion One" => "Passion One",
							"Patrick Hand" => "Patrick Hand",
							"Patua One" => "Patua One",
							"Paytone One" => "Paytone One",
							"Permanent Marker" => "Permanent Marker",
							"Petrona" => "Petrona",
							"Philosopher" => "Philosopher",
							"Piedra" => "Piedra",
							"Pinyon Script" => "Pinyon Script",
							"Plaster" => "Plaster",
							"Play" => "Play",
							"Playball" => "Playball",
							"Playfair Display" => "Playfair Display",
							"Podkova" => "Podkova",
							"Poiret One" => "Poiret One",
							"Poller One" => "Poller One",
							"Poly" => "Poly",
							"Pompiere" => "Pompiere",
							"Pontano Sans" => "Pontano Sans",
							"Port Lligat Sans" => "Port Lligat Sans",
							"Port Lligat Slab" => "Port Lligat Slab",
							"Prata" => "Prata",
							"Preahvihear" => "Preahvihear",
							"Press Start 2P" => "Press Start 2P",
							"Princess Sofia" => "Princess Sofia",
							"Prociono" => "Prociono",
							"Prosto One" => "Prosto One",
							"Puritan" => "Puritan",
							"Quantico" => "Quantico",
							"Quattrocento" => "Quattrocento",
							"Quattrocento Sans" => "Quattrocento Sans",
							"Questrial" => "Questrial",
							"Quicksand" => "Quicksand",
							"Qwigley" => "Qwigley",
							"Radley" => "Radley",
							"Raleway" => "Raleway",
							"Rammetto One" => "Rammetto One",
							"Rancho" => "Rancho",
							"Rationale" => "Rationale",
							"Redressed" => "Redressed",
							"Reenie Beanie" => "Reenie Beanie",
							"Revalia" => "Revalia",
							"Ribeye" => "Ribeye",
							"Ribeye Marrow" => "Ribeye Marrow",
							"Righteous" => "Righteous",
							"Rochester" => "Rochester",
							"Rock Salt" => "Rock Salt",
							"Rokkitt" => "Rokkitt",
							"Ropa Sans" => "Ropa Sans",
							"Rosario" => "Rosario",
							"Rosarivo" => "Rosarivo",
							"Rouge Script" => "Rouge Script",
							"Ruda" => "Ruda",
							"Ruge Boogie" => "Ruge Boogie",
							"Ruluko" => "Ruluko",
							"Ruslan Display" => "Ruslan Display",
							"Russo One" => "Russo One",
							"Ruthie" => "Ruthie",
							"Sail" => "Sail",
							"Salsa" => "Salsa",
							"Sancreek" => "Sancreek",
							"Sansita One" => "Sansita One",
							"Sarina" => "Sarina",
							"Satisfy" => "Satisfy",
							"Schoolbell" => "Schoolbell",
							"Seaweed Script" => "Seaweed Script",
							"Sevillana" => "Sevillana",
							"Shadows Into Light" => "Shadows Into Light",
							"Shadows Into Light Two" => "Shadows Into Light Two",
							"Shanti" => "Shanti",
							"Share" => "Share",
							"Shojumaru" => "Shojumaru",
							"Short Stack" => "Short Stack",
							"Siemreap" => "Siemreap",
							"Sigmar One" => "Sigmar One",
							"Signika" => "Signika",
							"Signika Negative" => "Signika Negative",
							"Simonetta" => "Simonetta",
							"Sirin Stencil" => "Sirin Stencil",
							"Six Caps" => "Six Caps",
							"Slackey" => "Slackey",
							"Smokum" => "Smokum",
							"Smythe" => "Smythe",
							"Sniglet" => "Sniglet",
							"Snippet" => "Snippet",
							"Sofia" => "Sofia",
							"Sonsie One" => "Sonsie One",
							"Sorts Mill Goudy" => "Sorts Mill Goudy",
							"Special Elite" => "Special Elite",
							"Spicy Rice" => "Spicy Rice",
							"Spinnaker" => "Spinnaker",
							"Spirax" => "Spirax",
							"Squada One" => "Squada One",
							"Stardos Stencil" => "Stardos Stencil",
							"Stint Ultra Condensed" => "Stint Ultra Condensed",
							"Stint Ultra Expanded" => "Stint Ultra Expanded",
							"Stoke" => "Stoke",
							"Sue Ellen Francisco" => "Sue Ellen Francisco",
							"Sunshiney" => "Sunshiney",
							"Supermercado One" => "Supermercado One",
							"Suwannaphum" => "Suwannaphum",
							"Swanky and Moo Moo" => "Swanky and Moo Moo",
							"Syncopate" => "Syncopate",
							"Tangerine" => "Tangerine",
							"Taprom" => "Taprom",
							"Telex" => "Telex",
							"Tenor Sans" => "Tenor Sans",
							"The Girl Next Door" => "The Girl Next Door",
							"Tienne" => "Tienne",
							"Tinos" => "Tinos",
							"Titan One" => "Titan One",
							"Trade Winds" => "Trade Winds",
							"Trocchi" => "Trocchi",
							"Trochut" => "Trochut",
							"Trykker" => "Trykker",
							"Tulpen One" => "Tulpen One",
							"Ubuntu" => "Ubuntu",
							"Ubuntu Condensed" => "Ubuntu Condensed",
							"Ubuntu Mono" => "Ubuntu Mono",
							"Ultra" => "Ultra",
							"Uncial Antiqua" => "Uncial Antiqua",
							"UnifrakturCook" => "UnifrakturCook",
							"UnifrakturMaguntia" => "UnifrakturMaguntia",
							"Unkempt" => "Unkempt",
							"Unlock" => "Unlock",
							"Unna" => "Unna",
							"VT323" => "VT323",
							"Varela" => "Varela",
							"Varela Round" => "Varela Round",
							"Vast Shadow" => "Vast Shadow",
							"Vibur" => "Vibur",
							"Vidaloka" => "Vidaloka",
							"Viga" => "Viga",
							"Voces" => "Voces",
							"Volkhov" => "Volkhov",
							"Vollkorn" => "Vollkorn",
							"Voltaire" => "Voltaire",
							"Waiting for the Sunrise" => "Waiting for the Sunrise",
							"Wallpoet" => "Wallpoet",
							"Walter Turncoat" => "Walter Turncoat",
							"Wellfleet" => "Wellfleet",
							"Wire One" => "Wire One",
							"Yanone Kaffeesatz" => "Yanone Kaffeesatz",
							"Yellowtail" => "Yellowtail",
							"Yeseva One" => "Yeseva One",
							"Yesteryear" => "Yesteryear",
							"Zeyada" => "Zeyada",
						);

/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

$of_options[] = array( "name" => "General Options",
					"type" => "heading");
					
$of_options[] = array( "name" => "Custom Favicon",
					"desc" => "You can put url of an ico image that will represent your website's favicon (16px x 16px)",
					"id" => "favicon",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Apple iPhone Icon Upload",
					"desc" => "Icon for Apple iPhone (57px x 57px)",
					"id" => "iphone_icon",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Apple iPhone Retina Icon Upload",
					"desc" => "Icon for Apple iPhone Retina Version (114px x 114px)",
					"id" => "iphone_icon_retina",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Apple iPad Icon Upload",
					"desc" => "Icon for Apple iPhone (72px x 72px)",
					"id" => "ipad_icon",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Apple iPad Retina Icon Upload",
					"desc" => "Icon for Apple iPad Retina Version (144px x 144px)",
					"id" => "ipad_icon_retina",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Default Sidebar Position",
					"desc" => "Select the defeault position of the sidebar.",
					"id" => "default_sidebar_pos",
					"std" => "right",
					"options" => array('right' => 'Right', 'left' => 'Left'),
					"type" => "select");

$of_options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => "google_analytics",
					"std" => "",
					"type" => "textarea");

$of_options[] = array( "name" => "Allow comments on pages",
					"desc" => "Allow comments on regular pages.",
					"id" => "comments_pages",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Responsive Design",
					"desc" => "Use the responsive design features.",
					"id" => "responsive",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Use Fixed Layout for iPad Portrait",
					"desc" => "Check this box to use the fixed layout for the iPad in portrait view.",
					"id" => "ipad_potrait",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Space before &lt;/head&gt;",
					"desc" => "Add code before the &lt;/head&gt; tag.",
					"id" => "space_head",
					"std" => "",
					"type" => "textarea");

$of_options[] = array( "name" => "Space before &lt;/body&gt;",
					"desc" => "Add code before the &lt;/body&gt; tag.",
					"id" => "space_body",
					"std" => "",
					"type" => "textarea");

$of_options[] = array( "name" => "Header Options",
					"type" => "heading");

$of_options[] = array( "name" => "Select a Header Layout",
					"desc" => "",
					"id" => "header_layout",
					"std" => "v1",
					"type" => "images",
					"options" => array(
						"v1" => get_bloginfo('template_directory')."/images/patterns/header1.jpg",
						"v2" => get_bloginfo('template_directory')."/images/patterns/header2.jpg",
						"v3" => get_bloginfo('template_directory')."/images/patterns/header3.jpg",
						"v4" => get_bloginfo('template_directory')."/images/patterns/header4.jpg",
						"v5" => get_bloginfo('template_directory')."/images/patterns/header5.jpg"
					));

$of_options[] = array( "name" => "Header Top Margin",
					"desc" => "(in pixels)",
					"id" => "margin_header_top",
					"std" => "0px",
					"type" => "text");

$of_options[] = array( "name" => "Header Bottom Margin",
					"desc" => "(in pixels)",
					"id" => "margin_header_bottom",
					"std" => "0px",
					"type" => "text");

$of_options[] = array( "name" => "Logo Left Margin",
					"desc" => "(in pixels)",
					"id" => "margin_logo_left",
					"std" => "0px",
					"type" => "text");

$of_options[] = array( "name" => "Logo Bottom Margin",
					"desc" => "(in pixels)",
					"id" => "margin_logo_bottom",
					"std" => "0px",
					"type" => "text");

$of_options[] = array( "name" => "Main Nav Height",
					"desc" => "(Only use number without 'px', default is 83)",
					"id" => "nav_height",
					"std" => "83",
					"type" => "text");

$of_options[] = array( "name" => "Logo",
					"desc" => "Please choose an image file for your logo.",
					"id" => "logo",
					"std" => get_bloginfo('template_directory')."/images/logo.gif",
					"mod" => "min",
					"type" => "media");

$of_options[] = array( "name" => "Logo (Retina Version @2x)",
					"desc" => "Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.",
					"id" => "logo_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");

$of_options[] = array( "name" => "Standard Logo Width for Retina Logo",
					"desc" => "If retina logo is uploaded, please enter the standard logo (1x) version width, do not enter the retina logo width.",
					"id" => "retina_logo_width",
					"std" => "97",
					"type" => "text");

$of_options[] = array( "name" => "Standard Logo Height for Retina Logo",
					"desc" => "If retina logo is uploaded, please enter the standard logo (1x) version height, do not enter the retina logo height.",
					"id" => "retina_logo_height",
					"std" => "22",
					"type" => "text");

$of_options[] = array( "name" => "Header Phone Number",
					"desc" => "",
					"id" => "header_number",
					"std" => "Call Us Today! 1.555.555.555",
					"type" => "text");

$of_options[] = array( "name" => "Header Email Address",
					"desc" => "",
					"id" => "header_email",
					"std" => "info@yourdomain.com",
					"type" => "text");

$of_options[] = array( "name" => "Header Tagline",
					"desc" => "",
					"id" => "header_tagline",
					"std" => "Insert Any Headline Or Link You Want Here",
					"type" => "text");

$of_options[] = array( "name" => "Display social icons on header of the page:",
					"desc" => "Select the checkbox to show social media icons on the header of the page.",
					"id" => "icons_header",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Open social icons on header in a new window",
					"desc" => "",
					"id" => "icons_header_new",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Breadcrumbs or Search Box?",
					"desc" => "Show breadcrumbs or search box on page title bar?",
					"id" => "page_title_bar_bs",
					"std" => "Breadcrumbs",
					"options" => array('breadcrumbs' => 'Breadcrumbs', 'search' => 'Search Box'),
					"type" => "select");


$of_options[] = array( "name" => "Breadcrumb Menu",
					"desc" => "Show breadcrumbs in general",
					"id" => "breadcrumb",
					"std" => 1,
					"type" => "checkbox");


$of_options[] = array( "name" => "Breadcrumb on Mobile Devices",
					"desc" => "Show breadcrumbs on mobile devices",
					"id" => "breadcrumb_mobile",
					"std" => 0,
					"type" => "checkbox");


$of_options[] = array( "name" => "Breadcrumb Menu Prefix",
					"desc" => "The text before the breadcrumb menu",
					"id" => "breacrumb_prefix",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Page Title Bar",
					"desc" => "Show page title bar",
					"id" => "page_title_bar",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Page Title Bar Background",
					"desc" => "",
					"id" => "page_title_bg",
					"std" => get_bloginfo('template_directory')."/images/page_title_bg.png",
					"mod" => "min",
					"type" => "media");

$of_options[] = array( "name" => "Page Title Bar Background (Retina Version @2x)",
					"desc" => "",
					"id" => "page_title_bg_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");

$of_options[] = array( "name" => "Page Title Bar Background Color",
					"desc" => "",
					"id" => "page_title_bg_color",
					"std" => "#F6F6F6",
					"type" => "color");

$of_options[] = array( "name" => "Footer Options",
					"type" => "heading");

$of_options[] = array( "name" => "Copyright Bar",
					"desc" => "Show copyright bar",
					"id" => "footer_copyright",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Copyright Text",
                    "desc" => "",
                    "id" => "footer_text",
                    "std" => 'Copyright 2012 Avada | All Rights Reserved | Powered by <a href="http://wordpress.org">WordPress</a>  |  <a href="http://theme-fusion.com">Theme Fusion</a>',
                    "type" => "textarea");

$of_options[] = array( "name" => "Footer Widgets",
					"desc" => "Show footer widgets",
					"id" => "footer_widgets",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Number of Footer Columns",
					"desc" => "",
					"id" => "footer_widgets_columns",
					"std" => "4",
					"options" => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
					"type" => "select");

$of_options[] = array( "name" => "Display social icons on footer of the page:",
					"desc" => "Select the checkbox to show social media icons on the footer of the page.",
					"id" => "icons_footer",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Open social icons on footer in a new window",
					"desc" => "",
					"id" => "icons_footer_new",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Background Options",
					"type" => "heading");

$of_options[] = array( "name" => "Layout",
					"desc" => "Boxed or wide layout?",
					"id" => "layout",
					"std" => "Wide",
					"type" => "select",
					"options" => array(
						'boxed' => 'Boxed',
						'wide' => 'Wide',
					));

$of_options[] = array( "name" => "Boxed Mode Only",
					"desc" => "",
					"id" => "boxed_mode_only",
					"std" => "<h3 style='margin: 0;'>Background options below only work in boxed mode.</h3>",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => "Background Image",
					"desc" => "Please choose an image or insert an image url to use for the backgroud.",
					"id" => "bg_image",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "100% Background Image",
					"desc" => "Have background image always at 100% in width and height and scale according to the browser size.",
					"id" => "bg_full",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Background Repeat",
					"desc" => "",
					"id" => "bg_repeat",
					"std" => "",
					"type" => "select",
					"options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));  

$of_options[] = array( "name" =>  "Background Color",
					"desc" => "Pick a background color.",
					"id" => "bg_color",
					"std" => "#d7d6d6",
					"type" => "color");

$of_options[] = array( "name" => "Background Pattern?",
					"desc" => "If yes, select the pattern from below:",
					"id" => "bg_pattern_option",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Select a Background Pattern",
					"desc" => "",
					"id" => "bg_pattern",
					"std" => "pattern1",
					"type" => "images",
					"options" => array(
						"pattern1" => get_bloginfo('template_directory')."/images/patterns/pattern1.png",
						"pattern2" => get_bloginfo('template_directory')."/images/patterns/pattern2.png",
						"pattern3" => get_bloginfo('template_directory')."/images/patterns/pattern3.png",
						"pattern4" => get_bloginfo('template_directory')."/images/patterns/pattern4.png",
						"pattern5" => get_bloginfo('template_directory')."/images/patterns/pattern5.png",
						"pattern6" => get_bloginfo('template_directory')."/images/patterns/pattern6.png",
						"pattern7" => get_bloginfo('template_directory')."/images/patterns/pattern7.png",
						"pattern8" => get_bloginfo('template_directory')."/images/patterns/pattern8.png",
						"pattern9" => get_bloginfo('template_directory')."/images/patterns/pattern9.png",
						"pattern10" => get_bloginfo('template_directory')."/images/patterns/pattern10.png",
					));

$of_options[] = array( "name" => "Typography Options",
					"type" => "heading");

$of_options[] = array( "name" => "Custom Nav / Headings Font",
					"desc" => "",
					"id" => "custom_heading_font",
					"std" => "<h3 style='margin: 0;''>Only for navigation menus and headings.</h3><p style='margin-bottom:0;'>This will overwrite the google / standard font options if custom font files are uploaded.</p>",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => "Custom Font .woff",
					"desc" => "",
					"id" => "custom_font_woff",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Custom Font .ttf",
					"desc" => "",
					"id" => "custom_font_ttf",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Custom Font .svg",
					"desc" => "",
					"id" => "custom_font_svg",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Custom Font .eot",
					"desc" => "",
					"id" => "custom_font_eot",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Google Fonts",
					"desc" => "",
					"id" => "google_fonts_intro",
					"std" => "<h3 style='margin: 0;''>Google Fonts</h3>",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => "Select Body Font Family",
					"desc" => "Select a font family for body text",
					"id" => "google_body",
					"std" => "PT Sans",
					"type" => "select",
					"options" => $google_fonts);

$of_options[] = array( "name" => "Select Menu Font",
					"desc" => "Select a font family for navigation",
					"id" => "google_nav",
					"std" => "Antic Slab",
					"type" => "select",
					"options" => $google_fonts);

$of_options[] = array( "name" => "Select Headings Font",
					"desc" => "Select a font family for headings",
					"id" => "google_headings",
					"std" => "Antic Slab",
					"type" => "select",
					"options" => $google_fonts);

$of_options[] = array( "name" => "Select Footer Headings Font",
					"desc" => "Select a font family for footer headings",
					"id" => "google_footer_headings",
					"std" => "Antic Slab",
					"type" => "select",
					"options" => $google_fonts);

$of_options[] = array( "name" => "Standard Fonts",
					"desc" => "",
					"id" => "standard_fonts_intro",
					"std" => "<h3 style='margin: 0; margin-bottom:10px;''>Standards</h3>If you have a Google Font selected above, it will override the standard font.",
					"icon" => true,
					"type" => "info");

$standard_fonts = array(
						'0' => 'Select Font',
						'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
						"'Arial Black', Gadget, sans-serif" => "'Arial Black', Gadget, sans-serif",
						"'Bookman Old Style', serif" => "'Bookman Old Style', serif",
						"'Comic Sans MS', cursive" => "'Comic Sans MS', cursive",
						"Courier, monospace" => "Courier, monospace",
						"Garamond, serif" => "Garamond, serif",
						"Georgia, serif" => "Georgia, serif",
						"Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
						"'Lucida Console', Monaco, monospace" => "'Lucida Console', Monaco, monospace",
						"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
						"'MS Sans Serif', Geneva, sans-serif" => "'MS Sans Serif', Geneva, sans-serif",
						"'MS Serif', 'New York', sans-serif" => "'MS Serif', 'New York', sans-serif",
						"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
						"Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
						"'Times New Roman', Times, serif" => "'Times New Roman', Times, serif",
						"'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
						"Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif"
					);

$of_options[] = array( "name" => "Select Body Font Family",
					"desc" => "Select a font family for body text",
					"id" => "standard_body",
					"std" => "",
					"type" => "select",
					"options" => $standard_fonts);

$of_options[] = array( "name" => "Select Menu Font Family",
					"desc" => "Select a font family for menu / navigation",
					"id" => "standard_nav",
					"std" => "",
					"type" => "select",
					"options" => $standard_fonts);

$of_options[] = array( "name" => "Select Headings Font Family",
					"desc" => "Select a font family for headings",
					"id" => "standard_headings",
					"std" => "",
					"type" => "select",
					"options" => $standard_fonts);

$of_options[] = array( "name" => "Select Footer Headings Font Family",
					"desc" => "Select a font family for footer headings",
					"id" => "standard_footer_headings",
					"std" => "",
					"type" => "select",
					"options" => $standard_fonts);

$of_options[] = array( "name" => "Standard Fonts",
					"desc" => "",
					"id" => "font_size_intro",
					"std" => "<h3 style='margin: 0;'>Font Sizes</h3>",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => "Body Font Size (px)",
					"desc" => "Default is 13",
					"id" => "body_font_size",
					"std" => "13",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Top Nav Font Size (px)",
					"desc" => "Default is 14",
					"id" => "nav_font_size",
					"std" => "14",
					"type" => "select",
					"options" => $font_sizes);


$of_options[] = array( "name" => "Secondary Nav & Top Contact Info Font Size (px)",
					"desc" => "Default is 12",
					"id" => "snav_font_size",
					"std" => "12",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Side Nav Font Size (px)",
					"desc" => "Default is 14",
					"id" => "side_nav_font_size",
					"std" => "14",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Breadcrumbs Font Size (px)",
					"desc" => "Default is 10",
					"id" => "breadcrumbs_font_size",
					"std" => "10",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Sidebar Widget Title Font Size (px)",
					"desc" => "Default is 13",
					"id" => "sidew_font_size",
					"std" => "13",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Footer Widget Title Font Size (px)",
					"desc" => "Default is 13",
					"id" => "footw_font_size",
					"std" => "13",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Copyright Font Size (px)",
					"desc" => "Default is 12",
					"id" => "copyright_font_size",
					"std" => "12",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Heading Font Size H1 (px)",
					"desc" => "Default is 32",
					"id" => "h1_font_size",
					"std" => "32",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Heading Font Size H2 (px)",
					"desc" => "Default is 18",
					"id" => "h2_font_size",
					"std" => "18",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Heading Font Size H3 (px)",
					"desc" => "Default is 16",
					"id" => "h3_font_size",
					"std" => "16",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Heading Font Size H4 (px)",
					"desc" => "Default is 13",
					"id" => "h4_font_size",
					"std" => "13",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Heading Font Size H5 (px)",
					"desc" => "Default is 12",
					"id" => "h5_font_size",
					"std" => "12",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Heading Font Size H6 (px)",
					"desc" => "Default is 11",
					"id" => "h6_font_size",
					"std" => "11",
					"type" => "select",
					"options" => $font_sizes);
 
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading");

$of_options[] = array( "name" => "Predefined Color Schemes",
					"desc" => "",
					"id" => "color_scheme",
					"std" => "Green",
					"type" => "select",
					"options" => array('red' => 'Red', 'lighred' => 'Light Red', 'blue' => 'Blue', 'lightblue' => 'Light Blue', 'green' => 'Green', 'darkgreen' => 'Dark Green', 'yellow' => 'Yellow', 'pink' => 'Pink', 'brown' => 'Brown', 'lightgrey' => 'Light Grey'));

$of_options[] = array( "name" => "Custom Color Scheme",
					"desc" => "",
					"id" => "custom_color_scheme_intro",
					"std" => "<h3 style='margin: 0;'>Create Custom Color Scheme</h3>",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" =>  "Primary Color",
					"desc" => "",
					"id" => "primary_color",
					"std" => "#a0ce4e",
					"type" => "color");

$of_options[] = array( "name" =>  "Pricing Box Color",
					"desc" => "",
					"id" => "pricing_box_color",
					"std" => "#92C563",
					"type" => "color");

$of_options[] = array( "name" =>  "Rollover Image Gradient Top Color",
					"desc" => "",
					"id" => "image_gradient_top_color",
					"std" => "#D1E990",
					"type" => "color");

$of_options[] = array( "name" =>  "Rollover Image Gradient Bottom Color",
					"desc" => "",
					"id" => "image_gradient_bottom_color",
					"std" => "#AAD75B",
					"type" => "color");

$of_options[] = array( "name" =>  "Button Gradient Top Color",
					"desc" => "",
					"id" => "button_gradient_top_color",
					"std" => "#D1E990",
					"type" => "color");

$of_options[] = array( "name" =>  "Button Gradient Bottom Color",
					"desc" => "",
					"id" => "button_gradient_bottom_color",
					"std" => "#AAD75B",
					"type" => "color");

$of_options[] = array( "name" =>  "Button Text Color",
					"desc" => "",
					"id" => "button_gradient_text_color",
					"std" => "#54770f",
					"type" => "color");

$of_options[] = array( "name" =>  "Headings Font Color",
					"desc" => "",
					"id" => "headings_color",
					"std" => "#333333",
					"type" => "color");
					
$of_options[] = array( "name" =>  "Body Text Color",
					"desc" => "",
					"id" => "body_text_color",
					"std" => "#747474",
					"type" => "color");

$of_options[] = array( "name" =>  "Link Color",
					"desc" => "",
					"id" => "link_color",
					"std" => "#333333",
					"type" => "color");

$of_options[] = array( "name" =>  "Breadcrumbs Text Color",
					"desc" => "",
					"id" => "breadcrumbs_text_color",
					"std" => "#333333",
					"type" => "color");

$of_options[] = array( "name" =>  "Footer Headings Color",
					"desc" => "",
					"id" => "footer_headings_color",
					"std" => "#DDDDDD",
					"type" => "color");

$of_options[] = array( "name" =>  "Footer Font Color",
					"desc" => "",
					"id" => "footer_text_color",
					"std" => "#8C8989",
					"type" => "color");

$of_options[] = array( "name" =>  "Footer Link Color",
					"desc" => "",
					"id" => "footer_link_color",
					"std" => "#BFBFBF",
					"type" => "color");

$of_options[] = array( "name" =>  "Secondary Nav & Top Contact Info Color",
					"desc" => "",
					"id" => "snav_color",
					"std" => "#747474",
					"type" => "color");

$of_options[] = array( "name" => "Menu Colors",
					"desc" => "",
					"id" => "menu_colors_intro",
					"std" => "<h3 style='margin: 0;'>Menu Colors</h3>",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" =>  "Menu Font Color - First Level",
					"desc" => "",
					"id" => "menu_first_color",
					"std" => "#333333",
					"type" => "color");

$of_options[] = array( "name" =>  "Menu Background Color - Sublevels",
					"desc" => "",
					"id" => "menu_sub_bg_color",
					"std" => "#edebeb",
					"type" => "color");

$of_options[] = array( "name" =>  "Menu Font Color - Sublevels",
					"desc" => "",
					"id" => "menu_sub_color",
					"std" => "#333333",
					"type" => "color");

$of_options[] = array( "name" => "Blog Options",
					"type" => "heading");

$of_options[] = array( "name" => "Blog Layout",
					"desc" => "",
					"id" => "blog_layout",
					"std" => "Large",
					"type" => "select",
					"options" => array(
						'large' => 'Large',
						'medium' => 'Medium',
					));

$of_options[] = array( "name" => "Blog Page Title Bar Title",
					"desc" => "",
					"id" => "blog_title",
					"std" => "Blog",
					"type" => "text");

$of_options[] = array( "name" => "Full Width",
					"desc" => "Turn the blog into full width.",
					"id" => "blog_full_width",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Sidebar Position",
					"desc" => "Blog listings page sidebar position",
					"id" => "blog_sidebar_position",
					"std" => "right",
					"type" => "select",
					"options" => array(
						'right' => 'Right',
						'left' => 'Left',
					));

$of_options[] = array( "name" => "Featured Image On Blog Archive Page",
					"desc" => "Show featured images on blog archive page",
					"id" => "featured_images",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Featured Image on Single Post Page",
					"desc" => "Show featured images on single post pages.",
					"id" => "featured_images_single",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Post Title",
					"desc" => "Show the post title that goes below the featured images.",
					"id" => "blog_post_title",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Author Info Box",
					"desc" => "Show the author info box below posts.",
					"id" => "author_info",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Social Sharing Box",
					"desc" => "Show the social sharing box.",
					"id" => "social_sharing_box",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Related Posts",
					"desc" => "Show related posts.",
					"id" => "related_posts",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Comments",
					"desc" => "Show comments.",
					"id" => "blog_comments",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Date Format",
					"desc" => "<a href='http://codex.wordpress.org/Formatting_Date_and_Time'>Formatting Date and Time</a>",
					"id" => "date_format",
					"std" => "F jS, Y",
					"type" => "text");

$of_options[] = array( "name" => "Post Meta",
					"desc" => "Show post meta on blog posts.",
					"id" => "post_meta",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Excerpt or Full Blog Content",
					"desc" => "Show excerpt or full blog content on archive / blog pages",
					"id" => "content_length",
					"std" => "Excerpt",
					"type" => "select",
					"options" => array('excerpt' => 'Excerpt', 'full' => 'Full Content'));

$of_options[] = array( "name" => "Strip HTML from Excerpt",
					"desc" => "Check this if you want to strip HTML from the excerpt content only.",
					"id" => "strip_html_excerpt",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Excerpt Length",
					"desc" => "Input the number of words you want to cut from the content to be the excerpt of search and archive page.",
					"id" => "excerpt_length_blog",
					"std" => "285",
					"type" => "text");

$of_options[] = array( "name" => "Search Results Content",
					"desc" => "Select the type of content to display in search results",
					"id" => "search_content",
					"std" => "Posts and Pages",
					"type" => "select",
					"options" => array('posts_pages' => 'Posts and Pages', 'posts' => 'Only Posts', 'pages' => 'Only Pages'));

$of_options[] = array( "name" => "Hide Search Results Excerpt",
					"desc" => "Check this if you want to hide excerpt for search results.",
					"id" => "search_excerpt",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Portfolio Options",
					"type" => "heading");

$of_options[] = array( "name" => "Number of Portfolio Items",
					"desc" => "",
					"id" => "portfolio_items",
					"std" => "10",
					"type" => "text"); 

$of_options[] = array( "name" => "Excerpt Length",
					"desc" => "Input the number of words you want to cut from the content to be the excerpt of the 1 column portfolio page.",
					"id" => "excerpt_length_portfolio",
					"std" => "285",
					"type" => "text");

$of_options[] = array( "name" => "Portfolio Slug",
					"desc" => "Change/Rewrite the permalink when you use the permalink type as %postname%.<strong>Make sure to regenerate permalinks.</strong>",
					"id" => "portfolio_slug",
					"std" => "portfolio-items",
					"type" => "text"); 

$of_options[] = array( "name" => "Project Description Title",
					"desc" => "",
					"id" => "project_desc_title",
					"std" => "Project Description",
					"type" => "text"); 

$of_options[] = array( "name" => "Project Details Title",
					"desc" => "",
					"id" => "project_details_title",
					"std" => "Project Details",
					"type" => "text"); 

$of_options[] = array( "name" => "Skills Title",
					"desc" => "",
					"id" => "skills_title",
					"std" => "Skills Needed",
					"type" => "text"); 

$of_options[] = array( "name" => "Categories Title",
					"desc" => "",
					"id" => "categories_title",
					"std" => "Categories",
					"type" => "text");

$of_options[] = array( "name" => "Project URL Title",
					"desc" => "",
					"id" => "project_url_title",
					"std" => "Project URL",
					"type" => "text"); 

$of_options[] = array( "name" => "Copyright Title",
					"desc" => "",
					"id" => "copyright_title",
					"std" => "Copyright",
					"type" => "text"); 

$of_options[] = array( "name" => "Social Sharing Box",
					"type" => "heading");

$of_options[] = array( "name" => "Facebook",
					"desc" => "Show the facebook sharing option in blog posts.",
					"id" => "sharing_facebook",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Twitter",
					"desc" => "Show the twitter sharing option in blog posts.",
					"id" => "sharing_twitter",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Reddit",
					"desc" => "Show the reddit sharing option in blog posts.",
					"id" => "sharing_reddit",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "LinkedIn",
					"desc" => "Show the linkedin sharing option in blog posts.",
					"id" => "sharing_linkedin",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Google Plus",
					"desc" => "Show the g+ sharing option in blog posts.",
					"id" => "sharing_google",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Tumblr",
					"desc" => "Show the tumblr sharing option in blog posts.",
					"id" => "sharing_tumblr",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Email",
					"desc" => "Show the email sharing option in blog posts.",
					"id" => "sharing_email",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Social Sharing Links",
					"type" => "heading");
					
$of_options[] = array( "name" => "Facebook",
					"desc" => "Place the link you want and facebook icon will appear. To remove it, just leave it blank.",
					"id" => "facebook_link",
					"std" => "",
					"type" => "text"); 

$of_options[] = array( "name" => "Flickr",
					"desc" => "Place the link you want and flickr icon will appear. To remove it, just leave it blank.",
					"id" => "flickr_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "RSS",
					"desc" => "Place the link you want and rss icon will appear. To remove it, just leave it blank.",
					"id" => "rss_link",
					"std" => "",
					"type" => "text"); 

$of_options[] = array( "name" => "Twitter",
					"desc" => "Place the link you want and twitter icon will appear. To remove it, just leave it blank.",
					"id" => "twitter_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Vimeo",
					"desc" => "Place the link you want and vimeo icon will appear. To remove it, just leave it blank.",
					"id" => "vimeo_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Youtube",
					"desc" => "Place the link you want and youtube icon will appear. To remove it, just leave it blank.",
					"id" => "youtube_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Pinterest",
					"desc" => "Place the link you want and pinterest icon will appear. To remove it, just leave it blank.",
					"id" => "pinterest_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Tumblr",
					"desc" => "Place the link you want and tumblr icon will appear. To remove it, just leave it blank.",
					"id" => "tumblr_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Google Plus",
					"desc" => "Place the link you want and g+ icon will appear. To remove it, just leave it blank.",
					"id" => "google_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Dribbble",
					"desc" => "Place the link you want and dribbble icon will appear. To remove it, just leave it blank.",
					"id" => "dribbble_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Digg",
					"desc" => "Place the link you want and digg icon will appear. To remove it, just leave it blank.",
					"id" => "digg_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "LinkedIn",
					"desc" => "Place the link you want and linkedin icon will appear. To remove it, just leave it blank.",
					"id" => "linkedin_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Blogger",
					"desc" => "Place the link you want and blogger icon will appear. To remove it, just leave it blank.",
					"id" => "blogger_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Skype",
					"desc" => "Place the link you want and skype icon will appear. To remove it, just leave it blank.",
					"id" => "skype_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Forrst",
					"desc" => "Place the link you want and forrst icon will appear. To remove it, just leave it blank.",
					"id" => "forrst_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Myspace",
					"desc" => "Place the link you want and myspace icon will appear. To remove it, just leave it blank.",
					"id" => "myspace_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Deviantart",
					"desc" => "Place the link you want and deviantart icon will appear. To remove it, just leave it blank.",
					"id" => "deviantart_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Yahoo",
					"desc" => "Place the link you want and yahoo icon will appear. To remove it, just leave it blank.",
					"id" => "yahoo_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Reddit",
					"desc" => "Place the link you want and reddit icon will appear. To remove it, just leave it blank.",
					"id" => "reddit_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Custom Icon Name",
					"desc" => "",
					"id" => "custom_icon_name",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Custom Icon Image",
					"desc" => "",
					"id" => "custom_icon_image",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Custom Icon Link",
					"desc" => "",
					"id" => "custom_icon_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Slideshows",
					"type" => "heading");

$of_options[] = array( "name" => "Legacy Posts Slideshow",
					"desc" => "Check to enable posts slideshow in legacy mode.",
					"id" => "legacy_posts_slideshow",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Posts Slideshow",
					"desc" => "Show posts slideshow in post/portfolio pages.",
					"id" => "posts_slideshow",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Posts Slideshow Images",
					"desc" => "Number of images in posts/portfolio slideshow",
					"id" => "posts_slideshow_number",
					"std" => "5",
					"type" => "text");

$of_options[] = array( "name" => "Autoplay",
					"desc" => "Autoplay the slideshow",
					"id" => "slideshow_autoplay",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Number of FlexSlider Slides",
					"desc" => "Number of flexslider slides per group",
					"id" => "flexslider_number",
					"std" => "5",
					"type" => "text");

$of_options[] = array( "name" => "Pagination circles below video slides",
					"desc" => "Please check this box if you want to show pagination circles for slider below a video slider or uncheck it to hide them on video slides.",
					"id" => "pagination_video_slide",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "ThemeFusion Slider",
					"type" => "heading");

$of_options[] = array( "name" => "Width",
					"desc" => "In pixels or percentage, e.g.: 100% or 100px",
					"id" => "flexslider_width",
					"std" => "100%",
					"type" => "text");

$of_options[] = array( "name" => "Pagination",
					"desc" => "Turn on pagination circles",
					"id" => "flexslider_circles",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Animation",
					"desc" => "The animation the slides will have when rotating",
					"id" => "tfs_animation",
					"std" => "fade",
					"options" => array('fade' => 'fade', 'slide' => 'slide'),
					"type" => "select");

$of_options[] = array( "name" => "Autoplay",
					"desc" => "Autoplay the slides",
					"id" => "tfs_autoplay",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Slideshow Speed",
					"desc" => "Select the slideshow speed, 1000 = 1 second",
					"id" => "tfs_slideshow_speed",
					"std" => "7000",
					"type" => "text");

$of_options[] = array( "name" => "Animation speed",
					"desc" => "Select the animation speed, 1000 = 1 second",
					"id" => "tfs_animation_speed",
					"std" => "600",
					"type" => "text");

$of_options[] = array( "name" => "Number of ThemeFusion Sliders",
					"desc" => "Select the number of slider sets",
					"id" => "flexsliders_number",
					"std" => "1",
					"type" => "text");

global $data;
$i = 1;
while($i <= $data['flexsliders_number']){
$of_options[] = array( "name" => "TFSlider".$i,
					"desc" => "",
					"id" => "flexslider_".$i,
					"std" => "",
					"type" => "slider");
$i++;
}

$of_options[] = array( "name" => "Elastic Slider",
					"type" => "heading");

$of_options[] = array( "name" => "Slider Width",
					"desc" => "in pixels or percentage, e.g.: 100% or 100",
					"id" => "tfes_slider_width",
					"std" => "100%",
					"type" => "text");

$of_options[] = array( "name" => "Slider Height",
					"desc" => "in pixels, e.g.: 100px",
					"id" => "tfes_slider_height",
					"std" => "400px",
					"type" => "text");

$of_options[] = array( "name" => "Animation",
					"desc" => "New slides animating from sides or center",
					"id" => "tfes_animation",
					"std" => "sides",
					"options" => array('sides' => 'sides', 'center' => 'center'),
					"type" => "select");

$of_options[] = array( "name" => "Autoplay",
					"desc" => "Autoplay the slides",
					"id" => "tfes_autoplay",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Slideshow Interval",
					"desc" => "Select the slideshow speed, 1000 = 1 second",
					"id" => "tfes_interval",
					"std" => "3000",
					"type" => "text");

$of_options[] = array( "name" => "Sliding Speed",
					"desc" => "Select the animation speed, 1000 = 1 second",
					"id" => "tfes_speed",
					"std" => "800",
					"type" => "text");

$of_options[] = array( "name" => "Thumbnail Width",
					"desc" => "Please enter the width for thumbnail without 'px' e.g 100",
					"id" => "tfes_width",
					"std" => "150",
					"type" => "text");

$of_options[] = array( "name" => "Title Font Size (px)",
					"desc" => "Default is 42",
					"id" => "es_title_font_size",
					"std" => "42",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" => "Caption Font Size (px)",
					"desc" => "Default is 20",
					"id" => "es_caption_font_size",
					"std" => "20",
					"type" => "select",
					"options" => $font_sizes);

$of_options[] = array( "name" =>  "Title Color",
					"desc" => "",
					"id" => "es_title_color",
					"std" => "#333333",
					"type" => "color");

$of_options[] = array( "name" =>  "Caption Color",
					"desc" => "",
					"id" => "es_caption_color",
					"std" => "#747474",
					"type" => "color");

$of_options[] = array( "name" => "Lightbox Options",
					"type" => "heading");

$of_options[] = array( "name" => "Animation Speed",
					"desc" => "Set speed of animation",
					"id" => "lightbox_animation_speed",
					"std" => "fast",
					"type" => "select",
					"options" => array('fast' => 'Fast', 'slow' => 'Slow', 'normal' => 'Normal'));

$of_options[] = array( "name" => "Show gallery",
					"desc" => "Show gallery",
					"id" => "lightbox_gallery",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Autoplay the Lightbox Gallery",
					"desc" => "Autoplay the lightbox gallery",
					"id" => "lightbox_autoplay",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Slideshow Speed",
					"desc" => "If autoplay is enabled, set the slideshow speed 1000 = 1 second",
					"id" => "lightbox_slideshow_speed",
					"std" => "5000",
					"type" => "text");

$of_options[] = array( "name" => "Background Opacity",
					"desc" => "Set the opacity of background, 1 = 100%",
					"id" => "lightbox_opacity",
					"std" => "0.8",
					"type" => "text");

$of_options[] = array( "name" => "Show Caption",
					"desc" => "Show the image caption",
					"id" => "lightbox_title",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Show Description",
					"desc" => "Show the image description",
					"id" => "lightbox_desc",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Social Sharing",
					"desc" => "Show social sharing buttons on lightbox",
					"id" => "lightbox_social",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Show Post Images in Lightbox",
					"desc" => "Show post images between post content in the lightbox",
					"id" => "lightbox_post_images",
					"std" => 0,
					"type" => "checkbox");

// Theme Specific Options
$of_options[] = array( "name" => "Contact Options",
					"type" => "heading");

$of_options[] = array( "name" => "Google Map Width",
					"desc" => "(in pixels or percentage, e.g.:100% or 100px)",
					"id" => "gmap_width",
					"std" => "100%",
					"type" => "text");

$of_options[] = array( "name" => "Google Map Height",
					"desc" => "(in pixels, e.g.: 100px)",
					"id" => "gmap_height",
					"std" => "415px",
					"type" => "text");

$of_options[] = array( "name" => "Google Map Address",
					"desc" => "Example: 775 New York Ave, Brooklyn, Kings, New York 11203",
					"id" => "gmap_address",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Email Address",
					"desc" => "",
					"id" => "email_address",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Map Zoom Level",
					"desc" => "Higher number will be more zoomed in",
					"id" => "map_zoom_level",
					"std" => "8",
					"type" => "text");

$of_options[] = array( "name" => "Hide Map Scrollwheel",
					"desc" => "Check to hide scrollwheel on google maps",
					"id" => "map_scrollwheel",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Recaptcha Public Key",
					"desc" => "Follow the steps in our docs to get your key",
					"id" => "recaptcha_public",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Recaptcha Private Key",
					"desc" => "Follow the steps in our docs to get your key",
					"id" => "recaptcha_private",
					"std" => "",
					"type" => "text");

// Theme Specific Options
$of_options[] = array( "name" => "Extra Options",
					"type" => "heading");

$of_options[] = array( "name" => "Testimonials Speed",
					"desc" => "Select the slideshow speed, 1000 = 1 second",
					"id" => "testimonials_speed",
					"std" => "4000",
					"type" => "text");

$of_options[] = array( "name" => "Image Rollover",
					"desc" => "Show rollover box on images",
					"id" => "image_rollover",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Sidenav Behavior",
					"desc" => "Sidenav slidedown / slideup animation on click or hover",
					"id" => "sidenav_behavior",
					"std" => "hover",
					"options" => array('hover' => 'Hover', 'click' => 'Click'),
					"type" => "select");

$of_options[] = array( "name" => "Enable posts type order plugin",
					"desc" => "Disabled by default. Note: It can break the order of next post/previous post links.",
					"id" => "post_type_order",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "UberMenu Plugin Support",
					"desc" => "If you are using UberMenu, check this option to add ubermenu support without editing any code.",
					"id" => "ubermenu",
					"std" => 0,
					"type" => "checkbox");

// Backup Options
$of_options[] = array( "name" => "Custom CSS",
					"type" => "heading");

$of_options[] = array( "name" => "Advanced CSS Customizations",
					"desc" => "",
					"id" => "advanced_css_intro",
					"std" => "<h3 style='margin: 0;'>Advanced CSS Customizations</h3><p style='margin-bottom:0;'>Paste your css code. Do not include <stlye></stlye> tags or any html tag in this field.</p>",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => "CSS Code",
                    "desc" => "Any custom CSS from the user should go in this field, it will override the theme CSS",
                    "id" => "custom_css",
                    "std" => "",
                    "type" => "textarea");

// Backup Options
$of_options[] = array( "name" => "Backup Options",
					"type" => "heading");
					
$of_options[] = array( "name" => "Backup and Restore Options",
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
					
$of_options[] = array( "name" => "Transfer Theme Options Data",
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can transfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						',
					);

// Backup Options
/*$of_options[] = array( "name" => "Upgrade Options",
					"type" => "heading");

if($data['tf_username'] && $data['tf_api']) {
	$envato = get_template_directory() . '/framework/plugins/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php';
	include $envato;
	$upgrader = new Envato_WordPress_Theme_Upgrader($data['tf_username'], $data['tf_api']);
	$check_upgrade = $upgrader->check_for_theme_update('Avada');
	if($check_upgrade->updated_themes_count) {
		$of_options[] = array( "name" => "Theme Updater",
					"desc" => "",
					"id" => "theme_updater",
					"std" => "<h3 style='margin: 0;'>A new version is available!</h3><p style='margin-bottom:0;'>Enter the information below and make sure the checkbox is checked in order to udpate the theme.</p>",
					"icon" => true,
					"type" => "info");
	} else {
		$of_options[] = array( "name" => "Theme Updater",
					"desc" => "",
					"id" => "theme_updater",
					"std" => "<h3 style='margin: 0;'>You are on the latest version!</h3>",
					"icon" => true,
					"type" => "info");
	}
} else {
	$of_options[] = array( "name" => "Theme Updater",
				"desc" => "",
				"id" => "theme_updater",
				"std" => "<h3 style='margin: 0;'>Enter Username and Secret API key below!</h3>",
				"icon" => true,
				"type" => "info");
}

$of_options[] = array( "name" => "ThemeForest Username",
					"desc" => "",
					"id" => "tf_username",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "ThemeForest Secret API Key",
					"desc" => "You can create one from ThemeForest's user settings page.",
					"id" => "tf_api",
					"std" => "",
					"type" => "text");


$of_options[] = array( "name" => "Upgrade to the most latest version",
					"desc" => "If checked, the theme will be updated to the latest version available. ",
					"id" => "tf_update",
					"std" => 0,
					"type" => "checkbox");
*/
					
	}
}
?>
