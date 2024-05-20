import { Plugin } from 'ckeditor5/src/core';
import { ButtonView, Dialog, View  } from 'ckeditor5/src/ui';
import { ClassicEditor } from '@ckeditor/ckeditor5-editor-classic';
import { Paragraph } from 'ckeditor5/src/paragraph';
import { Essentials } from '@ckeditor/ckeditor5-essentials';
import { Bold, Italic } from '@ckeditor/ckeditor5-basic-styles';

export default class AdCalloutUI extends Plugin {
    // Make sure the "AdCallout" plugin is loaded.
    get requires() {
        return [ AdCallout ];
    }

    init() {
        // Add a button to the component factory so it is available for the editor.
        this.editor.ui.componentFactory.add( 'adCallout', locale => {
            const buttonView = new ButtonView( locale );

            buttonView.set( {
                label: 'Ad Callout',
                tooltip: true,
                withText: true
            } );

            // Define the button behavior on press.
            buttonView.on( 'execute', () => {
                const dialog = this.editor.plugins.get( 'AdCallout' );

                // If the button is turned on, hide the modal.
                if ( buttonView.isOn ) {
                    dialog.hide();
                    buttonView.isOn = false;

                    return;
                }

                buttonView.isOn = true;

                // Otherwise, show the modal.
                // First, create a view with some simple content. It will be displayed as the dialog's body.
                const textView = new View( locale );

                textView.setTemplate( {
                    tag: 'div',
                    attributes: {
                        style: {
                            padding: 'var(--ck-spacing-large)',
                            whiteSpace: 'initial',
                            width: '100%',
                            maxWidth: '500px'
                        },
                        tabindex: -1
                    },
                    children: [
                        'This is a sample content of the modal.',
                        'You can put here text, images, inputs, buttons, etc.'
                    ]
                } );

                // Tell the plugin to display a modal with the title, content, and one action button.
                dialog.show( {
                    isModal: true,
                    title: 'Ad Callout',
                    content: textView,
                    actionButtons: [
                        {
                            label: 'Add',
                            class: 'ck-button-action',
                            withText: true,
                            onExecute: () => dialog.hide()
                        }
                    ],
                    onHide() { buttonView.isOn = false; }
                } );
            } );

            return buttonView;
        } );
    }
}

// Create an editor instance. Remember to have an element with the `[id="editor"]` attribute in the document.
ClassicEditor
    .create( document.querySelector( '#editor' ), {
        plugins: [ Essentials, Paragraph, Bold, Italic, MinimalisticDialog, Dialog ],
        toolbar: [ 'bold', 'italic', '|', 'showDialog' ]
    } )
    .catch( error => {
        console.error( error.stack );
    } );