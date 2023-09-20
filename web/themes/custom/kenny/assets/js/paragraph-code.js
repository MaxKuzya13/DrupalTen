/**
 * @file
 * Paragraps code highlight behaviors
 */


(function ($, Drupal, once) {

  Drupal.behaviors.paragraphCodeHighlight = {
    attach: function (context, settings) {
      const $elements = $(context).find('.paragraph-code__field-body > p');
      if ($elements.length) {
        $elements.each(function () {
          hljs.highlightBlock(this);
        });
      }
    }
  };

})(jQuery, Drupal, once);
