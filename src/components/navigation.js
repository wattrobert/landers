var SbNavProto = Object.create(HTMLElement.prototype);
SbNavProto.attachedCallback = createSbNav;
document.registerElement('sb-nav', {prototype: SbNavProto});

function createSbNav() {
    var navbar = document.createElement('nav');

    var data = window.sb.navigation;

    navbar.classList.add('navbar', 'navbar-expand');
    navbar.classList.add('bg-' + (data.background ? data.background : 'light'));
    navbar.classList.add('navbar-' + (data.dark ? 'dark' : 'light'));
    if (data.fixed) navbar.classList.add('fixed-' + data.fixed);

    var navItemsLeft = [];
    var navItemsRight = [];

    data.items.forEach(function(navItem) {
        if (!navItem.title || !(navItem.section || navItem.page)) return;
        (navItem.align === 'right') ? navItemsRight.push(navItem) : navItemsLeft.push(navItem);
    });

    var btncontain = document.createElement('div');
    btncontain.classList.add('form-inline', 'mr-3');

    var btntest = document.createElement('button');
    btntest.classList.add('btn', 'btn-light', 'btn-sm');
    btntest.innerHTML = 'Update Via API';

    btntest.onclick = function() {
        var test = JSON.parse(JSON.stringify(window.sb));
        var split = test.meta.title.split('.');
        if (split[1])  {
            split[1] = Number(split[1]);
            split[1]++;
        } else {
            split[1] = '1';
        }
        var update = [split[0], split[1]].join('.');
        console.log(update);
        test.meta.title = update;
        $.ajax({
            type: 'POST',
            url: './api/json/edit/',
            data: {
                url: window.location.pathname,
                json: test
            },
            success: function(response) {
                console.log(response);
            }
        });

    }
    btncontain.appendChild(btntest);


    if (navItemsLeft.length) {
        var navLeft = document.createElement('ul');
        navLeft.classList.add('navbar-nav', 'mr-auto');
        buildNavItems(navLeft, navItemsLeft);
    }

    if (navItemsRight.length) {
        var navRight = document.createElement('ul');
        navRight.classList.add('navbar-nav', 'ml-auto');
        buildNavItems(navRight, navItemsRight);
    }

    function buildNavItems(navSection, navItems) {
        navItems.forEach(function(navItem) {
            navSection.innerHTML += '<li class="nav-item"><a class="nav-link" href="#' + navItem.section + '">' + navItem.title + '</a></li>';
        });
    }

    if (window.sb.contained) {
        var container = document.createElement('div');
        container.classList.add('container');
    }
    
    appendNavs(container);

    function appendNavs(parent) {
        var fragment = document.createDocumentFragment();
        if (btncontain) fragment.appendChild(btncontain);

        var brand = document.createElement('a');
        brand.classList.add('navbar-brand');
        brand.setAttribute('href', '#home');
        brand.innerHTML = document.title;
        fragment.appendChild(brand);

        if (navLeft) fragment.appendChild(navLeft);
        if (navRight) fragment.appendChild(navRight);
        
        if (parent) parent.appendChild(fragment);
        navbar.appendChild(parent || fragment);
    }


    this.appendChild(navbar);
}