# Foundation

The foundation libraries are the core base of all scripts and controls. The goals of this library are:

- Well structured and readable code.
- Don't leave references to DOM elements.
- Unbind all event handlers.
- Write high-performance code (in cases when it's needed).

That's especially important on pages where users spend much time interacting with the page, like the CMS and Pages sections, but all back-end controls should follow these rules, because we never know when they are used.

```js
import BaseClass from '../../base-class.js';

class Select extends BaseClass
{
    constructor(element, config) {
        super(element, config);

        // do stuff
        //
    }

    dispose() {
        // undo stuff
        //

        super.dispose();
    }


    static get DATANAME() {
        return 'ocSelect';
    }

    static get DEFAULTS() {
        return {
            animation: true,
            autohide: true,
            delay: 5000
        }
    }
}

addEventListener('render', function() {
    document.querySelectorAll('[data-control=select]').forEach(function(el) {
        Select.getOrCreateInstance(el);
    });
});

export default Select;

```
