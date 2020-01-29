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
  var tableid = thistable.attr('id');
  thistr.remove();
  var rowCount = thistable.rowCount();
  //  mesgcard.find('.ufmessage-count').html(rowCount);
  var ajaxurl = '/api/ufmessage/r/' + msgid + '/status';
  var ajaxdata = {};
  ajaxdata.value = 'R';
  ajaxdata[site.csrf.keys.name] = site.csrf.name;
  ajaxdata[site.csrf.keys.value] = site.csrf.value;
  reloadcaptcha = false;
  dynamicFormSubmit(ajaxurl, ajaxdata, reloadcaptcha, function (event, data, textStatus, jqXHR) {
    var dttable = jQuery('#' + tableid).closest("table.dataTable");
    afterDismiss(tableid, data, textStatus);
  });

  function afterDismiss(tableid, data, textStatus) {
    var thetable = jQuery('#' + tableid);
    var tablerows = thetable.rowCount();
    if (tablerows < 2) {
      if (thetable.hasClass('dataTable')) {
        reloadDatatable(tableid);
      }
    }
  }

}
$(document).ready(function () {
  $(".control-sidebar-open").focusout(function () {
    jQuery(tiis).removeClass('control-sidebar-open');
    jQuery(tiis).css('display', 'none');
  });
  //    console.log(jQuery('.dataTable').data())
})