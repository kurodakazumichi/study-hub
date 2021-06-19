$(() => {

  $('#create').on('click', () => {
    const form = $('#create-form');

    const data = {
      category_id : form.find('[name=category_id]').val(),
      variety_id : form.find('[name=variety_id]').val(),
      difficulty : form.find('[name=difficulty]').val(),
      title : form.find('[name=title]').val(),
      condition : form.find('[name=condition]').val(),
    };

    $.ajax({
      url: '/api/achievements',
      type: 'post',
      data: data,
      dataType: 'json'
    })
    .done((res) => { console.log(res); })
    .fail((res) => { console.log(res); })
  });

});

$(() => {

  $('.edit-button').on('click', (e) => {

    const id = $(e.target).data('id');
    
    $.ajax({
      url: `/api/achievements/${id}`,
      type:'get',
    })
    .done((res) => {
      const form =$('#edit-form');
      form.find('[name=id]').val(res.data.id);
      form.find('[name=category_id]').val(res.data.category_id);
      form.find('[name=variety_id]').val(res.data.variety_id);
      form.find('[name=difficulty]').val(res.data.difficulty);
      form.find('[name=title]').val(res.data.title);
      form.find('[name=condition]').val(res.data.condition);
      form.find('[name=note_id]').val(res.data.note_id);
    })
  });

  $('#edit').on('click', () => {
    const form =$('#edit-form');
    const data = {
      category_id : form.find('[name=category_id]').val(),
      variety_id : form.find('[name=variety_id]').val(),
      difficulty : form.find('[name=difficulty]').val(),
      title : form.find('[name=title]').val(),
      condition : form.find('[name=condition]').val(),
      note_id : form.find('[name=note_id]').val(),
    }

    const id = form.find('[name=id]').val();
    console.log(data);
    $.ajax({
      url: `/api/achievements/${id}`,
      type: 'put',
      data: data,
      dataType: 'json'
    })
    .done((res) => {
      console.log(res);
    })
    .fail((res) => {
      console.log(res);
    });
  });

  $('.open-button'). on('click', (e) => {

    const id = $(e.target).data('id');
    $.ajax({
      url: `/api/achievements/${id}/open`,
      type: 'put'
    }).done((res) => { console.log(res); })

  });

  $('.close-button'). on('click', (e) => {

    const id = $(e.target).data('id');
    $.ajax({
      url: `/api/achievements/${id}/close`,
      type: 'put'
    }).done((res) => { console.log(res); })

  });


});