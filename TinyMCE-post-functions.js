function TMCEBB_draw_button() {
	 var attr = [];
	 for(var i in dropDownParams) {
	 	attr.push({text: dropDownParams[i].post_title, value: dropDownParams[i].ID});
	 }
    tinymce.PluginManager.add( 'TMCEBB_dropdown_button', function( editor, url ) {
        // Add a button that opens a window and adds a URL
        editor.addButton( 'TMCEBB_dropdown_shortcode_key', {
        		
            //text: 'Button',
            icon: 'dashicons icon-link',
            //icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Bootstrap Button Shortcode',
                    body: [
                    {
                    		type: 'listbox',
                    		name: 'post',
                    		label: 'Select a Post',
                    		'values': attr
                    }
                    ],
                    onsubmit: function( e ) {
                        // Insert content when the window form is submitted
                        editor.insertContent( '[dropdown postnumber=\''+e.data.post+'\']' );
                        //[dropdown postnumber='ID']
                    }
                } );
            }
        } );
    } );

}