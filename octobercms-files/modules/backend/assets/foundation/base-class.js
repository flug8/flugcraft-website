import Config from './util/config';
import Data from './util/data';

export default class BaseClass
{
    static proxyCounter = 0;

    constructor(element, config) {
        element = getElement(element);
        if (!element) {
            return;
        }

        this.element = element;
        this.config = this.getConfig(config);
        this.proxiedMethods = {};
        this.markDisposable();

        Data.set(this.element, this.constructor.DATANAME, this);
    }

    // Public
    dispose() {
        Data.remove(this.element, this.constructor.DATANAME)

        this.forget('october:dispose', this.proxy(this.dispose));

        for (const key in this.proxiedMethods) {
            this.proxiedMethods[key] = null;
        }

        for (const propertyName of Object.getOwnPropertyNames(this)) {
            this[propertyName] = null;
        }
    }

    // Static
    static getInstance(element) {
        return Data.get(getElement(element), this.DATANAME);
    }

    static getOrCreateInstance(element, config = {}) {
        return this.getInstance(element) || new this(element, typeof config === 'object' ? config : null);
    }

    // Events
    listen(eventName, handler, callback) {
        return oc.Events.on(this.element, eventName, handler, callback);
    }

    listenOnce(eventName, handler, callback) {
        return oc.Events.one(this.element, eventName, handler, callback);
    }

    forget(eventName, handler, callback) {
        return oc.Events.off(this.element, eventName, handler, callback);
    }

    dispatch(eventName, args = {}) {
        return oc.Events.dispatch(eventName, { target: this.element, ...args });
    }

    // Private
    markDisposable() {
        this.element.setAttribute('data-disposable', '')
        this.listen('october:dispose', this.proxy(this.dispose));
    }

    onDispose(callback) {
        this.listen('october:dispose', this.proxy(callback));
    }

    proxy(method) {
        if (method.ocProxyId === undefined) {
            BaseClass.proxyCounter++;
            method.ocProxyId = BaseClass.proxyCounter;
        }

        if (this.proxiedMethods[method.ocProxyId] !== undefined) {
            return this.proxiedMethods[method.ocProxyId];
        }

        this.proxiedMethods[method.ocProxyId] = method.bind(this);

        return this.proxiedMethods[method.ocProxyId];
    }

    getConfig(config) {
        return {
            ...this.constructor.DEFAULTS,
            ...Config.getDataAttributes(this.element),
            ...(typeof config === 'object' ? config : {})
        }
    }
}

function getElement(element) {
    if (typeof object === 'string' && object.length > 0) {
        return document.querySelector(object);
    }

    return element;
}
