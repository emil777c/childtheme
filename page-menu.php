<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php
while ( have_posts() ) :
	the_post();
	get_header();
	
	?>
	<head>
		<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Arima+Madurai:wght@100;200;300;400;500;700;800;900&display=swap" rel="stylesheet">

	</head>

<style> 
	@media (min-width: 600px) {
    #container {
    /* desktop vises article i et grid med kolloner af 3 - data ligger sig under hinanden*/
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-template-rows: auto;
    gap: 20px;
  }
}
#container {
    margin: 30px;
}

article {
	padding: 20px;
	text-align: center;

}

button {
	border: none;
	background-color: #FEFCF3;
	color: black;
}

button:hover {
	border: 2px black solid;
	color: black;
	background-color: #FEFCF3;
}

li:hover {
	border: 1px black solid;
	color: black;
}

#filtrering {
	text-align: center;
	font-family: 'Arima Madurai', cursive;
}


.entry-title {
	text-align: center;
	font-family: 'Arima Madurai', cursive;
}

h3, p {
	font-family: 'Arima Madurai', cursive;
}

.data-menu {
	background-image: url(drikkevarer.png);
}

.site-footer {
display: none;
}

.filter {
	background-color: #FEFCF3;
}

@font-face {
  font-family: "silom";
  src: url(http://emiltoft.dk/kea/10_eksamen/wordpress/wp-content/themes/childtheme/fonts/silom.tff;);
  font-weight: normal;
}







</style>


<header>


<main id="content" <?php post_class( 'site-main' ); ?> role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		
		<header class="page-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>
	<div class="page-content">
		<?php the_content(); ?>
	<main id="mainn" class="site-main" role="main">


<!-- Section til artikel i loopview -->
	


    <template>
        <article class="first_article">
          <img class="billede" src="" alt="" />
          <h3 class="titel"></h3>
          <p class="beskrivelse"></p>
          <p class="allergener"></p>
		  <p class="pris"></p>
        </article>
      </template>

	<div id="primary" class="content-area">
<!-- Div container til filtreringsknapper i menuen -->
            <div class="button_wrapper">
            <nav id="filtrering"></nav>
            </div>
			<hr>
            <section id="container">
            </section>

	<section id="footer">

	</section>
            
			 </main><!-- #main --> 
	
	<script>

        //Variabler der bruges i funktioner//
        let menuer;
        let categories;
        let filterMenu = "alle";
        const url = "https://emiltoft.dk/kea/10_eksamen/wordpress/wp-json/wp/v2/menu?per_page=100";
        const catUrl = "https://emiltoft.dk/kea/10_eksamen/wordpress/wp-json/wp/v2/categories?per_page=100";


        //Funktion som dynamisk henter indhold fra Wordpress REST API // 
        async function hentData() {
        const respons = await fetch(url);
        const catrespons = await fetch(catUrl);
        menuer = await respons.json();
        categories = await catrespons.json();
        console.log(menuer);
       visMenuer();
       opretKnapper();
        }
		
        //Opsættelse af filtreringsknapper. Henviser bl.a. til en variabel//
		function opretKnapper() {
            categories.forEach(cat => {
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-menu="${cat.id}">${cat.name}</button>`
            })
            addEventListenersToButtons();
        }

        //Click funktion til knapper, som henviser til funktionen "filterering"//
        function addEventListenersToButtons() {
            document.querySelectorAll("#filtrering button").forEach(elm =>{
                elm.addEventListener("click", filtrering);
            })
        };
      //Funktion som filtrere efter datasættet når man har klikket på en knap. Derefter kalder den visMenuer//
        function filtrering(){
            filterMenu = this.dataset.menu;
            console.log(filterMenu);

            visMenuer();
        }

        //Funktion vis menuer der sørger for, at hvert element får titel, billede, beskrivelse osv//
		function visMenuer() {
         const container = document.querySelector("#container");
        const template = document.querySelector("template");
        container.innerHTML = "";
        menuer.forEach((menu) => {
            //ParseINT der gør vi får kategorierne til at være et tal fremfor tekst//
            if ( filterMenu == "alle" || menu.categories.includes(parseInt(filterMenu))) {
                let klon = template.cloneNode(true).content;
                klon.querySelector(".billede").src = menu.billede.guid;
                klon.querySelector(".titel").textContent = menu.title.rendered;
                klon.querySelector(".beskrivelse").textContent = menu.beskrivelse;
                klon.querySelector(".allergener").textContent = menu.allergener;
				klon.querySelector(".pris").textContent = menu.pris + " ,-";
                

      // Tilføjer variablen klon som child af variablen container
      container.appendChild(klon);
         }
  })
    }

		hentData();

	</script>

	

		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
		</div>
		<?php wp_link_pages(); ?>
	</div>

	<?php comments_template(); ?>
</main>

	<?php
	get_footer();
endwhile;
?>
