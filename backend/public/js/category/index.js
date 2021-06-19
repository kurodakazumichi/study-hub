{
  class Errors 
  {
    /**
     * コンストラクタ
     * @param {string} id
     */
    constructor(id) {
      this.root = $(id);
    }

    /**
     * エラーメッセージを更新
     * @param {string[]} errors 
     */
    update(errors) 
    {
      this.root.html('');

      errors.map((error) => {
        this.root.append(`<p>${error}</p>`);
      });
    }
  }

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
      name: form.find("[name=name]").val()
    };

    console.log(data);

    $.ajax({
      url     : '/api/categories', 
      type    : 'post',
      data    : data,
      dataType: 'json',
    })
    .done((res) => {
      location.reload();
    })
    .fail(() => {
      alert("登録失敗。")
    });    
  }

  $('#create').on('click', createCategoryAsync);
}

//-----------------------------------------------------------------------------
// カテゴリ名の更新フォームをセットアップ
//-----------------------------------------------------------------------------
function SetupCategoryNameEdit() 
{
  $('.category-name').on('change', (e) => {

    const target = $(e.target);
    console.log(target.val());
    console.log(target.data('id'));

    $.ajax({
      url:`/api/categories/${target.data('id')}`,
      type: 'put',
      data : { name : target.val() },
      dataType : 'json'
    })
    .done((res) => {})
    .fail((res) => {});
  });
}

// 初期処理
$(() => {
  const { api } = StudyHub;
  SetupSortable();
  SetupCreateForm();
  SetupCategoryNameEdit();

  const elm = {
    errors: new Errors('#errors'),
  };

  $('.delete').on('click', (e) => {
    const id = $(e.target).data('id');
    
    api.category.delete({
      id,
      done: (data) => {

        console.log(data, status, text); 
      },
      fail: (data) => { 
        elm.errors.update(data.errors);
      },
    })
  })
});
}