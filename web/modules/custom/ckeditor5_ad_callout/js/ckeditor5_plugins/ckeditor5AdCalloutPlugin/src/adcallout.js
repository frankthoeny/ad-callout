import { Plugin } from 'ckeditor5/src/core';
import AdCalloutEditing from './adcalloutediting';
import AdCalloutUI from './adcalloutui';

export default class AdCallout extends Plugin {
	static get requires() {
		return [ 
            AdCalloutEditing, 
            AdCalloutUI, 
        ];
    }
    
    static get pluginName() {
        return 'AdCallout';
    }
}