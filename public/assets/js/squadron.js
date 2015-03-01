var 	menu = document.getElementById( 'sqn-menu' ),
		menuToggle = document.getElementById( 'sqn-menu-toggle' ),
		body = document.body;

menuToggle.onclick = function() {
	classie.toggle( body, 'sqn-menu-push-open' );
	classie.toggle( menu, 'sqn-menu-open' );
};