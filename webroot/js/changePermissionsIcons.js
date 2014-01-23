/*
 * Change Permissions Icons
 *
 * A jQuery extension to change controllers's permissions icons.
 *
 * @author        Pilar Rodriguez Cabrero - dongit.nl
 */

if (typeof jQuery != 'undefined') {
	var notAllowIcon = "/img/test-fail-icon.png";
	var allowIcon = "/img/test-pass-icon.png";

	// Creating an inicial values with the icon for the "no changes" selected boxes
	$( "select option:selected" ).each(function () {
		if ( $(this).val() == '' ) {
			select = $(this).parent()
			$(select).data( 'init', $(select).prev().attr("src") )
		}
	})

	// Funtion to set the icon
	jQuery.fn.setIcon = function (icon) {
		$(this).prev().attr( "src", icon )
	}
	
	// Check the children recursevely to change their icons
	function checkChildren ( controllers_selection, level, newIcon ) {		
		$(controllers_selection).each(function() {				
			if ( $(this).attr('data-level') != level ) {		
				return
			}	
			controllerName = $(this).attr('data-controller')
			controllers_subselection = $(controllers_selection).filter(function() {
        return $(this).attr('data-controller').match(controllerName + '+')
			})
			select = $(this).find('select')
			// If 'inherit' option is selected, or if is selected 'no change' option and has no initial value, change his icon
			if ( $(select).val() == 'inherit' || ( $(select).val() == '' && ( typeof $(select).data('init') === 'undefined' ))) {
				$(select).setIcon(newIcon)				
				checkChildren( controllers_subselection, level + 1, newIcon )
			}
		})
	}
	
	// Check the parent's icon to set the value of the child's icon
	function checkParent ( child, controllers_selection, controllerName, level ) {
		if (level >= 0) {
			// Select the controller name and drop the last part after :
			parent_id = controllerName.split(':').slice( 0, level + 1 ).join(':')
			$(controllers_selection).each(function() {		
				if ( $(this).attr('data-level') != level ) {		
					return
				}	
				console.log(parent_id)
				console.log($(this).attr('data-controller'))
				if ( $(this).attr('data-controller') == parent_id )	{				
					newIcon = $(this).find('img').attr('src')
					$(child).setIcon(newIcon)	
					controllers_selection = $(controllers_selection).filter(function() {
						return $(this).attr('data-controller').match(controllerName + '+')
					})					
					checkChildren( controllers_selection, level + 2,  newIcon )
					return false
				}
			})
		}
		// If is the root has no parent, so set the icon to 'not allow icon'
		else {
			$(child).setIcon(notAllowIcon)
			checkChildren( controllers_selection, level + 1,  notAllowIcon )
		}
	}

	$('select').on('change', function() {	
		table_cell = $(this).parent().parent()
		role = $(table_cell).find('td').index($(this).parent())
		level =  parseInt($(this).parent().attr('data-level'))		
		controllerName = $(this).parent().attr('data-controller')
		role_column = $('tr').find('td:eq(' + role + ')')
		// Select just the controllers that have to change their icons
		controllers_selection = $(role_column).filter(function() {
			return $(this).attr('data-controller').match(controllerName + '+')
		})
		switch( $(this).val() ) {
			case 'deny' : 
				$(this).setIcon(notAllowIcon)
				checkChildren( controllers_selection, level + 1,  notAllowIcon )
				break
			case 'allow' :
				$(this).setIcon(allowIcon)
				checkChildren( controllers_selection, level + 1,  allowIcon )
				break	
			case 'inherit' :					
				checkParent( $(this), role_column, controllerName, level - 1 )
				break
			// If 'no change' is selected and if select has a previous value, set the icon to this value. Else set the icon to 'not allow icon' and check all
			case '' :
				if ( typeof $(this).data('init') !== 'undefined' ) {
					$(this).setIcon($(this).data('init') )
					checkChildren( controllers_selection, level + 1, $(this).data('init') )
				}
				else {
					$(this).setIcon(notAllowIcon)
					checkParent( $(this), role_column, controllerName, level - 1 )
				}
				break
		}
	})
}