
(function($) {

    // This will automatically grab the 'title' attribute and replace
    // the regular browser tooltips for all <a> elements with a title attribute!
    //$('a[data-tooltip]').qtip();
    $('a[data-tooltip]').qtip({ // Grab all elements with a non-blank data-tooltip attr.
      content: {
        attr: 'data-tooltip' // Tell qTip2 to look inside this attr for its content
      },position: {
        my: 'bottom center',  // Position my top left...
        at: 'top  center', // at the bottom right of...
        target: $('a[data-tooltip]') // my target
    }
    })

})( jQuery );
