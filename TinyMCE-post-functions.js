function TMCEBB_draw_button() {
	 console.log(dropDownParams);
	 for(var i in dropDownParams) {
	 	//var attr[] = [{text: dropDownParams[i]['post_title'], value: dropDownParams[i]['ID']}];
	 }
	 console.log(attr);
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
                    		'values': [
                    			{text: 'post title1', value: 'post number1'},
                    			{text: 'post title2', value: 'post number2'}
                    		]
                    }
                    ],
                    onsubmit: function( e ) {
                        // Insert content when the window form is submitted
                        editor.insertContent( '[button title=\''+e.data.title+'\' url=\''+e.data.url+'\']' );
                        //[button title='title' url='url']
                    }
                } );
            }
        } );
    } );

}