window.sb = {
    "meta": {
        "title":"Theraplay",
        "description": "Psychologists that heal (or ruin) relationships with weekly game nights.",
        "keywords": "therepy,couples,couples therepy"
    },
    "contained": true,
    "navigation": {
        "fixed": "top",
        "background": "primary",
        "dark": true,
        "items": [
            {
                "section": "home",
                "title": "Home"
            },
            {
                "section": "services",
                "title": "Services"
            },
            {
                "section": "about",
                "title": "About Us",
                "align": "right"
            }
        ]
    },
    "sections": [
        {
            "id": "home",
            "components": ["home-jumbotron", "home-html"]
        },
        {
            "id": "services",
            "components": ["services-jumbotron", "product-showcase"]
        },
        {
            "id": "about",
            "components": ["about-jumbotron", "about-html"]
        }
    ],
    "components": {
        "home-jumbotron": {
            "type": "jumbotron",
            "align": "center",
            "title": "Welcome to Theraplay",
            "text": "Psychologists that heal (or ruin) relationships with weekly game nights.",
            "titleClass": "display-3",
            "background":"#64a7eb",
            "color":"light",
            "button": {
                "type": "dark",
                "text": "View All Services",
                "link": "#services"
            }
        },
        "home-html": {
            "type":"html",
            "template": "<h2>Convenient location</h2>"+
            "<p>Office located in south Minneapolis near uptown, just off 35W, and on direct bus lines from downtown, uptown, the UofM and the south suburbs (Routes 4, 18, 23, 113, 115).</p>"+
            "<h2>Cost</h2>"+
            "<p>We accept most insurance plans and also offer services based on a sliding scale to make services affordable for all income levels. Our fee range is $30 to $150.  Currently most of our lowest fee slots are filled, and mid-range slots are only available during daytime hours.  Contact us for details.</p>"+
            "<h2>Scheduling</h2>"+
            "<p>Appointments are available weekdays, evenings and weekends.   Contact us to set up an initial appointment.</p>"
        },
        "services-jumbotron": {
            "type": "jumbotron",
            "title": "Available Services",
            "titleClass": "display-4",
            "text": "Select the service that's right for you and yours!",
            "background": "#bf77e4",
            "color": "#f4e0ff"
        },
        "about-jumbotron": {
            "type": "jumbotron",
            "title": "About Us",
            "titleClass": "display-4",
            "background": "primary",
            "color":"light"
        },        
        "about-html": {
            "type": "html",
            "template": "<br><div class=\"card\">"+
            "    <div class=\"card-header\">"+
            "        Theraplay's Mission Statement"+
            "    </div>"+
            "    <div class=\"card-body\">"+
            "        <p class=\"card-text\">"+
            "            We are passionate and compassionate professionals, driven by the mission of helping more people live a better and happier life every day. We are growing fast and always looking for new talent. If you love people and like challenges - come and join us!"+
            "        </p>"+
            "        <a href=\"#\" class=\"btn btn-primary\">Join our team!</a>"+
            "    </div>"+
            "</div>"
        },
        "product-showcase": {
            "type": "html",
            "template": "<div class=\"card-deck\">"+
            "    <div class=\"card text-center\">"+
            "        <img class=\"card-img-top\" src=\"https://picsum.photos/300/200/\" alt=\"Card image cap\">"+
            "        <div class=\"card-body\">"+
            "        <h5 class=\"card-title\">Singles Therapy</h5>"+
            "        <a class=\"btn btn-outline-success btn-block\" href>Buy Now - $20/hr</a>"+
            "        <p class=\"card-text\"><small class=\"text-muted\">*First ones free</small></p>"+
            "        </div>"+
            "    </div>"+
            "    <div class=\"card text-center\">"+
            "        <img class=\"card-img-top\" src=\"https://picsum.photos/300/201/\" alt=\"Card image cap\">"+
            "        <div class=\"card-body\">"+
            "        <h5 class=\"card-title\">Couples Therapy</h5>"+
            "        <a class=\"btn btn-outline-success btn-block\" href>Buy Now - $250/hr</a>"+
            "        <p class=\"card-text\"><small class=\"text-muted\">*Automatic upgrade to mid-divorce tier</small></p>"+
            "        </div>"+
            "    </div>"+
            "    <div class=\"card text-center\">"+
            "        <img class=\"card-img-top\" src=\"https://picsum.photos/300/202/\" alt=\"Card image cap\">"+
            "        <div class=\"card-body\">"+
            "        <h5 class=\"card-title\">Mid-Divorce Therapy</h5>"+
            "        <a class=\"btn btn-outline-success btn-block\" href>Buy Now - 1M/hr</a>"+
            "        <p class=\"card-text\"><small class=\"text-muted\">*Prices are subject to change</small></p>"+
            "        </div>"+
            "    </div>"+
            "</div>"
        }
    }
};


console.log(JSON.stringify( window.sb ));