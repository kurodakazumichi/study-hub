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
  SetupCreateForm();
  SetupNameEdit();
});