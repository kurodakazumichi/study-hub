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

// 初期処理
$(() => {
  SetupCreateForm();
});