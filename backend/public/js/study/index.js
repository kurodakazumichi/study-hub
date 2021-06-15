//-----------------------------------------------------------------------------
// カテゴリーテーブルのソート処理をセットアップ
//-----------------------------------------------------------------------------
function SetupSortable() 
{
  $('#sortdata').sortable(
  {
    // ドラッグ&ドロップ完了時
    stop: (event, ui) => 
    {
      const target = $(ui.item[0]);
      console.log("target", target.data("id"), target.data("order-no"));

      const id = target.data("id");
      let order_no = 0;

      $("#sortdata").children().each((index, e) => {
        if (target.data('id') == $(e).data('id')) {
          console.log("target order_no = " + index);
          order_no = index;
        }
      });

      console.log("ajax");
      $.ajax({
        url     : `/api/categories/${id}/order`, 
        type    : 'put',
        data    : {order_no},
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
  SetupCreateForm();
});