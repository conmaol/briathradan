$(function () {
  /**
   * Set the language session variable
   */
  $('.gdSelect').on('click', function () {
    $.ajax('ajax.php?action=setLang&gdSelect='+$(this).val());
  });

  /**
   * Populate the modal based on click from search result
   */
/*  $('#entryModal').on('show.bs.modal', function (event) {
    let entryLink = $(event.relatedTarget);
    let mhw = entryLink.attr('data-mhw');
    let mpos = entryLink.attr('data-mpos');
    let msub = entryLink.attr('data-msub');
    writeEntry(mhw, mpos, msub);
  });
*/
  $('.entryResult').on('click', function () {
    let entryLink = $(this);
    let mhw = entryLink.attr('data-mhw');
    let mpos = entryLink.attr('data-mpos');
    let msub = entryLink.attr('data-msub');
    writeEntry(mhw, mpos, msub);
  });


  /**
   * Populate the modal based on click from modal content
   */
  $(document).on('click', '.entryRow', function () {
    let mhw = $(this).attr('data-mhw');
    let mpos = $(this).attr('data-mpos');
    let msub = $(this).attr('data-msub');
    writeEntry(mhw, mpos, msub);
  });
});

function writeEntry(mhw, mpos, msub) {
  let modal = $('#entryModal');
  $.getJSON('ajax.php?action=getEntry&mhw='+mhw+'&mpos='+mpos+'&msub='+msub, function (data) {
    modal.find('.modal-content').html(data.html);
  })
    .done(function () {
      $('#entryModal').modal('show');
    });

}