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
  const { api } = StudyHub;

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
      const to_id   = startingIDs[index];

      api.category.sort({
        data: { from_id, to_id },
        done : (() => { alert('成功'); }),
        fail : (() => { alert('成功'); }),
      });
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