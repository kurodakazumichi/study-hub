//-----------------------------------------------------------------------------
// 目次の一括取り込み処理をセットアップ
//-----------------------------------------------------------------------------
function SetupBatch() {

  $("#batch-file-button").on('change', (e) => {
    var file_reader = new FileReader();

    // ファイルの読み込みを行ったら実行
    file_reader.addEventListener('load', function(e) 
    {
      // study_idを取得
      const study_id = $("#batch-form [name=id]").val();

      // FileReaderを使った、テキストファイルからの読み込みテスト
      const data = {
        text: e.target.result,
      }

      $.ajax({
        url     : `/api/studies/${study_id}/indices/batch`, 
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

    });

    file_reader.readAsText(e.target.files[0]);
  });

}

//-----------------------------------------------------------------------------
// 目次の新規登録フォームをセットアップ
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
  SetupBatch();
  SetupCreateForm();
});