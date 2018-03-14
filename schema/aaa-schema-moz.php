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
 *
 * https://moz.com/blog/search-marketers-guide-to-itemref-itemid
 *
 * Use itemref when you need to populate itemprops in your primary entity.
 * For example, if the commentCount of a Blog Post was written in a <div> outside of the main Post's body.
 *
 * Use itemid when you need to populate itemprops where the expected type is another entity (not just a simple data point).
 * For example, if you declare the publisher of a Blog Post, you want to point to a complete Organization entity (with a
 * name, logo, URL, etc.).
 *
 * ITEMREF
 *
 * Let's say we're marking up a Blog Post (BlogPosting).
 * The one itemprop data point we can't get is the commentCount for the Blog Post. It is in a <div> outside the scope.
 *
 * 1.- In the <div>, <span> or other HTML element that contains the commentCount, add an itemscope attribute. That's it.
 * Without specifying an itemtype. That's why it is called a data blob: it's an independent data without a type.
 * Testing this in Google's Structured Data Testing Tool, it says "Unspecified Type", which is fine.
 *
 * <div itemscope>...</div>
 *
 * 2.- Wrap a new <span> tag around the comment count itself and specify what itemprop this is going to be.
 * At this point, it's a property of nothing, and that's ok.
 *
 * <div itemscope>
 *     <span itemprop="commentCount">108</span>
 * </div>
 *
 * 3.- Create a unique identifier for this data blob, so you can reference it later.
 * To do that, just add a basic id to the tag.
 *
 * <div itemscope>
 *     <span itemprop="commentCount" id="comments">108</span>
 * </div>
 *
 *      SIDENOTE: Itemref can be used with Meta tags by going through steps 2 and 3 on meta tags in your <head>,
 *      and you can reference them from an entity in your <body> tag using itemref.
 *      With meta tags, there's no need to add an itemscope, so skip step 1.
 *
 * 4.- Find and edit the itemscope/itemtype declaration for your Primary Entity. It will look like this:
 *
 * <div itemscope itemtype="http://schema.org/BlogPosting">
 *
 * 5.- Within that Tag, add the itemref attribute and reference the unique id that you created in Step 3.
 *
 * <div itemscope itemtype="http://schema.org/BlogPosting" itemref="comments">
 *
 * ITEMID
 *
 * Since we use itemid when we want to reference another complete entity, this might be an entity that's already on the Page.
 * If that's the case, you just add a quick bit of a markup and you're good to go.
 *
 * Say we want to use a Secondary Entity to populate an itemprop of a Primary Entity.
 * Using our Blog Post example, let's say we want to reference an Organization entity (that's the secondary) to populate
 * the publisher itemprop of the BlogPosting entity (that's the primary).
 *
 * 1.- Mark up the Secondary Entity just as you normally would.
 *
 * 2.- In the opening itemscope/itemtype declaration of that Secondary Entity, add an itemid attribute giving it a unique
 * fragment identifier.
 *
 * <div itemid="#mozOrg" itemscope itemtype="http://schema.org/organization">...</div>
 *
 * 3.- Within your Primary Entity, add a <link> Tag wherever you want to call in the Secondary Entity and specify the
 * itemprop you want your Secondary Entity to populate.
 * Use a simple href attribute to point to the fragment identifier from Step 2.
 *
 * <div itemscope itemtype="http://schema.org/blogPosting">
 *    <link itemprop="publisher" href="#mozOrg" />
 * </div>
 *
 *      Bonus: you can reference this Secondary Entity from multiple other entities and populate multiple itemprops too.
 *      If this Post were a company announcement on moz.com and Moz were both the publisher and the author,
 *      both of those properties could reference #mozOrg.
 *
 * USING ITEMID with JSON-LD
 *
 * Consider a Blog Post you're reading, which has structured data for a BlogPosting in JSON-LD.
 * You could avoid having to include all the data for your publisher (the Organization known as Moz) in your JSON-LD
 * script and instead reference a dedicated JSON-LD script for it.
 *
 * You could host two independent JSON-LD scripts in your page <head> and link them using @id.
 * So we have a BlogPosting JSON-LD Primary Entity and an Organization JSON-LD Secondary Entity.
 * In this example, using @id is not that useful, since you could add all the JSON-LD code in one Tag.
 *
 * Imagine you have an Article Page where you want to include structural data about the article's publisher (#publisher),
 * a video pertaining to the article (published by #publisher) and the article'a author (who worksFor #publisher).
 * Suddenly, having the ability to leverage a single definition of the Publisher entity is very valuable!
 *
 * You can use @id in a JSON-LD script to reference entities on other Pages and even other websites.
 * So you can have the same example above (BlogPosting JSON-LD Primary Entity and Organization JSON-LD Secondary Entity)
 * each one in a separate, independent Page.
 *
 * This means you can deliver JSON-LD on every Blog Post that references an Organization JSON-LD Tag on the HomePage.
 * You don't need to repeat that data on each Page or update every instance if a datapoint ever changes.
 *
 * Here are just a few cases in which you'd want to host JSON-LD for specific entities in centralized locations and
 * reference them throughout your whole Site:
 *
 *      Hosting your Organization JSON-LD on your company HomePage and then using it as:
 *          * The publisher property on BlogPostings.
 *          * The worksFor property on Person (on your team profiles).
 *
 *      Hosting Person JSON-LD for key personnel on your About Page and then using those entities as:
 *          * The author properties on BlogPostings.
 *          * The performer properties on Events.
 *
 *      (If you're a local business): hosting Place JSON-LD about your city on a dedicated landing Page and using it as:
 *          * The areaServed property on LocalBusiness.
 *          * The eligibleRegion property on Offer.
 *          * The foundingLocation property on Organization.
 *          * The jobLocation on property JobPosting.
 *
 * How to use @id in JSON-LD
 *
 * 1.- Edit your JSON-LD and give the Entity a fragment identifier (e.g. #eru).
 * Repeat the process for every JSON-LD script that defines an Entity that you want to be able to reference.
 *
 * <script type="application/ld+json">
 * {
 *     "@context": "http://schema.org",
 *     "@type": "Organization",
 *     "@id": "#mozOrg",
 *     "name": "Moz",
 *     ...
 * }
 * </script>
 *
 * 2.- In order to reference one of those entities from JSON-LD on another Page, provide an @id in the place of a value
 * for the property in question.
 * For example, instead of just providing a text string of "Moz" for the "publisher" on this BlogPosting, we'd refer to
 * the uniquely identified Entity by using its @id.
 *
 * <script type="application/ld+json">
 * {
 *     "@context": "http://schema.org",
 *     "@type": "BlogPosting",
 *     "publisher": {
 *         "@id": "#mozOrg"
 *     },
 *     ...
 * }
 * </script>
 *
 * Now, if the Entity you're pointing to lives on a different Page, just use the absolute path rather than the relative one.
 * "#mozOrg" becomes "https://moz.com/#mozOrg".
 *
 * This is the JSON-LD markup for https://moz.com/rand/about/#rand
 */
?>

<script type="application/ld+json">
{
    "@context":"http://schema.org",
    "@type":"Person",
    "@id":"#rand",
    "name":"Rand Fishkin",
    "givenName":"Rand",
    "familyName":"Fishkin",
    "image": {
        "@type": "ImageObject",
        "name":"Rand's Profile Picture",
        "url": "https://dc8hdnsmzapvm.cloudfront.net/rand/wp-content/uploads/2016/04/rand-profile-2016-186px.jpg",
        "width":186,
        "height":186
    },
    "description": "Rand uses the ludicrous title, Wizard of Moz. He’s founder and former CEO of Moz, creator of Keyword Explorer, host of Whiteboard Friday, co-author of a pair of books on SEO, co-founder of Inbound.org, and serves on the board of presentation software startup Haiku Deck. Rand’s writing can be found mostly in short bursts on Twitter, in longer ramblings on his personal blog, and, in photo-accompanying captions via the Instagram account he shares with his wife, Geraldine, who runs a consistently hilarious, occasionally poignant travel blog chronicling their adventures.",
    "birthDate":"1979-07-10",
    "birthPlace": {
        "@type": "City",
        "@id": "#hometown",
        "name": "Seattle",
        "containedInPlace": {https://moz.com/rand/about/#rand
            "@type":"State",
            name":"Washington",
            "sameAs":"https://en.wikipedia.org/wiki/Washington_(state)"
        },
        "alternateName": "The Emerald City",
        "alternateName": "Rain City",
        sameAs":"https://en.wikipedia.org/wiki/Seattle",
        "url":"http://www.seattle.gov/"
        },
    "worksFor": {
        "@id":"https://moz.com/#mozOrg"
    },
    "jobTitle":"Wizard of Moz",
    "homeLocation": {
        "@id": "#hometown"
    },
    "sameAs": [
        http://twitter.com/randfish",
        "http://www.slideshare.net/randfish",
        "https://plus.google.com/+RandFishkin",
        "http://www.facebook.com/rand.fishkin",
        "http://www.linkedin.com/in/randfishkin",
        "http://www.quora.com/Rand-Fishkin",
        "http://pinterest.com/randfish/"
    ],
    "awards": [
        "PSBJ's 40 Under 40",
        "Businessweek's 30 Under 30"
    ],
    "owns": {
        "@type":"Product",
        "name": "Keyword Explorer",
        "url": "https://moz.com/explorer",
        "description":"One Tool to Discover and Prioritize the Best Keywords to Target."
    },
    "spouse": {
        "@type":"Person",
        "@id": "#geraldine",
        "name": "Geraldine DeRuiter",
        "url":"http://www.everywhereist.com/",
        "spouse": {
            "@id":"#rand"
        }
    }
}
</script>


<!-- This is the JSON-LD markup for https://moz.com/ -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Corporation",
    "name": "Moz",
    "url": "https://moz.com",
    "sameAs": [
        "https://twitter.com/Moz",
        "https://www.facebook.com/moz",
        "https://plus.google.com/+SEOmoz",
        "https://www.linkedin.com/company/moz",
        "https://www.youtube.com/user/MozHQ",
        "https://www.instagram.com/moz_hq",
        "https://www.pinterest.com/mozhq",
        "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
    ],
    "image": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "telephone": "(206) 602-2005",
    "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "1100 2nd Ave #500",
        "addressLocality": "Seattle",
        "addressRegion": "WA",
        "postalCode": "98101",
        "addressCountry": "US"
    },
    "logo": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "location": {
        "@type": "Place",
        "name": "Moz",
        "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
        "telephone": "(206) 602-2005",
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",https://moz.com/blog/shttps://moz.com/blog/search-marketers-guide-to-itemref-itemidearch-marketers-guide-to-itemref-itemid
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "47.606379",
            "longitude": "-122.335780"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        }
    },
    "founder": "Rand Fishkin and Gillian Muessig",
    "foundingDate": "2004",
    "foundingLocation": "Seattle, WA"
}
</script>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    "name": "Moz",
    "description": "Backed by industry-leading data and the largest community of SEOs on the planet, Moz builds tools that make inbound marketing easy. Start your free trial today!",
    "url": "https://moz.com/",
    "image": "https://d2eeipcrcdle6.cloudfront.net/cms/moz_logo.svg?mtime=20161223191415",
    "sameAs": [
        "https://twitter.com/Moz",
        "https://www.facebook.com/moz",
        "https://plus.google.com/+SEOmoz",
        "https://www.linkedin.com/company/moz",
        "https://www.youtube.com/user/MozHQ",
        "https://www.instagram.com/moz_hq",
        "https://www.pinterest.com/mozhq"
    ],
    "copyrightHolder": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",https://moz.com/blog/search-marketers-guide-to-itemref-itemid
            "https://www.pinterest.com/mozhq","https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                "https://www.facebook.com/moz",
                "https://plus.google.com/+SEOmoz",
                "https://www.linkedin.com/company/moz",
                "https://www.youtube.com/user/MozHQ",
                "https://www.instagram.com/moz_hq",
                "https://www.pinterest.com/mozhq",
                "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
            ],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "author": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": ["https://twitter.com/Moz","https://www.facebook.com/moz","https://plus.google.com/+SEOmoz","https://www.linkedin.com/company/moz","https://www.youtube.com/user/MozHQ","https://www.instagram.com/moz_hq","https://www.pinterest.com/mozhq","https://en.wikipedia.org/wiki/Moz_(marketing_software)"],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "creator": {
        "@type": "Organization",
        "name": "Moz",
        "alternateName": "SEOMoz",
        "location": {
            "@type": "Place",
            "name": "Moz",
            "alternateName": "SEOMoz"
        }
    }
}
</script>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "Moz | SEO Software, Tools &amp; Resources for Smarter Marketing",
    "description": "Backed by the largest community of SEOs on the planet, Moz builds tools that make SEO, inbound marketing, link building, and content marketing easy. Start your free 30-day trial today!",
    "image": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "width": "862",
        "height": "252"
    },
    "url": "https://moz.com/",
    "mainEntityOfPage": "https://moz.com/",
    "inLanguage": "en_us",
    "headline": "Moz | SEO Software, Tools &amp; Resources for Smarter Marketing",
    "keywords": "SEO",
    "dateCreated": "2016-10-06T22:11:03+0000",
    "dateModified": "2018-02-14T23:34:58+0000",
    "datePublished": "2017-05-08T21:34:26+0000",
    "copyrightYear": "2017",
    "author": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                "https://www.facebook.com/moz",
                "https://plus.google.com/+SEOmoz",
                "https://www.linkedin.com/company/moz",
                "https://www.youtube.com/user/MozHQ",
                "https://www.instagram.com/moz_hq",
                "https://www.pinterest.com/mozhq",
                "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
            ],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"Seattle, WA
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "publisher": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                "https://www.facebook.com/moz",
                "https://plus.google.com/+SEOmoz",
                "https://www.linkedin.com/company/moz",
                "https://www.youtube.com/user/MozHQ",
                "https://www.instagram.com/moz_hq",
                "https://www.pinterest.com/mozhq",
                "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
            ],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "copyrightHolder": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",Seattle, WA
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                "https://www.facebook.com/moz",
                "https://plus.google.com/+SEOmoz",
                "https://www.linkedin.com/company/moz",
                "https://www.youtube.com/user/MozHQ",
                "https://www.instagram.com/moz_hq",
                "https://www.pinterest.com/mozhq",
                "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
            ],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": "1",
                "item": {
                    "@id": "https://moz.com/",
                    "name": "Homepage"
                }
            }
        ]
    }
}
</script>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": "1",
            "item": {
                "@id": "https://moz.com/",
                "name": "Homepage"
            }
        }
    ]
}
</script>

A https://moz.com tenim:

- "@type": "Corporation"
	"location": {
		"@type": "place",
		"name": "Moz"
	}

- "@type": "WebSite"
	"copyrightHolder": {
		"@type": "Corporation",
		"name": "Moz"
		"location": {
			"@type": "place",
			"name": "Moz"
		}
	}
	"author": {
		"@type": "Corporation",
		"name": "Moz",
		"location": {
			"@type": "Place",
			"name": "Moz",
		}
	}
	"creator": {
		"@type": "Organization",
		"name": "Moz",
	}

- "@type": "WebPage"
	"mainEntityOfPage": "https://moz.com/",
	"author": {
		"@type": "Corporation",
		"name": "Moz",
		"location": {
			"@type": "Place",
			"name": "Moz",
		}
	}
	"publisher": {
		"@type": "Corporation",
		"name": "Moz",
		"location": {
			"@type": "Place",
			"name": "Moz",
		}
	}
	"copyrightHolder": {
		"@type": "Corporation",
		"name": "Moz",
		"location": {
			"@type": "Place",
			"name": "Moz",
		}
	}

Hem de crear:
	- BreadcrumbList
	- Place
	- Corporation
	- Organization
	- WebSite
	- WebPage -> mainEntityOfPage

El que hi ha a la pàgina:

<!-- 78 Corporation -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Corporation",
    "name": "Moz",
    "url": "https://moz.com",
    "sameAs": [
        "https://twitter.com/Moz",
        "https://www.facebook.com/moz",
        "https://plus.google.com/+SEOmoz",
        "https://www.linkedin.com/company/moz",
        "https://www.youtube.com/user/MozHQ",
        "https://www.instagram.com/moz_hq",
        "https://www.pinterest.com/mozhq",
        "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
    ],
    "image": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "telephone": "(206) 602-2005",
    "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "1100 2nd Ave #500",
        "addressLocality": "Seattle",
        "addressRegion": "WA",
        "postalCode": "98101",
        "addressCountry": "US"
    },
    "logo": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "location": {
        "@type": "Place",
        "name": "Moz",
        "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
        "telephone": "(206) 602-2005",
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "47.606379",
            "longitude": "-122.335780"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        }
    },
    "founder": "Rand Fishkin and Gillian Muessig",
    "foundingDate": "2004",
    "foundingLocation": "Seattle, WA"
}
</script>

<!-- 145 WebSite -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    "name": "Moz",
    "description": "Backed by industry-leading data and the largest community of SEOs on the planet, Moz builds tools that make inbound marketing easy. Start your free trial today!",
    "url": "https://moz.com/",
    "image": "https://d2eeipcrcdle6.cloudfront.net/cms/moz_logo.svg?mtime=20161223191415",
    "sameAs": ["https://twitter.com/Moz","https://www.facebook.com/moz","https://plus.google.com/+SEOmoz","https://www.linkedin.com/company/moz","https://www.youtube.com/user/MozHQ","https://www.instagram.com/moz_hq","https://www.pinterest.com/mozhq"],
    "copyrightHolder": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": ["https://twitter.com/Moz","https://www.facebook.com/moz","https://plus.google.com/+SEOmoz","https://www.linkedin.com/company/moz","https://www.youtube.com/user/MozHQ","https://www.instagram.com/moz_hq","https://www.pinterest.com/mozhq","https://en.wikipedia.org/wiki/Moz_(marketing_software)"],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": ["https://twitter.com/Moz","https://www.facebook.com/moz","https://plus.google.com/+SEOmoz","https://www.linkedin.com/company/moz","https://www.youtube.com/user/MozHQ","https://www.instagram.com/moz_hq","https://www.pinterest.com/mozhq","https://en.wikipedia.org/wiki/Moz_(marketing_software)"],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "author": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": ["https://twitter.com/Moz","https://www.facebook.com/moz","https://plus.google.com/+SEOmoz","https://www.linkedin.com/company/moz","https://www.youtube.com/user/MozHQ","https://www.instagram.com/moz_hq","https://www.pinterest.com/mozhq","https://en.wikipedia.org/wiki/Moz_(marketing_software)"],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": ["https://twitter.com/Moz","https://www.facebook.com/moz","https://plus.google.com/+SEOmoz","https://www.linkedin.com/company/moz","https://www.youtube.com/user/MozHQ","https://www.instagram.com/moz_hq","https://www.pinterest.com/mozhq","https://en.wikipedia.org/wiki/Moz_(marketing_software)"],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "creator": {
        "@type": "Organization",
        "name": "Moz",
        "alternateName": "SEOMoz",
        "location": {
            "@type": "Place",
            "name": "Moz",
            "alternateName": "SEOMoz"
        }
    }
}
</script>

<!-- 294 WebPage -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "Moz | SEO Software, Tools &amp; Resources for Smarter Marketing",
    "description": "Backed by the largest community of SEOs on the planet, Moz builds tools that make SEO, inbound marketing, link building, and content marketing easy. Start your free 30-day trial today!",
    "image": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "width": "862",
        "height": "252"
    },
    "url": "https://moz.com/",
    "mainEntityOfPage": "https://moz.com/",
    "inLanguage": "en_us",
    "headline": "Moz | SEO Software, Tools &amp; Resources for Smarter Marketing",
    "keywords": "SEO",
    "dateCreated": "2016-10-06T22:11:03+0000",
    "dateModified": "2018-02-14T23:34:58+0000",
    "datePublished": "2017-05-08T21:34:26+0000",
    "copyrightYear": "2017",
    "author": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                "https://www.facebook.com/moz",
                "https://plus.google.com/+SEOmoz",
                "https://www.linkedin.com/company/moz",
                "https://www.youtube.com/user/MozHQ",
                "https://www.instagram.com/moz_hq",
                "https://www.pinterest.com/mozhq",
                "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
            ],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "publisher": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                "https://www.facebook.com/moz",
                "https://plus.google.com/+SEOmoz",
                "https://www.linkedin.com/company/moz",
                "https://www.youtube.com/user/MozHQ",
                "https://www.instagram.com/moz_hq",
                "https://www.pinterest.com/mozhq",
                "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
            ],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "copyrightHolder": {
        "@type": "Corporation",
        "name": "Moz",
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "location": {
            "@type": "Place",
            "name": "Moz",
            "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
            "telephone": "(206) 602-2005",
            "image": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "logo": {
                "@type": "ImageObject",
                "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
                "height": "252",
                "width": "862"
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                "https://www.facebook.com/moz",
                "https://plus.google.com/+SEOmoz",
                "https://www.linkedin.com/company/moz",
                "https://www.youtube.com/user/MozHQ",
                "https://www.instagram.com/moz_hq",
                "https://www.pinterest.com/mozhq",
                "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
            ],
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "47.606379",
                "longitude": "-122.335780"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "1100 2nd Ave #500",
                "addressLocality": "Seattle",
                "addressRegion": "WA",
                "postalCode": "98101",
                "addressCountry": "US"
            }
        },
        "founder": "Rand Fishkin and Gillian Muessig",
        "foundingDate": "2004",
        "foundingLocation": "Seattle, WA"
    },
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": "1",
                "item": {
                    "@id": "https://moz.com/",
                    "name": "Homepage"
                }
            }
        ]
    }
}
</script>

<!-- 522 BreadcrumbList -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": "1",
            "item": {
                "@id": "https://moz.com/",
                "name": "Homepage"
            }
        }
    ]
}
</script>

<!-- ************************************************************************************************************** -->

<!-- BreadCrumb -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": "1",
            "item": {
                "@id": "https://cameraski.com/",
                "name": "Homepage"
            }
        }
    ]
}
</script>

<!-- Place -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Place",
    "name": "CameraSki",
    "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
    "telephone": "+123 456 78 90",
    "image": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "logo": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "url": "https://cameraski.com",
    "sameAs": [
        "https://twitter.com/CameraSki",
        "https://www.facebook.com/moz",
        "https://plus.google.com/+SEOmoz",https://moz.com/blog/shttps://moz.com/blog/search-marketers-guide-to-itemref-itemidearch-marketers-guide-to-itemref-itemid
        "https://www.linkedin.com/company/moz",
        "https://www.youtube.com/user/MozHQ",
        "https://www.instagram.com/moz_hq",
        "https://www.pinterest.com/mozhq",
        "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
    ],
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": "47.606379",
        "longitude": "-122.335780"
    },
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Sant Sebastià, 36",
        "addressLocality": "Caldes de Malavella",
        "addressRegion": "Girona",
        "postalCode": "17455",
        "addressCountry": "ES"
    }
}
</script>

<!-- Corporation -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Corporation",
    "name": "CameraSki",
    "url": "https://cameraski.com",
    "sameAs": [
        "https://twitter.com/CameraSki",
        "https://www.facebook.com/moz",
        "https://plus.google.com/+SEOmoz",
        "https://www.linkedin.com/company/moz",
        "https://www.youtube.com/user/MozHQ",
        "https://www.instagram.com/moz_hq",
        "https://www.pinterest.com/mozhq",
        "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
    ],
    "image": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "telephone": "+123 456 78 90",
    "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Sant Sebastià, 36",
        "addressLocality": "Caldes de Malavella",
        "addressRegion": "Girona",
        "postalCode": "17455",
        "addressCountry": "ES"
    },
    "logo": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "location": {
        "@type": "Place",
        "name": "Moz",
        ...Resta...
        }
    },
    "founder": "Carles Valbuena",
    "foundingDate": "2016",
    "foundingLocation": "Barcelona, Catalonia"
}
</script>

<!-- Organization -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Organization",
    "name": "CameraSki",
    "alternateName": "SkiResortWebCams",
    "location": {
        "@type": "Place",
        "name": "CameraSki",
        "alternateName": "SkiResortWebCams"
    }
}
</script>

<!-- WebSite -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    "name": "CameraSki",
    "description": "...",
    "url": "https://cameraski.com/",
    "image": "https://d2eeipcrcdle6.cloudfront.net/cms/moz_logo.svg?mtime=20161223191415",
    "sameAs": [
        "https://twitter.com/CameraSki",
        "https://www.facebook.com/moz",
        "https://plus.google.com/+SEOmoz",
        "https://www.linkedin.com/company/moz",
        "https://www.youtube.com/user/MozHQ",
        "https://www.instagram.com/moz_hq",
        "https://www.pinterest.com/mozhq"
    ],
    "copyrightHolder": {
        "@type": "Corporation",
        "name": "Moz",
        ...
        "location": {
            "@type": "Place",
            "name": "Moz",
            ...
        },
        ...
    },
    "author": {
        "@type": "Corporation",
        "name": "Moz",
        ...
        "location": {
            "@type": "Place",
            "name": "Moz",
            ...
        },
        ...
    },
    "creator": {
        "@type": "Organization",
        "name": "Moz",
        ...
    }
}
</script>

<!-- WebPage -> mainEntityOfPage -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "Moz | SEO Software, Tools &amp; Resources for Smarter Marketing",
    "description": "...",
    "image": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "width": "862",
        "height": "252"
    },
    "url": "https://cameraski.com/",
    "mainEntityOfPage": "https://cameraski.com/",
    "inLanguage": "en_us",
    "headline": "Moz | SEO Software, Tools &amp; Resources for Smarter Marketing",
    "keywords": "SEO",
    "dateCreated": "2016-10-06T22:11:03+0000",
    "dateModified": "2018-02-14T23:34:58+0000",
    "datePublished": "2017-05-08T21:34:26+0000",
    "copyrightYear": "2018",
    "author": {
        "@type": "Corporation",
        "name": "Moz",
        ...
        "location": {
            "@type": "Place",
            "name": "Moz",
            ...
        },
        ...
    },
    "publisher": {
        "@type": "Corporation",
        "name": "Moz",
        ...
        "location": {
            "@type": "Place",
            "name": "Moz",
            ...
        },
        ...
    },
    "copyrightHolder": {
        "@type": "Corporation",
        "name": "Moz",
        ...
        "location": {
            "@type": "Place",
            "name": "Moz",
            ...
        },
        ...
    },
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
            ...
        ]
    }
}
</script>

<!-- ************************************************************************************************************** -->
<!-- O, sigui, tenim: -->

<script type="application/ld+json">
{
    "@context":"http://schema.org",
    "@type":"Person",
    ...
    "birthPlace": {
        "@type": "City",
        "containedInPlace": {https://moz.com/rand/about/#rand
            "@type":"State",
        },
        ...
    },
    "worksFor": {
        "@id":"https://moz.com/#mozOrg"
    },
    "homeLocation": {
        "@id": "#hometown"
    },
    "sameAs": [
        http://twitter.com/randfish",
        ...
    ],
    "awards": [
        "PSBJ's 40 Under 40",
        "Businessweek's 30 Under 30"
    ],
    "owns": {
        "@type":"Product",
        ...
    },
    "spouse": {
        "@type":"Person",
        ...
        "spouse": {
            "@id":"#rand"
        }
    }
}
</script>

<!-- This is the JSON-LD markup for https://moz.com/ -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Corporation",
    ...
    "sameAs": [
        "https://twitter.com/Moz",
        ...
    ],
    "image": {
        "@type": "ImageObject",
        ...
    },
    "telephone": "(206) 602-2005",
    "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
    "address": {
        "@type": "PostalAddress",
        ...
    },
    "logo": {
        "@type": "ImageObject",
        ...
    },
    "location": {
        "@type": "Place",
        ...
        "image": {
            "@type": "ImageObject",
            ...
        },
        "logo": {
            "@type": "ImageObject",
            ...
        },
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            ...
        ],
        "geo": {
            "@type": "GeoCoordinates",
            ...
        },
        "address": {
            "@type": "PostalAddress",
            ...
        }
    },
    ...
}
</script>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    ...
    "sameAs": [
        "https://twitter.com/Moz",
        ...
    ],
    "copyrightHolder": {
        "@type": "Corporation",
        ...
        "sameAs": [
            "https://twitter.com/Moz",
            ...
        ],
        "image": {
            "@type": "ImageObject",
            ...
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            ...
        },
        "logo": {
            "@type": "ImageObject",
            ...
        },
        "location": {
            "@type": "Place",
            ...
            "image": {
                "@type": "ImageObject",
                ...
            },
            "logo": {
                "@type": "ImageObject",
                ...
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                ...
            ],
            "geo": {
                "@type": "GeoCoordinates",
                ...
            },
            "address": {
                "@type": "PostalAddress",
                ...
            }
        },
        ...
    },
    "author": {
        "@type": "Corporation",
        ...
        "sameAs": [
            "https://twitter.com/Moz",
            ...
        ],
        "image": {
            "@type": "ImageObject",
            ...
        },
        "telephone": "(206) 602-2005",
        "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
        "address": {
            "@type": "PostalAddress",
            ...
        },
        "logo": {
            "@type": "ImageObject",
            ...
        },
        "location": {
            "@type": "Place",
            ...
            "image": {
                "@type": "ImageObject",
                ...
            },
            "logo": {
                "@type": "ImageObject",
                ...
            },
            "url": "https://moz.com",
            "sameAs": ["https://twitter.com/Moz","https://www.facebook.com/moz","https://plus.google.com/+SEOmoz","https://www.linkedin.com/company/moz","https://www.youtube.com/user/MozHQ","https://www.instagram.com/moz_hq","https://www.pinterest.com/mozhq","https://en.wikipedia.org/wiki/Moz_(marketing_software)"],
            "geo": {
                "@type": "GeoCoordinates",
                ...
            },
            "address": {
                "@type": "PostalAddress",
                ...
            }
        },
        ...
    },
    "creator": {
        "@type": "Organization",
        ...
        "location": {
            "@type": "Place",
            ...
        }
    }
}
</script>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "image": {"founder": "Rand Fishkin and Gillian Muessig",
        "@type": "ImageObject",
        ...
    },
    "url": "https://moz.com/",
    "mainEntityOfPage": "https://moz.com/",
    ...
    "author": {
        "@type": "Corporation",
        "sameAs": [
            "https://twitter.com/Moz",
            ...
        ],
        "image": {
            "@type": "ImageObject",
            ...
        },
        ...
        "address": {
            "@type": "PostalAddress",
            ...
        },
        "logo": {
            "@type": "ImageObject",
            ...
        },
        "location": {
            "@type": "Place",
            ...
            "image": {
                "@type": "ImageObject",
                ...
            },
            "logo": {
                "@type": "ImageObject",
                ...
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                ...
            ],
            "geo": {
                "@type": "GeoCoordinates",
                ...
            },
            "address": {
                "@type": "PostalAddress",
                ...
            }
        },
        ...
    },
    "publisher": {
        "@type": "Corporation",
        ...
        "sameAs": [
            "https://twitter.com/Moz",
            ...
        ],
        "image": {
            "@type": "ImageObject",
            ...
        },
        ...
        "address": {
            "@type": "PostalAddress",
            ...
        },
        "logo": {
            "@type": "ImageObject",
            ...
        },
        "location": {
            "@type": "Place",
            ...
            "image": {
                "@type": "ImageObject",
                ...
            },
            "logo": {
                "@type": "ImageObject",
                ...
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                ...
            ],
            "geo": {
                "@type": "GeoCoordinates",
                ...
            },
            "address": {
                "@type": "PostalAddress",
                ...
            }
        },
        ...
    },
    "copyrightHolder": {
        "@type": "Corporation",
        ...
        "sameAs": [
            "https://twitter.com/Moz",
            ...
        ],
        "image": {
            "@type": "ImageObject",
            ...
        },
        ...
        "address": {
            "@type": "PostalAddress",
            ...
        },
        "logo": {
            "@type": "ImageObject",
            ...
        },
        "location": {
            "@type": "Place",
            ...
            "image": {
                "@type": "ImageObject",
                ...
            },
            "logo": {
                "@type": "ImageObject",
                ...
            },
            "url": "https://moz.com",
            "sameAs": [
                "https://twitter.com/Moz",
                ...
            ],
            "geo": {
                "@type": "GeoCoordinates",
                ...
            },
            "address": {
                "@type": "PostalAddress",
                ...
            }
        },
        ...
    },
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": "1",
                "item": {
                    "@id": "https://moz.com/",
                    "name": "Homepage"
                }
            }
        ]
    }
}
</script>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": "1",
            "item": {
                "@id": "https://moz.com/",
                "name": "Homepage"
            }
        }
    ]
}
</script>

<?php
/*********************************************************************************************************************/
/**
 * https://moz.com/blog/search-marketers-guide-to-itemref-itemid
 */
?>

<!-- Això és el Codepen al final de l'article -->
<!-- This code example will show you to use itemref in microdata, itemid in microdata,
@id to reference entities on the same Page, @id to reference entities on other Pages (hint:
there may be a really cool entity over at https://moz.com/rand/about/#rand if you want to check it out) and
@id to reference entitites on other WebSites. -->
<head>
	<title class="title">The Search Marketer’s Guide to ItemRef & ItemID</title>
	<script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "BlogPosting",
    "mainEntityOfPage":{
      "@type":"WebPage",
      "@id":"https://moz.com/blog/search-marketers-guide-to-itemref-itemid"
    },
    "headline": "The Search Marketer’s Guide to Itemref & Itemid",
    "image": {
      "@type": "ImageObject",
      "url": "https://d1avok0lzls2w.cloudfront.net/uploads/og_image/578003ea6f96e7.59106369.png",
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
</head>
<!--Within the site's header, we have fully-formed Organization entity-->
<header itemid="#moz" itemscope itemtype="http://schema.org/organization">
	<meta itemprop="name" content="Moz" />
	<img itemprop="logo" src="https://d2eeipcrcdle6.cloudfront.net/brand-guide/logos/moz_blue.png" />
</header>

<!--Main Body of the post-->
<div itemscope itemtype="http://schema.org/blogPosting" itemref="comments author title">
	<img src="https://d1avok0lzls2w.cloudfront.net/uploads/og_image/578003ea6f96e7.59106369.png" itemprop="image">
	<h1 itemprop="headline">The Search Marketer’s Guide to ItemRef & ItemID</h1>
	<span>Published on
    <time itemprop="datePublished" datetime="2016-07-07">July 7th 2016</time>
    <meta itemprop="dateModified" content="2016-07-07T03:04" />
  </span>
	<link itemprop="publisher" href="#moz" />
	<h3>Preface</h3>
	<p itemprop="description">This post is going to give you a new tool to add to your semantic markup tool belt. My goal is to help you implement semantic markup and structured data with greater ease and to allow you to create a more robust and complete web of linked data on your
		websites (and beyond).</p>
	<div itemprop="articleBody">
		<h2>What are itemref and itemid?</h2>
		<p>Itemref and itemid are HTML attributes. They’re very similar to some other attributes that you’ll undoubtedly be familiar with if you’ve done work with semantic markup before...</p>
	</div>
</div>

<!--This data blob lives somewhere else on the page.-->
<div itemscope>
	Comments <sup itemprop="commentCount" id="comments">108</sup>
</div>

<!--Another data blob-->
<div itemscope>About <span itemprop="author" id="author">Mike Arnesen</span> - Mike is the Founder & CEO at UpBuild.</div>

Rerun


<?php
/*********************************************************************************************************************/
/**
 * https://moz.com/rand/about/#rand
 */
?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Person",
  "@id": "#carles",
  "name": "Carles Valbuena",
  "givenName": "Carles",
  "familyName": "Valbuena",
  "image": {
      "@type": "ImageObject",
      "name": "Carles' Profile Picture",
      "url": "...",
      "width": "...",
      "height": "..."
  },
  "description": "...",
  "birthDate": "1972-03-05",
  "birthPlace": {
      "@type": "City",
      "@id": "#hometown-carles",
      "name": "Viladecans",
      "containedInPlace": {
          "@type": "AdministrativeArea",
          "name": "Catalonia",
          "sameAs": "https://en.wikipedia.org/wiki/Catalonia"
      },
      "alternateName": "DogsTown",
      "sameAs": "https://en.wikipedia.org/wiki/Viladecans",
      "url": "http://viladecans.cat/"
  },
  "worksFor": {
      "@id": "https://cameraski.com/#cameraskiOrg"
  },
  "jobTitle": "Great Emperor of the Galaxy",
  "homeLocation": {
      "@id": "#hometown-carles"
  },
  "sameAs": [
      "https://twitter.com/CarlesValbuena",
      "..."
  ],
  "awards": [
      "..."
  ],
  "owns": {
      "@type": "Product",
      "name": "Learner WP Theme",
      "url": "https://genesisthemeswp.com/",
      "description": "..."
  },
  "spouse": {
      "@type": "Person",
      "@id": "#rose",
      "name": "Rosa Ruiz",
      "url": "https://rose-prepper.com/",
      "spouse": {
          "@id": "#carles"
      }
  }
}
</script>


<?php
/*********************************************************************************************************************/
/**
 *
 */
?>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Corporation",
    "name": "Moz",
    "url": "https://moz.com",
    "sameAs": [
        "https://twitter.com/Moz",
        "https://www.facebook.com/moz",
        "https://plus.google.com/+SEOmoz",
        "https://www.linkedin.com/company/moz",
        "https://www.youtube.com/user/MozHQ",
        "https://www.instagram.com/moz_hq",
        "https://www.pinterest.com/mozhq",
        "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
    ],
    "image": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "telephone": "(206) 602-2005",
    "email": "&#104;&#101;&#108;&#112;&#64;&#109;&#111;&#122;&#46;&#99;&#111;&#109;",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "1100 2nd Ave #500",
        "addressLocality": "Seattle",
        "addressRegion": "WA",
        "postalCode": "98101",
        "addressCountry": "US"
    },
    "logo": {
        "@type": "ImageObject",
        "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
        "height": "252",
        "width": "862"
    },
    "location": {
        "@type": "Place",
        "name": "Moz",
        "hasMap": "http://maps.google.com/maps?q=Moz%2C+1100+2nd+Ave+%23500%2C+Seattle%2C+WA+98101%2C+US",
        "telephone": "(206) 602-2005",
        "image": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "logo": {
            "@type": "ImageObject",
            "url": "https://d2eeipcrcdle6.cloudfront.net/cms/Moz-logo-blue.jpg?mtime=20170419135147",
            "height": "252",
            "width": "862"
        },
        "url": "https://moz.com",
        "sameAs": [
            "https://twitter.com/Moz",
            "https://www.facebook.com/moz",
            "https://plus.google.com/+SEOmoz",https://moz.com/blog/shttps://moz.com/blog/search-marketers-guide-to-itemref-itemidearch-marketers-guide-to-itemref-itemid
            "https://www.linkedin.com/company/moz",
            "https://www.youtube.com/user/MozHQ",
            "https://www.instagram.com/moz_hq",
            "https://www.pinterest.com/mozhq",
            "https://en.wikipedia.org/wiki/Moz_(marketing_software)"
        ],
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "47.606379",
            "longitude": "-122.335780"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "1100 2nd Ave #500",
            "addressLocality": "Seattle",
            "addressRegion": "WA",
            "postalCode": "98101",
            "addressCountry": "US"
        }
    },
    "founder": "Rand Fishkin and Gillian Muessig",
    "foundingDate": "2004",
    "foundingLocation": "Seattle, WA"
}
</script>

<?php
/*********************************************************************************************************************/

/**
 * Segons https://moz.com/blog/search-marketers-guide-to-itemref-itemid
 * https://cameraski.com
 * Si ho fem com moz.com, necessitarem:
 *      - BreadcrumbList
 *      - Place
 *      - Corporation
 *      - Organization
 *      - WebSite
 *      - WebPage -> mainEntityOfPage
 *
 * Si ho fem com seobythesea.com, necessitarem:
 *      - WebSite
 *      - SiteNavigationElement
 *      - CreativeWork x6
 *      - WPHeader
 *      - LocalBusiness
 *      - PostalAddress
 *      - WPSidebar 1
 *      - WPSidebar 2
 *      - Organization
 *      - Person
 *      - Place
 */
?>

<!-- WebSite -->
<!-- seobythesea.com posa WebSite primer de tot, a <html><head>.
     Sembla que ho fa a totes les pàgines.
-->
<script type='application/ld+json'>
{
	"@context": "https:\/\/schema.org",
	"@type": "WebSite",
	"@id": "#website-cameraski",
	"name": "CameraSki",
	"description": "WebCams \| Snow Reports \| Weather Forecasts - Updated every day",
	"url": "https:\/\/cameraski.com\/",
	"image": "http://camping-cabins.com/wp-content/themes/cameraski/assets/images/logo.png",
	"sameAs": [
		"https://twitter.com/CameraSki"
	],
	"copyrightHolder": {
        "@type": "Corporation",
        "name": "Moz"
    },
    "author": {
        "@type": "Corporation",
        "name": "Moz"
    }
    "creator": {
        "@type": "Organization",
        "name": "Moz"
    }
	"potentialAction": {
		"@type": "SearchAction",
		"target": "https:\/\/cameraski.com\/?s={search_term_string}",
		"query-input": "required name=search_term_string"
	}
}
</script>

<!-- Organization -->
<!-- A https://webmasters.stackexchange.com/questions/82507/should-schema-org-organization-data-about-my-company-be-on-every-page?noredirect=1&lq=1
hi ha un ususari que diu que va tenir un penalty de Google per posar Organization a totes les pàgines. Creu que millor posar-ho només a la HomePage.
-->


<!-- Place -->


<!-- BreadcrumbList -->


<!-- WebSite -->


<!-- WebPage -> mainEntityofPage -->


<!-- Person -->


<!--  -->

<!--  -->

<!--  -->

<!--  -->

<!--  -->

<!--  -->

<!--  -->

<!--  -->

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



