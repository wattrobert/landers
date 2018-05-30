var SbJumbotronProto = Object.create(HTMLElement.prototype);
SbJumbotronProto.attachedCallback = createSbJumbotron;
document.registerElement('sb-jumbotron', {prototype: SbJumbotronProto});

function createSbJumbotron() {
    if (!this.hasAttribute('component-ref')) return console.error('<sb-jumbotron> error, attr[component-ref] is required');
    try {
        var data = window.sb.components[this.getAttribute('component-ref')];
    } catch (e) {
        return console.error(e);
    }
    var jumbotron = document.createElement('div');

    //add content classes & styles
    jumbotron.classList.add('jumbotron');
    if (data.image) jumbotron.style['background-image'] = 'url("' + data.image + '")';
    if (data.background) data.background[0] === '#' ? jumbotron.style['background-color'] = data.background : jumbotron.classList.add('bg-' + data.background);
    if (data.color) data.color[0] === '#' ? jumbotron.style['color'] = data.color : jumbotron.classList.add('text-' + data.color);
    if (data.align) jumbotron.classList.add('text-' + data.align);

    //build content inner html
    var content = document.createElement('div');
    content.classList.add(window.sb.contained ? 'container' : 'container-fluid');
    

    if (data.title) {
        var title = document.createElement('h1');
        if (data.titleClass) title.classList.add(data.titleClass);
        title.innerHTML = data.title;
        content.appendChild(title);
    }

    if (data.text) {
        var text = document.createElement('p');
        text.classList.add('lead');
        text.innerHTML = data.text;
        content.appendChild(text);
    }

    if (data.button) {
        var button = document.createElement('a');
        var buttonClass = 'btn-' + (data.button.type ? data.button.type : 'light');
        button.classList.add('btn', buttonClass, 'btn-lg');
        button.setAttribute('href', data.button.link);
        button.innerHTML = data.button.text;
        content.appendChild(button);
    }

    jumbotron.appendChild(content);
    return this.appendChild(jumbotron);
}