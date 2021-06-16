//-----------------------------------------------------------------------------
// バラエティの新規登録フォームをセットアップ
//-----------------------------------------------------------------------------
function SetupCreateForm() 
{
  const createIndexAsync = () => 
  {
    const form = $("#create-form");
    const study_id = form.find("[name=id]").val();
    const indices  = form.find("[name=index]").val().split('.');

    const data = {
      title    : form.find("[name=title]").val(),
    };

    const keys = ['major', 'minor', 'micro'];

    keys.map((key, index) => 
    {
      const no = indices[index];
      if (no !== undefined && no !== "" && isFinite(no)) {
        data[keys[index]] = parseInt(no);
      }
    });

    $.ajax({
      url     : `/api/studies/${study_id}/indices`, 
      type    : 'post',
      data    : data,
      dataType: 'json',
    })
    .done((res) => {
      alert("登録しました。");
      location.reload();
    })
    .fail(() => {
      alert("登録失敗。")
    });    
  }

  $('#create-button').on('click', createIndexAsync);
}

// 初期処理
$(() => {
  SetupCreateForm();
});