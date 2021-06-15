//-----------------------------------------------------------------------------
// カテゴリーテーブルのソート処理をセットアップ
//-----------------------------------------------------------------------------
function SetupSortable() 
{
  // ドラッグ開始時のstudy-idの並び
  let startingIDs = [];

  $('#sortdata').sortable(
  {
    activate: (event, ui) => {
      startingIDs = $("#sortdata").sortable("toArray");
    },   
    // ドラッグ&ドロップ完了時
    update: (event, ui) => 
    {
      // 完了時のstudy_idの並び
      const updatingIDs = $("#sortdata").sortable("toArray");

      // 移動先の位置を探す
      const index = updatingIDs.findIndex((id) => ui.item[0].id == id)

      // 移動させるstudyと、移動先のstudyのidを準備
      const from_id = ui.item[0].id;
      const to_id = startingIDs[index];

      $.ajax({
        url     : `/api/studies/${from_id}/sort`, 
        type    : 'put',
        data    : {to_id},
        dataType: 'json',
      })
      .done(() => { alert("成功"); })
      .fail(() => { alert("失敗"); });
    }
  });
}

//-----------------------------------------------------------------------------
// カテゴリの新規登録フォームをセットアップ
//-----------------------------------------------------------------------------
function SetupCreateForm() 
{
  const createCategoryAsync = () => {
    const form = $("#create-form");
    const data = {
      name       : form.find("[name=name]").val(),
      category_id: form.find('[name=category_id]').val(),
      variety_id : form.find('[name=variety_id]').val(),
    };

    console.log(data);

    $.ajax({
      url     : '/api/studies', 
      type    : 'post',
      data    : data,
      dataType: 'json',
    })
    .done((res, status, xhr) => {
      if (xhr.status === 201) {
        location.reload();
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
      alert("登録失敗。")
    });
  }

  $('#create').on('click', createCategoryAsync);
}

// 初期処理
$(() => {
  SetupSortable();
  SetupCreateForm();
});