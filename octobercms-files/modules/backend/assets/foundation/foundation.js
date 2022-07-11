import { Controller } from './controller';
import BaseClass from './base-class';

// Self starting instance
const instance = new Controller;

if (window.oc) {
    window.oc.Foundation = instance;
    window.oc.FoundationBase = BaseClass;
}

instance.start();

/*
 |--------------------------------------------------------------------------
 | Foundational Components
 |--------------------------------------------------------------------------
 |
 */

export { default as Select } from './controls/select/select';
