<?php
/**
* Plugin Name: Shifter Offline
* Plugin URI: https://github.com/emaildano/
* Description: tk
* Version: v1.0.0
* Author: Daniel Olson
* Author URI: https://github.com/emaildano
* License: GPL2
* Text Domain: shifter-offline
*/


/*
* Scripts & Styles
*/

add_action('wp_enqueue_scripts', 'shifter_offline_assets' );
add_action('admin_enqueue_scripts', 'shifter_offline_assets' );

function shifter_offline_assets() {
  
  $shifter_offline_js = plugins_url( 'main/main.js', __FILE__ );
  $shifter_offline_css = plugins_url( 'styles/main.css', __FILE__ );

  // wp_register_script('shifter-offline-js', $shifter_offline_js, array(), null, true);
  // wp_enqueue_script('shifter-offline-js');

  // wp_register_style("shifter-offline-css", $shifter_offline_css);
  // wp_enqueue_style('shifter-offline-css');

}

/*
* Meta tags and links
*/

function shifter_offline_head() {
  echo '<link rel="manifest" href="wp-content/plugins/shifter-offline/manifest.json">';
}

add_action( 'wp_head', 'shifter_offline_head' );

/*
* Inline Scripts
*/

function shifter_offline_footer() {
  echo "
  <script>
   if ('serviceWorker' in navigator) {
     window.addEventListener('load', function() {
       navigator.serviceWorker.register('wp-content/plugins/shifter-offline/service-worker.js')
         .then(reg => {
           console.log('Service worker registered! 😎', reg);
         })
         .catch(err => {
           console.log('😥 Service worker registration failed: ', err);
         });
     });
   }
   </script>

   <script>
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', event => {

      // Prevent Chrome 67 and earlier from automatically showing the prompt
      event.preventDefault();

      // Stash the event so it can be triggered later.
      deferredPrompt = event;

      // Attach the install prompt to a user gesture
      document.querySelector('#installBtn').addEventListener('click', event => {

        // Show the prompt
        deferredPrompt.prompt();

        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice
          .then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
              console.log('User accepted the A2HS prompt');
            } else {
              console.log('User dismissed the A2HS prompt');
            }
            deferredPrompt = null;
          });
      });

      // Update UI notify the user they can add to home screen
      document.querySelector('#installBanner').style.display = 'flex';
    });
  </script>
  ";
}

add_action( 'wp_footer', 'shifter_offline_footer' );

/*
* Install link
*/

// function shifter_offline_install_link($wp_admin_bar) {
  
//   $args = array(
//     'id' => 'custom-button',
//     'title' => 'Custom Button',
//     'href' => 'http://example.com/',
//     'meta' => array(
//       'class' => 'custom-button-class'
//     )
//   );
  
//   $wp_admin_bar->add_node($args);
  
// }
  
// add_action('admin_bar_menu', 'shifter_offline_install_link', 50);