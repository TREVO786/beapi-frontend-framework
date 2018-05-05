include ../mixins/svg-icon.pug

doctype html
html.fonts-loading.no-js(lang='fr')
    head
        title BeAPI FrontEnd Framework | The WordPress BFF
        include ../partials/_head-meta
        include ../partials/_head-favicon
        include ../partials/_head-assets

    body.home
        include ../partials/_header.pug

        main#main__content.main__content(role="main" tabindex="-1" aria-label="Contenu Principal")
            article.entry
                div.container
                    header.entry__header
                        h1.entry__title Welcome to the BFF
                        <?php echo get_the_post_thumbnail( 0, 'thumbnail', array( 'data-location' => 'entry-img-01', 'class' => 'entry__img', 'alt' => '#' ) ); ?>
                        
                    section.entry__content
                        p This a starter theme so it's empty. <br> Minimum pages are listed in the menu above. It's a base that you have to custom on your need.
                        p You can use <a href="https://github.com/BeAPI/beapi-frontend-framework/#composer-js">Composer JS</a> in order to add <a href="https://github.com/BeAPI/bff-components" target="_blank" title="See components">well known components</a> (html, css or js) like comments, widgets, plugins etc.
                        h2 🦄 Happy Coding ! 🦄

        include ../partials/_footer.pug