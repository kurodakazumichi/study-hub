function SetupEditForm() {
  $("#edit-button").on('click', (e) => {

    const form = $('#edit-form');
    const note_id = form.find('[name=note_id]').val();
    const data = {
      category_id : form.find('[name=category_id]').val(),
      variety_id : form.find('[name=variety_id]').val(),
      title : form.find('[name=title]').val(),
      body : form.find('[name=body]').val(),
    }

    $.ajax({
      url     : `/api/notes/${note_id}`,
      type    : 'put',
      data    : data,
      dataType: 'json'
    })
    .done((res) => {
      console.log(res);
    })
    .fail((res) => {
      console.log(res);
      console.log(res.responseJSON.message);
    });

  });
}

$(() => {
  SetupEditForm();

  $("#_tab").tabs({
    activate : (_, ui) => {

      if (ui.newPanel.attr('id') !== "_tab-preview") return;

      const data = $('#edit-form [name=body]').val();
      const view = $('#_view');

      // markdownを表示
      my_marked(view, data);
    }
  });

});