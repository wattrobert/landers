
var elementMetaTags = ['title'];

window.sb ? init() : $.ajax({
    dataType: 'json',
    url: './api/json/',
    data: {
        url: window.location.pathname
    },
    success: init
});


function init(remoteData) {
    if (remoteData) window.sb = remoteData;
    if (window.sb.contained) document.body.classList.add('is-contained');
    buildMeta();
    buildSections();
    buildNav();
}

function buildSections() {
    try {
        window.sb.main = document.querySelector('main');
        window.sb.sections.forEach(loadSection);
    } catch (e) {
        console.error('INIT ERROR [pages]', e);
    }
}

function loadSection(section) {
    try {
        section.element = document.createElement('section');
        section.element.setAttribute('id', section.id);

        section.anchor = document.createElement('a');
        section.anchor.setAttribute('id', section.id);
        window.sb.main.appendChild(section.anchor);

        section.components.forEach(function(id) {
            return loadComponent(section.element, id);
        });
        window.sb.main.appendChild(section.element);
    } catch (e) {
        console.error('LOAD ERROR [page.' + section.id + ']', e);
    }
}

function loadComponent(pageElement, componentId) {
    try {
        var component = window.sb.components[componentId];
        switch(component.type) {
            case 'jumbotron':
                component.element = document.createElement('sb-jumbotron');
                break;
            case 'html': 
                component.element = document.createElement('sb-html');
                break;
            default: 
                component.element = document.createElement('sb-pre');
                break;
        }
        component.element.setAttribute('component-ref', componentId);
        pageElement.append(component.element);
    } catch (e) {
        console.error('LOAD ERROR [' + component.type + '.' + component.id + ']', e);
    }
}

function buildNav() {
    try {
        window.sb.nav = document.createElement('sb-nav');
        document.querySelector('body').insertBefore(window.sb.nav, window.sb.main);
    } catch (e) {
        console.error('INIT ERROR [navigation]', e);
    }
}

function buildMeta() {
    if (!window.sb.meta) return console.info('INIT WARNING [metadata]', 'Meta data is not configured, it is highly recommended for better SEO');
    try {
        window.sb.head = document.querySelector('head');
        Object.keys(window.sb.meta).forEach(loadMetaTag);
    } catch (e) {
        console.error('INIT ERROR [metadata]', e);
    }
}

function loadMetaTag(key) {
    try {
        if (elementMetaTags.includes(key)) {
            document[key] = window.sb.meta[key];
        } else {
            var meta = document.createElement('meta');
            meta.setAttribute('name', key);
            meta.setAttribute('content', window.sb.meta[key]);
            window.sb.head.appendChild(meta);
        }
    } catch (e) {
        console.error('LOAD ERROR [metadata.' + key + ']', e);
    }
}