/**
 * Page-specific Javascript file.  Should generally be included as a separate asset bundle in your page template.
 * example: {{ assets.js('js/pages/sign-in-or-register') | raw }}
 *
 * This script depends on validation rules specified in pages/partials/page.js.twig.
 *
 * Target page: all pages
 */

$.fn.rowCount = function () {
  return $('tr', $(this).find('tbody')).length;
};

function dismissUfMessage(thiselem, msgid) {
  var thistr = jQuery(thiselem).closest("tr.uf_message_row");
  var mesgcard = thistr.closest('.ufmessage-card');
  var thistable = thistr.closest('table');
  thistr.remove();
  var rowCount = thistable.rowCount();
  mesgcard.find('.ufmessage-count').html(rowCount);
  var ajaxurl = '/api/ufmessage/r/' + msgid + '/status';
  var ajaxdata = {};
  ajaxdata.value = 'R';
  ajaxdata[site.csrf.keys.name] = site.csrf.name;
  ajaxdata[site.csrf.keys.value] = site.csrf.value;
  /*
  var request = $.ajax({
    url: ajaxurl,
    method: "POST",
    data: ajaxdata
  });
  */
  reloadcaptcha = false;
  dynamicFormSubmit(ajaxurl, ajaxdata, reloadcaptcha);
  /*
  getAjaxPromise(ajaxurl, ajaxdata).then(function (data) {
    // Run this when your request was successful
    console.log('dismissed')
  }).catch(function (err) {
    console.log(err)
  });
*/

}
$(document).ready(function () {
  //    console.log(jQuery('.dataTable').data())
})