<?php
/**
 * Description
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://cameraski.com
 * @license     GNU General Public License 2.0+
 */

namespace CameraSki;

/**
 * APUNTS
 *
 * https://stackoverflow.com/questions/34761970/schema-org-json-ld-reference/34776122#34776122
 * Buscar aquest mateix link més abaix per llegir els apunts i mirar el codi.
 *
 * https://webmasters.stackexchange.com/questions/98556/what-is-the-correct-way-to-use-the-collectionpage-type-for-a-category-page
 * Thing->CreativeWork->WebPage->ItemPage
 * A Page devoted to a single Item, such as a particular Product or Hotel.
 * És a dir, sustituïm WebPage per ItemPage.
 *
 * significantLink is for URL values.
 * hasPart is for CreativeWork values.
 *
 * https://productforums.google.com/forum/#!topic/webmasters/FeIwzt76Nzo
 * Google no t'inclourà als rich snippets per a product schema si el producte no es pot adquirir o contractar al teu Web.
 * Si per fer-ho has d'anar a un altre Site, no pots.
 *
 * Podem utilitzar http://schema.org/WebPage Aquest Schema inclou Property Tags com:
 *      mainContentOfPage: Hotel o SkiResort
 *      relatedLink: la URL del lloc que tractem
 *      reviewedBy: CameraSki o l'autor individual
 * Dins de l'Schema WebPage podem també anidar els Schemas SkiResort o Hotel directament sota mainContentOfPage.
 * També hauríem d'incloure els Schemas Review o aggregateRating si les reviews fossin obtingudes directament d'usuaris.
 *
 * Si usem l'Schema Product i incloem markup pel preu o rang de preus i potser un rating, Google probablement ens
 * donarà un rich snippet.
 *
 * https://webmasters.stackexchange.com/questions/98569/what-is-the-use-of-id-in-json-ld-syntax/98578#98578
 * Buscar aquest mateix link més abaix per llegir els apunts i mirar el codi.
 *
 * JSON-LD No schema, simplement JSon LD
 * https://www.youtube.com/watch?v=UmvWk_TQ30A
 * Hi ha 2 tipus de dades: objectes i dades.
 *      OBJECTES:
 *      {
 *      @context: {...},
 *      @type: Person,
 *      name: Janette,
 *      ...
 *      }
 *
 *      DADES:
 *      {
 *      @context: {...},
 *      @type: Person,
 *      name: Janette,
 *      "birthday": {
 *          "@value": "2000-01-01",
 *          "type": "xsd:date"
 *          }
 *      ...
 *      }
 *
 * De vegades, necessitem posar les dades de manera més simplificada, per exemple, posar sempre el birthday de la
 * mateixa manera. Ho farem utilitzant el context:
 *
 *      Type Coertion
 *          context
 *
 *              "birthday": {
 *                  "@id": "http://schema.org/birthday",
 *                  "@type": "xsd:date"
 *              }
 *          ...............................
 *          body
 *              ...
 *              "birthday": "2000-01-01",
 *              ...
 *          Aquí hem afegit un tipus de dada al Term definition: li diem que "birthday" serà sempre una dada del tipus xsd:date.
 *          Així, quan el desenvolupador posi "birthday": "2000-01-01", el sistema sabrà que aquest valor serà de tipus xsd:date.
 *
 * Com construïm Links (relacions) en JSON+LD
 * Exemple:
 *      Natasha coneix Boris
 *      A Boris li agrada Nikita
 *      Sergei és el germà de Boris
 * Tenim dues maneres principals de representar això:
 *
 *  EMBEDDING
 *  We embed an Object in another Object, and tie them together in some kind of relationship.
 *
 *      {
 *          @context: {...},
 *          name: Natasha
 *          "knows": {
 *              name: Boris
 *          }
 *      }
 *      The outer Object is named "Natasha".
 *      We create a "knows" relationship with the Object named "Boris".
 *      We create this link "Natasha knows Boris" is by embedding Boris Object inside Natasha Object.
 *
 *  REFERENCING
 *  We use an URL in the place we want to link to.
 *
 *      {
 *      @context: {...},
 *          name: Natasha
 *          "knows": "http://people.org/boris"
 *      }
 *      We say: Natasha knows... and then we put an URL instead of embedding. This is called "referencing" in JSON+LD.
 *      So "knows" will be always related to that URL.
 *
 *  KEYWORD ALIASING
 *  This consists in taking the JSON-LD Keywords and aliase them.
 *      "id": "@id",
 *      "type": "@type",
 *      "url": "@id",
 *
 * ******************************************************************************************************************
 *
 *

<?php
/* ******************************************************************************************************************
 * https://stackoverflow.com/questions/36117596/microdata-markup-with-mainentityofpage-for-google-article-rich-snippet/36117597#36117597
 *
 * schema.org's mainEntityOfPage Property expects as value either an URL or a CreativeWork item.
 * Google says they expect an URL value.
 *
 * If we want to provide an URL value:
 *  <link itemprop="mainEntityOfPage" href="https://example.com/article" />
 * cameraski.com:
 *  <link itemprop="mainEntityOfPage" href="https://cameraski.com/ski-resort/baqueira-beret/" />
 * This follows Google's own recommendation, requires minimal markup and works in the head as well as in the body.
 * If you have a visible link, you can of course also an a element.
 *
 * If we want to provide an Item value:
 *  <div itemprop="mainEntityOfPage" itemscope itemtype="http://schema.org/WebPage">
 *      <link itemprop="url" href="https://example.com/article" />
 *  </div>
 * cameraski.com:
 *  <div itemprop="mainEntityOfPage" itemscope itemtype="http://schema.org/ItemPage">
 *      <link itemprop="url" href="https://cameraski.com/ski-resort/baqueira-beret/" />
 *  </div>
 * This creates a WebPage Item with an URL Property. It can only be used in the body.
 * If you have a visible link, you can of course also an a element.
 *
 *
 *
 * ******************************************************************************************************************
 *
 * ERRORS
 *
 * - Authors use a SiteNavigationElement for each navigation link (not for the whole navigation)
 * or a single SiteNavigationElement with multiple name/url properties (not for the name/URL of the navigation,
 * but of the navigation entries).
 *
 * - Authors provide the website title as name of WPHeader (because their CMS/Theme added it automatically)
 * instead of WebPage/WebSite.
 *
 * - The mainContentOfPage property expects a WebPageElement as value.
 * I think this never really worked in practice, because authors want to say something about the entities like blog posts, articles, etc.
 * that form the main content, not the actual HTML element that contains it.
 * And after introducing mainEntity, I think there’s no need to have/redefine mainContentOfPage anymore .
 */

/**
 * single-ski-resort.php
 *
 * mainEntityOfPage / mainEntity Properties
 * Many Pages have a primary topic an entity or thing that the Page describes.
 * A restaurant's Home Page is primarily about that restaurant, or an event listing Page may represent a single event.
 * The mainEntity and mainEntityOfPage express the relationship between the Page and the primary Entity.
 * Related Properties include sameAs, about and url.
 *      sameAs and url are both similar to mainEntityOfPage.
 *      The url Property should be reserved to refer to more official or authoritative Web Pages, such as the Item's
 *      official WebSite.
 *      The sameAs Property also relates a thing to a Page that indirectly identifies it.
 *      Whereas sameAs emphasises well known Pages, the mainEntityOfPage Property serves more to clarify which of
 *      several Entities is the main one for that Page.
 * mainEntityOfPage can be used for any Page, including those not recognized as authoritative for that Entity.
 * For example, for a Product, sameAs might refer to a Page on the manufacturer's official Site with specs for the
 * Product, while mainEntityOfPage might be used on Pages within various retailers Sites giving details for the same
 * Product.
 */
?>

	<body class="..." itemscope itemtype="https://schema.org/WebPage">
		<header class="..." itemscope itemtype="https://schema.org/WPHeader">
			<p class="site-title" itemprop="headline">
				<a href="https://cameraski.com/">
					<img src=".../logo.png">
					<span class="screen-reader-text">Beta 01</span>
				</a>
			</p>
		</header>
		<div class="site-inner" role="main" itemprop="mainContentOfPage">
			<article class="..." itemscope itemtype="http://schema.org/SkiResort">
				<header class="entry-header">
					<h1 class="entry-title" itemprop="name">
	                    <span class="logo-overview">
	                        <img class="..." src="..." itemprop="logo">
	                    </span>
					</h1>
				</header>
				<div class="entry-content" itemprop="text">
				</div>
			</article>
		</div>
		<footer class="site-footer" itemscope itemtype="https://schema.org/WPFooter"></footer>
	</body>

<?php

/**
 * http://www.seoskeptic.com/how-to-use-schema-org-v2-0s-mainentityofpage-property/
 *
 * A Restaurant's HomePage might be primarily about that Restaurant, or an Event Listing Page might represent a single Event.
 * The mainEntity and mainEntityOfPage properties allow us to explicitly express the relationship between the Page and
 * the primary Entry.
 */
?>

<div itemscope itemtype="http://schema.org/Restaurant" itemid="#thecafe">
    <a itemprop="mainEntityOfPage" href="http://cathscafe.example.com/"><h1 itemprop="name">Cath's Cafe</h1></a>
    <p>Open: <time itemprop="openingHours" datetime="Mo, Tu, We, Th, Fr, Sa, Su 11:00-20:00">Daily from 11:am till 8pm</time></p>
    <p>Phone: <span itemprop="telephone" content="+155501003344">555-0100-3344</span></p>
    <p>View <a itemprop="menu" href="/menu">our menu</a>.</p>
</div>

<?php
/**
 * ACME Corporation shows its Products on its Product Listing Pages, and because of this each of the Products listed on
 * those Pages probably contain some markup like this:
 */
?>
<li itemscope itemtype="http://schema.org/Product">
    <a itemprop="url" href="http://example.com/explosive-tennis-balls/"><span itemprop="name">Explosive Tennis Balls</span></a>
    ...
    <!-- By specifying the Product URLs, we are not only telling the Search Engines where the Products can be found,
    but that we are also telling them they can be found on a http://schema.org/WebPage -->
</li>

<body itemscope itemtype="http://schema.org/WebPage">
    <aside>
        <section itemscope itemtype="http://schema.org/Event">
            <h2 itemprop="name">Acme Product Launch</h2>
            ...
        </section>
    </aside>
    <main>
        <article itemscope itemtype="http://schema.org/Product">
            <h1 itemprop="name">Explosive Tennis Balls</h1>
            ...
        </article>
    </main>
</body>
<!-- Here, we have 3 top-level entities: -->
<!-- schema.org/WebPage -->
<!-- schema.org/Event -->
<!-- schema.org/Product -->

<!-- The solution: -->
<html>
    <head>
        <link rel="canonical" href="http://example.com/explosive-tennis-balls/">
    </head>
    <body itemscope itemtype="http://schema.org/WebPage">
        <aside>
            <section itemscope itemtype="http://schema.org/Event">
                <h2 itemprop="name">Acme Product Launch</h2>
                ...
            </section>
        </aside>
        <main>
            <article itemscope itemtype="http://schema.org/Product">
                <h1 itemprop="name">Explosive Tennis Balls</h1>
                <link itemprop="mainEntityOfPage" href="http://example.com/explosive-tennis-balls/">
                ...
            </article>
        </main>
    </body>
</html>
<!-- Now, we have 2 top-level entities and one second-level: -->
<!-- schema.org/WebPage >> schema.org/Product(mainEntityOfPage) -->
<!-- schema.org/Event -->
<!-- The same, with inverse order of items and mainEntity: -->
<html>
    <head>
        <link rel="canonical" href="http://example.com/explosive-tennis-balls/">
    </head>
    <body itemscope itemtype="http://schema.org/WebPage">
        <main>
            <article itemprop="mainEntity" itemscope itemtype="http://schema.org/Product">
                <h1 itemprop="name">Explosive Tennis Balls</h1>
                ...
            </article>
        </main>
        <aside>
            <section itemscope itemtype="http://schema.org/Event">
                <h2 itemprop="name">Acme Product Launch</h2>
                ...
            </section>
        </aside>
    </body>
</html>

We want to make a 'mainEntity' relation a schema.org/Thing (S) (a schema.org/Article) has to be a direct child of the
schema.org/WebPage (O) to be able to express:
(O)WebPage >> (p)mainEntity >> (S)Article

But in real life, it often happens that (S) is nested within another thing (O), let's say a schema.org/LocalBusiness,
due to the order of the HTML. In this situation, we have 3 top-level entities:
(O)WebPage
(O)LocalBusiness
(O)Article

With mainEntity, due to the Article being originally nested in the LocalBusiness, we get:
(O)WebPage
(O)LocalBusiness >> (p)mainEntity >> (S)Article

With mainEntityOfPage, we can express:
(O)WebPage
(O)Article >> (p)mainEntityOfPage >> (S)WebPage

<html>
    <body itemscope itemtype="http://schema.org/WebPage">
        <link rel="canonical" href="http://example.com/explosive-tennis-balls/">
        <aside>
            <section itemscope itemtype="http://schema.org/Event">
                <h2 itemprop="name">Acme Product Launch</h2>
                ...
            </section>
        </aside>
        <main itemscope itemtype="http://schema.org/LocalBusiness">
            <article itemprop="mainEntity" itemscope itemtype="http://schema.org/Article">
                <h1 itemprop="name">Explosive Tennis Balls</h1>
                <link itemprop="mainEntityOfPage" href="http://example.com/explosive-tennis-balls/">
                ...
            </article>
        </main>
    </body>
</html>

<!-- *********************************************************************************************************** -->
<?php

/**
 * http://www.seoskeptic.com/how-to-use-schema-org-v2-0s-mainentityofpage-property/#comment-98241
 * I got more out of this article than the 10 others I have read on Schema.
 * My website is for a Real Estate Agency. I have my home page set to Local Business.
 * On my website, I use the GeoDirectory Plugin to list schools, services providers, and places to visit in directories.
 * What schema would you recommend for the directory listings?
 * I am not sure if it would be schools, local businesses, and places as the mainContentOfPage for each
 * listing or if it they all should be labeled as articles or blog posts about them. What do you recommend?
 *
 * For listing pages I would use a schema.org/ItemList that contains the local businesses/schools/etc as their mainEntity.
 */
?>



<?php
/*********************************************************************************************************************/
/**
 * archive-ski-resort.php
 */
?>



<?php
/*********************************************************************************************************************/
/**
 * taxonomy-locations.php
 */
?>



<?php
/*********************************************************************************************************************/
/**
 * http://www.seoskeptic.com/how-to-use-schema-org-v2-0s-mainentityofpage-property/
 * This should work for single-ski-resort.php
 */
?>

<html>
	<head>
		<link rel="canonical" href="https://cameraski.com/ski-resort/baqueira-beret/">
	</head>
	<body itemscope itemtype="http://schema.org/WebPage">
		<aside>
			<section itemscope itemtype="http://schema.org/Event">
				<h2 itemprop="name">Atomic Ski Launch</h2>
				...
			</section>
		</aside>
		<main>
			<article itemscope itemtype="http://schema.org/SkiResort">
				<h1 itemprop="name">Baqueira-Beret</h1>
				<link itemprop="mainEntityOfPage" href="https://cameraski.com/ski-resort/baqueira-beret/">
				...
			</article>
		</main>
	</body>
</html>

<html>
	<head>
		<link rel="canonical" href="https:cameraski.com/ski-resort/baqueira-beret/">
	</head>
	<body itemscope itemtype="http://schema.org/WebPage">
		<main>
			<article itemprop="mainEntity" itemscope itemtype="http://schema.org/SkiResort">
				<h1 itemprop="name">Baqueira-Beret</h1>
				...
			</article>
		</main>
		<aside>
			<section itemscope itemtype="http://schema.org/Event">
				<h2 itemprop="name">Atomic Ski Launch</h2>
				...
			</section>
		</aside>
	</body>
</html>

<?php
/*********************************************************************************************************************/
/**
 * https://webmasters.stackexchange.com/questions/98556/what-is-the-correct-way-to-use-the-collectionpage-type-for-a-category-page
 * Traslladat a cameraski.com -> Faltaria canviar significantLinks a ItemList.
 *
 * DISCUSSION
 * We could use significantLink (for URL values) or hasPart (for CreativeWork values).
 * But hasPart is better because significantLink can be used for Pages that don't belong to the Category (so for consumers
 * it isn't clear that these are Category Items, and hasPart allows you to provide MetaData (in case you need it on the
 * Category Page).
 * A better option could be mainEntity ItemList.
 * It makes clear that the list is the primary Entity of the CollectionPage, so for consumers it's probably clear that
 * this is the collection.
 */
?>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "CollectionPage",
    "url": "https://cameraski.com/ski-resorts/",
    "mainEntity":
    {
        "@type": "CollectionPage",
        "significantLinks":
        [
            "https://cameraski.com/ski-resorts/europe",
            "https://cameraski.com/ski-resorts/north-america"
        ]
    }
}
</script>

<?php
/*********************************************************************************************************************/
/**
 * https://builtvisible.com/micro-data-schema-org-guide-generating-rich-snippets/
 */
?>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "ItemPage",
    "name": "Baqueira-Beret",
    "offers": {
        "@type": "AggregateOffer",
        "lowPrice": "[lowest product price]",
        "highPrice": "[highest product price]",
        "priceCurrency": "[currency in 3 letter ISO 4217 format, like EUR or USD]",
    },
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "[rating]",
        "reviewCount": "[number of reviews]",
    },
    "review": [
        {
        "@type": "Review",
        "name": "[review title/summary]",
        "author": "[name of the reviewer]",
        "datePublished": "[date in ISO format e.g. 2012-04-15]",
        "description": "[the actual user review text]",
        "reviewRating": {
            "@type": "Rating",
            "bestRating": "[highest possible rating]",
            "ratingValue": "[rating given by the reviewer]",
            "worstRating": "lowest possible rating",
            }
        }
    ]
}
</script>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Review",
    "itemReviewed": "Baqueira-Beret",
    "reviewRating": {
        "@type": "Rating",
        "bestRating": "[best rating]",
        "worstRating": "[worst rating]",
        "ratingValue": "[rating received]"
    },
    "datePublished": "[date in ISO format e.g. 2012-04-15]",
    "author": "CameraSki",
    "offers": {
        "@type": "AggregateOffer",
        "lowPrice": "[lowest product price]",
        "highPrice": "[highest product price]",
        "priceCurrency": "[currency in 3 letter ISO 4217 format e.g. USD or EUR]"
    }
}
</script>

<?php
/*********************************************************************************************************************/
/**
 * view-source:https://thenextweb.com/twitter/2016/08/04/twitters-new-ad-format-sounds-lot-like-legitimizing-clickbait/
 */
?>

<script type="application/ld+json">
{
	"@context":"http:\/\/schema.org",
	"@id":"#Breadcrumb",
	"@type":"BreadcrumbList",
	"itemListElement":
	[
		{
			"@type":"ListItem",
			"position":1,
			"item":
			{
				"@id":"https:\/\/thenextweb.com\/",
				"name":"Home"
			}
		},
		{
			"@type":"ListItem",
			"position":2,
			"item":
			{
				"name":"Twitter",
				"@id":"https:\/\/thenextweb.com\/twitter"
			}
		},
		{
			"@type":"ListItem",
			"position":3,
			"item":
			{
				"@id":"https:\/\/thenextweb.com\/twitter\/2016\/08\/04\/twitters-new-ad-format-sounds-lot-like-legitimizing-clickbait\/",
				"name":"Twitter&#8217;s new ad format sounds a lot like legitimizing clickbait"
			}
		}
	]
}
</script>
<!-- JSON-LD cached: no-->
<script type="application/ld+json">
[
	{
		"@context":"http:\/\/schema.org",
		"@id":"http:\/\/data.thenextweb.com\/tnw\/post\/twitters_new_ad_format_sounds_a_lot_like_legitimizing_clickbait",
		"@type":"NewsArticle",
		"description":"Twitter is introducing a new type of ad today called Instant Unlock Cards. They sound great for brands, but\u00a0pretty\u00a0sucky for users.\r\n\r\nHere's the gist of it: A brands tweets out a ...",
		"mainEntityOfPage":
		{
			"@type":"WebPage",
			"@id":"https:\/\/thenextweb.com\/twitter\/2016\/08\/04\/twitters-new-ad-format-sounds-lot-like-legitimizing-clickbait\/",
			"breadcrumb":
			{
				"@id":"#Breadcrumb"
			}
		},
		"image":
		{
			"@type":"ImageObject",
			"url":"https:\/\/cdn0.tnwcdn.com\/wp-content\/blogs.dir\/1\/files\/2016\/02\/Twitter-520x245.jpg",
			"width":1852,
			"height":926
		},
		"headline":"Twitter's new ad format sounds a lot like legitimizing clickbait",
		"datePublished":"2016-08-04T15:18",
		"dateModified":"2016-08-04T15:18",
		"wordCount":284,
		"publisher":
		{
			"@type":"Organization",
			"@id":"http:\/\/data.thenextweb.com\/tnw\/entity\/the_next_web",
			"name":"The Next Web",
			"sameAs":
			[
				"https:\/\/en.wikipedia.org\/wiki\/The_Next_Web",
				"https:\/\/www.facebook.com\/thenextweb",
				"https:\/\/www.twitter.com\/thenextweb",
				"https:\/\/plus.google.com\/+TheNextWeb\/",
				"https:\/\/instagram.com\/thenextweb",
				"https:\/\/www.youtube.com\/user\/thenextweb",
				"https:\/\/www.pinterest.com\/thenextweb\/",
				"https:\/\/www.linkedin.com\/company\/the-next-web",
				"https:\/\/vine.co\/thenextweb",
				"https:\/\/thenextweb.tumblr.com",
				"https:\/\/soundcloud.com\/thenextweb",
				"https:\/\/vimeo.com\/thenextweb",
				"https:\/\/vk.com\/thenextweb",
				"https:\/\/www.slideshare.net\/thenextweb",
				"https:\/\/flipboard.com\/@thenextweb",
				"https:\/\/storify.com\/thenextweb",
				"https:\/\/www.stumbleupon.com\/channel\/thenextweb",
				"https:\/\/www.flickr.com\/photos\/thenextweb\/",
				"https:\/\/foursquare.com\/thenextweb"
			],
			"logo":
			{
				"@type":"ImageObject",
				"url":"https:\/\/cdn1.tnwcdn.com\/wp-content\/blogs.dir\/1\/files\/2016\/06\/tnw-logo-amp.png",
				"width":284,
				"height":60
			}
		},
		"author":
		{
			"@type":"Person",
			"@id":"http:\/\/data.thenextweb.com\/tnw\/user\/napierlopez",
			"name":"Napier Lopez",
			"url":"https:\/\/thenextweb.com\/author\/napierlopez\/"
		},
		"articleSection":"Twitter",
		"dateCreated":"2016-08-04T15:18",
		"name":"Twitter\u2019s new ad format sounds a lot like legitimizing clickbait",
		"url":"https:\/\/thenextweb.com\/twitter\/2016\/08\/04\/twitters-new-ad-format-sounds-lot-like-legitimizing-clickbait\/",
		"articleBody":"Twitter is introducing a new type of ad today called Instant Unlock Cards.
		 They sound great for brands, but\u00a0pretty\u00a0sucky for users.\r\n\r\nHere's the gist of it: A brands tweets out a teasing image - say, for a movie trailer.
		 Want to read or see more? Sorry, you have to tweet out #something first.
		 Then the full trailer will be unlocked.\r\n\r\nhttps:\/\/twitter.com\/TwitterAds\/status\/761197563383050241\r\n\r\nIt's a lot like those awful &quot;
		 share to see more&quot; promotions on Facebook.\r\n\r\nYou could argue that this isn't clickbait, as brands\u00a0aren't necessarily\u00a0deceiving you about what lies after you share the tweet.
		 The thing is, many probably will. As far as we can tell, Twitter isn't putting any checks in place to make sure the unlocked content remains true to the original promise.
		 \r\n\r\nBut perhaps a the\u00a0bigger issue is\u00a0that brands don't have to actually earn your share.
		 They could promise you a cool trailer, but what if it ends up being completely dull and boring?
		 Well, it doesn't matter - you've already retweeted the brand's message.
		 Sure, you could delete your tweet after watching, but\u00a0who's actually going to do that?\r\n\r\nI'm not saying everything brands do with Instant Unlock Cards will be clickbait;
		 providing exclusive content on specific platforms is fairly standard.
		 Brands that have tested the cards have seen higher earned impressions (although again, I'd question whether they've been truly 'earned').
		 \r\n\r\nNor am I\u00a0saying I have a better alternative off the top off my head.
		 But effectively legitimizing clickbait doesn't sound like the right approach to me.
		 \r\n\r\nWe've contacted Twitter for more information about whether it has checks in place to avoid clickbait, and will update if we hear back.",
		 "copyrightYear":"2016",
		 "sourceOrganization":
		 {
		    "@id":"http:\/\/data.thenextweb.com\/tnw\/entity\/the_next_web"
		 },
		 "copyrightHolder":
		 {
		    "@id":"http:\/\/data.thenextweb.com\/tnw\/entity\/the_next_web"
		 },
		 "interactionStatistic":
		 [
		    {
		        "@type":"InteractionCounter",
		        "interactionService":
		        {
		            "@type":"Website",
		            "name":"Twitter",
		            "url":"http:\/\/www.twitter.com"
		        },
		        "interactionType":"https:\/\/schema.org\/ShareAction",
		        "userInteractionCount":"283"
		    },
		    {
		        "@type":"InteractionCounter",
		        "interactionService":
		        {
		            "@type":"Website",
		            "name":"Facebook",
		            "url":"http:\/\/www.facebook.com"
		        },
		        "interactionType":"https:\/\/schema.org\/ShareAction",
		        "userInteractionCount":"68"
		    },
		    {
		        "@type":"InteractionCounter",
		        "interactionType":"https:\/\/schema.org\/CommentAction",
		        "userInteractionCount":"0"
		    }
		 ]
	}
]
</script>

<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 * https://builtvisible.com/implementing-json-ld-wordpress/
 */
?>

<?php // JSON-LD for Wordpress Home Articles and Author Pages written by Pete Wailes and Richard Baxter
function get_post_data() {
    global $post;
    return $post;
}

// stuff for any page
$payload["@context"] = "http://schema.org/";

// this has all the data of the post/page etc.
$post_data = get_post_data();

// stuff for any page, if it exists
$category = get_the_category();
// stuff for specific pages
if ( is_single() ) {
    // this gets the data for the user who wrote that particular item
    $author_data        = get_userdata( $post_data->post_author );
    $post_url           = get_permalink();
    $post_thumb         = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
    $payload["@type"]   = "Article";
    $payload["url"]     = $post_url;
    $payload["author"]  = array(
        "@type" => "Person",
        "name"  => $author_data->display_name,
    );
    $payload["headline"]        = $post_data->post_title;
    $payload["datePublished"]   = $post_data->post_date;
    $payload["image"]           = $post_thumb;
    $payload["ArticleSection"]  = $category[0]->cat_name;
    $payload["Publisher"]       = "Builtvisible";
}

// we do all this separately so we keep the right things for organization together
if ( is_front_page() ) {
    $payload["@type"]   = "Organization";
    $payload["name"]    = "Builtvisible";
    $payload["logo"]    = "http://builtvisible.com/wp-content/uploads/2014/05/BUILTVISIBLE-Badge-Logo-512x602-medium.png";
    $payload["url"]     = "http://builtvisible.com/";
    $payload["sameAs"]  = array(
        "https://twitter.com/builtvisible",
        "https://www.facebook.com/builtvisible",
        "https://www.linkedin.com/company/builtvisible",
        "https://plus.google.com/+SEOgadget/"
    );
    $payload["contactPoint"] = array(
        array(
            "@type"         => "ContactPoint",
            "telephone"     => "+44 20 7148 0453",
            "email"         => "hello@builtvisible.com",
            "contactType"   => "sales"
        )
    );
}

if ( is_author() ) {
    // this gets the data for the user who wrote that particular item
    $author_data        = get_userdata($post_data->post_author);
    // some of you may not have all of these data points in your user profiles - delete as appropriate
    // fetch twitter from author meta and concatenate with full twitter URL
    $twitter_url        = " https://twitter.com/";
    $twitterHandle      = get_the_author_meta('twitter');
    $twitterHandleURL   = $twitter_url . $twitterHandle;
    $websiteHandle      = get_the_author_meta('url');
    $facebookHandle     = get_the_author_meta('facebook');
    $gplusHandle        = get_the_author_meta('googleplus');
    $linkedinHandle     = get_the_author_meta('linkedin');
    $slideshareHandle   = get_the_author_meta('slideshare');
    $payload["@type"]   = "Person";
    $payload["name"]    = $author_data->display_name;
    $payload["email"]   = $author_data->user_email;
    $payload["sameAs"]  = array(
        $twitterHandleURL,
        $websiteHandle,
        $facebookHandle,
        $gplusHandle,
        $linkedinHandle,
        $slideshareHandle
    );
}

<?php
/*********************************************************************************************************************/
/**
 * https://stackoverflow.com/questions/34761970/schema-org-json-ld-reference/34776122#34776122
 *
 * QUESTION:
 * I have a Main Event located at http://event.com/ with this markup:
 */
?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Event",
  "name": "MainEvent",
  "startDate": "2016-04-21T12:00",
  "location": {
    ...
  }
}
</script>
<?php
/**
 * Main Event has multiple Sub-Events located, for example, at http://event.com/sub-event-1/ with this markup:
 */
?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Event",
  "name": "SubEvent",
  "startDate": "2016-04-21T12:00",
  "location": {
    ...
  }
}
</script>
<?php
/**
 * I'm trying to mark up the Sub-Event as part of the Main Event.
 * Is it possible to create a reference from the Main Event to Sub-Event?
 */

/**
 * ANSWER:
 * You can identify a Node by giving it an URI, specified in the @id keyword.
 * This URI can be used to reference that node.
 * So your Main Event could get the URI http://example.com/2016-04-21#main-event with this markup:
 */
?>
<script type="application/ld+json">
{
  "@id": "http://example.com/2016-04-21#main-event",
  "@context": "http://schema.org",
  "@type": "Event",
  "name": "MainEvent",
  "startDate": "2016-04-21T12:00"
}
</script>
<?php
/**
 * You could give this URI as the value for the Sub Event's superEvent Property:
 */
?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Event",
  "name": "SubEvent",
  "startDate": "2016-04-21T12:00",
  "superEvent": {
    "@id": "http://example.com/2016-04-21#main-event"
  }
}
</script>
<?php
/**
 * Of course, you could give your Sub Event an @id too.
 * This would allow you and others to identify/reference this Sub Event.s
 */
?>

<?php
/*********************************************************************************************************************/
/**
 * https://webmasters.stackexchange.com/questions/98569/what-is-the-use-of-id-in-json-ld-syntax/98578#98578
 *
 *
 */
?>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@id": "http://www.apple.com/#organization",
    "@type": "Organization",
    "url": "http://www.apple.com/",
    "logo": "https://www.apple.com/ac/structured-data/images/knowledge_graph_logo.png?201608191052",
    "contactPoint": [
        {
            "@type": "ContactPoint",
            "telephone": "+1-800-692-7753",
            "contactType": "sales",
            "areaServed": [ "US" ]
        }
    ],
    "sameAs": [
        "http://www.wikidata.org/entity/Q312",
        "https://www.youtube.com/user/Apple",
        "https://www.linkedin.com/company/apple"
    ]
}

<?php
/*********************************************************************************************************************/
/**
 * https://moz.com/blog/search-marketers-guide-to-itemref-itemid
 * Aquest JSON-LD Markup és el de la mateixa Pàgina, no està en el contingut.
 */
?>

<script type="application/ld+json">  {
    "@context": "http://schema.org",
    "@type": "BlogPosting",
    "mainEntityOfPage":{
      "@type":"WebPage",
      "@id":"https://moz.com/blog/search-marketers-guide-to-itemref-itemid"
    },
    "headline": "The Search Marketer’s Guide to Itemref &amp; Itemid",
    "image": {
      "@type": "ImageObject",
      "url": "https://dc8hdnsmzapvm.cloudfront.net/assets/images/blog/categories/advanced-seo.png",
      "height": 440,
      "width": 880
    },
    "datePublished": "2016-07-07T00:16:00-07:00",
    "dateModified": "2016-07-07T19:30:25-07:00",
    "author": {
      "@id": "http://www.mikearnesen.com/about#arnesen"
    },
     "publisher": {
      "@type": "Organization",
      "@id": "#mozOrg",
      "name": "Moz",
      "logo": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/brand-guide/logos/moz_blue.png",
        "width": 134,
        "height": 39
      },
      "url": "https://moz.org",
      "founder": {
     		"@id": "https://moz.com/rand/about/#rand"
        }
    },
    "description": "This post is about giving you a new tool to add to your semantic SEO tool belt. My goal is to help you implement semantic markup and structured data with greater ease and enable you to create a more robust and complete web of linked data on your website (and beyond).",
    "sourceOrganization": {
    	"@id": "http://www.upbuild.io/#upbuildOrg"
    },
    "copyrightHolder": {
    	"@id": "#mozOrg"
    },
    "wordCount": "3126"
  }
</script>

<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
/**
 *
 */
?>



<?php
/*********************************************************************************************************************/
