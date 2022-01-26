$(function () {
  /**
   * Set the language session variable
   */
  $('.gdSelect').on('click', function () {
    $.ajax('ajax.php?action=setLang&gdSelect='+$(this).val());
  });

  /**
   * Fetch the params (from either a search result or link in existing modal content) required to write an entry
   * then call writeEntry to populate and show the modal
   */
  $(document).on('click', '.entryRow', function () {
    let mhw = $(this).attr('data-mhw');
    let mpos = $(this).attr('data-mpos');
    let msub = $(this).attr('data-msub');
    writeEntry(mhw, mpos, msub);
  });

  /**
   * show a random entry on click of the link
   */
  $('.randomEntry').on('click', function() {
    writeEntry('', '', '');
  });

});

/**
 * Populate the modal using AJAX data and show
 * @param mhw
 * @param mpos
 * @param msub
 */
function writeEntry(mhw, mpos, msub) {
  let modal = $('#entryModal');
  $.getJSON('ajax.php?action=getEntry&mhw='+mhw+'&mpos='+mpos+'&msub='+msub, function () {
  })
    .done(function (data) {
  modal.find('.modal-content').html(data.html);
  $('#entryModal').modal('show');
    });
}
