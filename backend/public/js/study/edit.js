//-----------------------------------------------------------------------------
// Studyの編集フォームをセットアップ
//-----------------------------------------------------------------------------
function SetupEditForm() 
{
  const createCategoryAsync = () => {
    const form = $("#edit-form");
    const id = form.find('[name=id]').val();

    const data = {
      name       : form.find("[name=name]").val(),
      category_id: form.find('[name=category_id]').val(),
      variety_id : form.find('[name=variety_id]').val(),
      link       : form.find('[name=link]').val(),
      note_id    : form.find('[name=note_id]').val(),
      eval       : form.find('[name=eval]').val(),
      comment    : form.find('[name=comment]').val()
    };

    console.log(data);

    $.ajax({
      url     : `/api/studies/${id}`, 
      type    : 'put',
      data    : data,
      dataType: 'json',
    })
    .done((res, status, xhr) => {
      if (xhr.status === 200) {
        alert("更新完了")
        return;
      }

      const errors = $("#errors").html("");
      for(const key in res.errors) {
        res.errors[key].map((error) => {
          errors.append(`<li>${error}</li>`);
        });
      }
    })
    .fail((res) => {
      alert("編集失敗。")
    });
  }

  $('#create').on('click', createCategoryAsync);
}

// 初期処理
$(() => {
  SetupEditForm();
});