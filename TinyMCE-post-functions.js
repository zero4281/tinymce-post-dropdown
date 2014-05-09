function TMCEPD_draw_button() {
	 var attr = [];
	 for(var i in dropDownParams) {
	 	attr[i] = {text: dropDownParams[i]['post_title'], value: dropDownParams[i]['ID']};
	 }
    tinymce.PluginManager.add( 'TMCEPD_dropdown_button', function( editor, url ) {
        // Add a button that opens a window and adds a URL
        editor.addButton( 'TMCEPD_dropdown_shortcode_key', {
        		
            //text: 'Button',
            icon: 'dashicons dashicons-editor-insertmore', //<div class="dashicons dashicons-editor-insertmore"></div>
            //icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'TinyMCE Post Dropdown Shortcode',
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
                        editor.insertContent( '[tinypost postnumber=\''+e.data.post+'\']' );
                    }
                } );
            }
        } );
    } );

}