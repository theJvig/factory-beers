// Main frontend entry point
// Importing SCSS here tells @wordpress/scripts to compile it into build/main.css
import '../scss/main.scss';

// Your theme JavaScript goes here
document.addEventListener( 'DOMContentLoaded', () => {
	console.log( 'Theme loaded.' );
} );