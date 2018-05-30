var SbPreProto = Object.create(HTMLElement.prototype);
SbPreProto.attachedCallback = createSbPre;
document.registerElement('sb-pre', {prototype: SbPreProto});

function createSbPre() {
    if (!this.hasAttribute('component-ref')) return console.error('<sb-pre> error, attr[component-ref] is required');
    try {
        var data = window.sb.components[this.getAttribute('component-ref')];
    } catch (e) {
        return console.error(e);
    }
    var content = document.createElement('pre');
    content.classList.add('p-3', 'border', 'bg-dark', 'text-light');
    content.innerHTML = JSON.stringify(data, null, 2);
    return this.appendChild(content);
}