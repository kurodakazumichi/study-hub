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
        this.addError(error);
      });
    }

    addError(error) {
      this.root.append(`<p>${error}</p>`);
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
  const { api } = StudyHub;

  const form = $('#create-form');

  // submitボタンを押したとき
  form.find('[name=submit]').on('click', (e) => {

    api.category.create({
      data: {
        name : form.find('[name=name]').val(),
      },
      done: () => 
      {
        location.reload();
      },
      r422: (data) => {
        for(let key in data.errors) {
          page.elm.errors.addError(data.errors[key]);
        }
      },
      fail: (data) => 
      {
        alert("通信エラー");
        console.log(data);
      }
    });
  });
}

//-----------------------------------------------------------------------------
// カテゴリ名の更新フォームをセットアップ
//-----------------------------------------------------------------------------
function SetupCategoryNameEdit() 
{
  const { api } = StudyHub;

  $('.category-name').on('blur', (e) => {

    const input = $(e.target);
    const id   = input.data('id');
    const name = input.val();

    // 空文字の場合はフォーカスを外さない
    if (name === "") { 
      input.focus(); 
      return; 
    }
    
    api.category.update(id, {
      data: { name },
      done: (data) => { console.log(data); },
      r422: (data) => {
        for(let key in data.errors) {
          page.elm.errors.addError(data.errors[key]);
        }
      },
      fail: (data) => 
      {
        alert("通信エラー");
        console.log(data);
      }
    });
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

  window.page = {
    elm
  };

  $('.delete').on('click', (e) => {
    if (!confirm('削除しますか？')) return;
    
    const id = $(e.target).data('id');
    
    api.category.delete(id, {
      done: () => {
        location.reload();
      },
      r422: (data) => {
        for(let key in data.errors) {
          page.elm.errors.addError(data.errors[key]);
        }
      },
      fail: (data) => 
      {
        alert("通信エラー");
        console.log(data);
      }
    })
  })
});
}