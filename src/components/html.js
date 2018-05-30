var SbHtmlProto = Object.create(HTMLElement.prototype);
SbHtmlProto.attachedCallback = createSbHtml;
document.registerElement('sb-html', {prototype: SbHtmlProto});

function createSbHtml() {
    if (!this.hasAttribute('component-ref')) return console.error('<sb-html> error, attr[component-ref] is required');
    try {
        var data = window.sb.components[this.getAttribute('component-ref')];
    } catch (e) {
        return console.error(e);
    }
    var content = document.createElement('div');
    content.classList.add('sb-html');
    content.classList.add(window.sb.contained ? 'container' : 'container-fluid');
    content.innerHTML = data.template;
    if (data.background) data.background[0] === '#' ? content.style['background'] = data.background : content.classList.add('bg-' + data.background);
    if (data.color) data.color[0] === '#' ? content.style['color'] = data.color : content.classList.add('text-' + data.color);
    return this.appendChild(content);
}