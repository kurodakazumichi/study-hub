//-----------------------------------------------------------------------------
// バラエティのテーブルのソート処理をセットアップ
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
        url     : `/api/varieties/${id}/order`, 
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
// バラエティの新規登録フォームをセットアップ
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
      url     : '/api/varieties', 
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
// バラエティ名の更新フォームをセットアップ
//-----------------------------------------------------------------------------
function SetupNameEdit() 
{
  $('.variety-name').on('change', (e) => {

    const target = $(e.target);
    console.log(target.val());
    console.log(target.data('id'));

    $.ajax({
      url:`/api/varieties/${target.data('id')}`,
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

  const { api, components } = StudyHub;

  const page = {
    notice: components.notice('#_notice')
  }

  //--------------------------------------------------------------------------
  // 新規作成
  class Create 
  {
    constructor(id) {
      this.root = $(id);
      this.init();
    }

    init() {
      this.root.find('[name=submit]').on('click', this.onSubmit.bind(this));
    }

    onSubmit() {

      api.variety.create({
        data: this.data,
        done: () => { location.reload(); },
        r422: (data) => {
          page.notice.setItem(data.errors.name).danger();
        },
        fail: (data) => {
          page.notice.setItem(data.message).danger();
        }
      })

      return false;
    }

    get data() {
      return {
        name : this.root.find('[name=name]').val(),
      }
    }
  }

  new Create("#_create-form");

  SetupSortable();
  SetupCreateForm();
  SetupNameEdit();
});