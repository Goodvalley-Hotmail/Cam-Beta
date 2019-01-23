**BETA 0.27**

- Hem afegit front-page.php, usant un Flexible Content i el codi natiu de WordPress per a les MetaDades (`get_post_meta() i switch()`).

- Hem afegit el Flexible Content de l'anterior punt a /ACF Exports/v14/.

- `/lib/functions/autoload.php` -> Línia 27
    
    Hem comentat la línia 27, que carrega `term-meta-locations.php`
    
- A les Entrades de tots els CPT's, hem convertit l'ski-domain en Link.

- Els Slope Maps seran de dos tipus: Full i Thumbnail. Ambdós es mostraran en Full Size,
per tant hem de crear un tamany petit per al Thumbnail a cada mapa.
Hem suprimit els tamanys 200x109, 250x136 i 300x163.

    - /lib/setup.php -> El·liminats 200, 250 i 300.
    Només hem comentat la línia 28 -> add_new_image_sizes();
    Només hem fet això ja que no calia cap dels tamanys però volíem conservar la funció per saber com funciona.
    - /lib/partials/archive-ski-resort/ski-resort-entry-section-left.php -> Hem conservat les funcions, però comentades.
    - /lib/partials/overview/slopes-map.php -> Hem conservat les funcions, però comentades.
    
- /lib/partials/overview/snow-depth-elevation/snow-depth-elevation-meta.php

    Hem declarat les variables per a cada cas abans del $count_variable_xxx per assegurar-nos de que es mostren totes les dades.
    
- /taxonomy-locations.php

    * Hem el·liminat tot el codi que servia per mostrar WebCams i Weather Forecasts.
    
    * Hem afegit banners-links per a les WebCams i la Meteo de cada resultat de la Query.
    
- single-ski-resort.php

    * Hem canviat de lloc el partial de les pistes afegides, conservant l'antiga ubicació comentada.
    
- archive-ski-resort.php

    * Hem creat una Archive Template sense Aside que podem traslladar a tots els altres CPT's.

**F A L T E N :**

- Els BreadCrumbs que no estan encadenats.
- A taxonomy-locations.php falta posar els Ski Domains.
- Falten els textos tant a singles com a archives.

