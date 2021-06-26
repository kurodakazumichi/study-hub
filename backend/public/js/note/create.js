function SeupCreateForm() 
{
  $("#create-button").on('click', (e) => {

    const form = $('#create-form');
    const data = {
      category_id : form.find('[name=category_id]').val(),
      variety_id : form.find('[name=variety_id]').val(),
      title : form.find('[name=title]').val(),
      body : form.find('[name=body]').val(),
    }

    $.ajax({
      url     : `/api/notes`,
      type    : 'post',
      data    : data,
      dataType: 'json'
    })
    .done((res) => {
      location.href = `/notes/${res.data.id}/edit`;
    })
    .fail((res) => {
      console.log(res);
      console.log(res.responseJSON.message);
    });

  });
}

$(() => {
  SeupCreateForm();
});