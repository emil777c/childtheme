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
</style>


<main id="content" <?php post_class( 'site-main' ); ?> role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<header class="page-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>
	<div class="page-content">
		<?php the_content(); ?>
	<main id="mainn" class="site-main" role="main">
<section class="first_section">
    <div class="section_wrapper">
        <p>Se vores udvalg</p>
    </div>

</section>
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

            <div class="button_wrapper">
            <nav id="filtrering"></nav>
            </div>
            <section id="container">
            </section>
            
			 </main><!-- #main --> 
	
	<script>
        let menuer;
        let categories;
        let filterMenu = "alle";
        const url = "https://emiltoft.dk/kea/10_eksamen/wordpress/wp-json/wp/v2/menu?per_page=100";
        const catUrl = "https://emiltoft.dk/kea/10_eksamen/wordpress/wp-json/wp/v2/categories?per_page=100";



        async function hentData() {
        const respons = await fetch(url);
        const catrespons = await fetch(catUrl);
        menuer = await respons.json();
        categories = await catrespons.json();
        console.log(menuer);
       visMenuer();
       opretKnapper();
       opretTitel();
        }

		function opretKnapper() {
            categories.forEach(cat => {
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-menu="${cat.id}">${cat.name}</button>`
            })
            addEventListenersToButtons();
        }


        function addEventListenersToButtons() {
            document.querySelectorAll("#filtrering button").forEach(elm =>{
                elm.addEventListener("click", filtrering);
            })
        };

        function filtrering(){
            filterMenu = this.dataset.menu;
            console.log(filterMenu);

            visMenuer();
        }


		function visMenuer() {
         const container = document.querySelector("#container");
        const template = document.querySelector("template");
        container.innerHTML = "";


        menuer.forEach((menu) => {
            if ( filterMenu == "alle" || menu.categories.includes(parseInt(filterMenu))) {
        // Tjek hvilket verdensmål projektet har, sammenlign med aktuelt filter eller hvis filter har værdien "alle" så vis alle
                let klon = template.cloneNode(true).content;

                // Tilføjer elementer fra Jason til template
                klon.querySelector(".billede").src = menu.billede.guid;
                klon.querySelector(".titel").textContent = menu.title.rendered;
                klon.querySelector(".beskrivelse").textContent = menu.beskrivelse;
                klon.querySelector(".allergener").textContent = menu.allergener;
				klon.querySelector(".pris").textContent =
              "Pris: " + menu.pris + " ,-";
                klon.querySelector("article").addEventListener("click", () => {location.href = menu.link; })

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
