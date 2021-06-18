//-----------------------------------------------------------------------------
// 目次の一括取り込み処理をセットアップ
//-----------------------------------------------------------------------------
function SetupBatch() {

  $("#batch-file-button").on('change', (e) => {

    if (confirm("既に登録されているデータは全て削除されますが本当によろしいですか？") === false) {
      return;
    }

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
    const study_id = form.find("[name=study_id]").val();
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

//-----------------------------------------------------------------------------
// 編集フォームクラス
//-----------------------------------------------------------------------------
class EditForm 
{
  constructor() {
    this.root = $('#edit-container');
    this.form = $('#edit-form');
    this.index_id = this.form.find('[name=id]');
    this.study_id = this.form.find('[name=study_id]');
    this.title = this.form.find('[name=title]');
    this.index = this.form.find('[name=index]');
    this.mastery = this.form.find('[name=mastery]');
    this.comment = this.form.find('[name=comment]');
    this.link    = this.form.find('[name=link]');

    this.hide();
    $('#edit-button').on('click', this.update.bind(this));
  }

  show() {
    this.root.css('display', 'block');
  }

  hide() {
    this.root.css('display', 'none');
  }

  init(index_id) {
    this.show();
    this.index_id.val(index_id);

    $.ajax({
      url     : `/api/studies/${this.studyId}/indices/${this.indexId}`, 
      type    : 'get',
    })
    .done((res) => {
      this.index.val(this.toIndex(res.data.major, res.data.minor, res.data.micro));
      this.title.val(res.data.title);
      this.mastery.val(res.data.mastery);
      this.comment.val(res.data.comment);
      this.link.val(res.data.link);      
    });
  }

  update() 
  {
    console.log(this.data);
    $.ajax({
      url     : `/api/studies/${this.studyId}/indices/${this.indexId}`, 
      type    : 'put',
      data    : this.data,
      dataType: 'json',
    })
    .done((res) => {
      location.reload();
    });
  }

  get indexId() {
    return this.index_id.val();
  }

  get studyId() {
    return this.study_id.val();
  }

  get major() {
    const major = this.index.val().split('.')[0];
    return (major !== "0" && !major)? null : major;
  }

  get minor() {
    const minor = this.index.val().split('.')[1];
    return (minor !== "0" && !minor)? null : minor;
  }

  get micro() {
    const micro = this.index.val().split('.')[2];
    return (micro !== "0" && !micro)? null : micro;
  }

  get data() {
    const data = {
      major: this.major,
      minor: this.minor,
      micro: this.micro,
      mastery: this.mastery.val(),
      title: this.title.val(),
      comment: this.comment.val(),
      link: this.link.val(),      
    }

    return data;
  }

  toIndex(major, minor, micro) {

    let index = "";
    if (typeof(major) === 'number') {
      index += major + ".";
    }
    if (typeof(minor) === 'number') {
      index += minor + ".";
    }
    if (typeof(micro) === 'number') {
      index += micro;
    }
    return index;
  }
}

function SetupEditButton() {
  const form = new EditForm();
  $(".edit-button").on('click', (e) => {
    form.init($(e.target).data('id'));
  });
}

//-----------------------------------------------------------------------------
// Masteru Update
//-----------------------------------------------------------------------------
function SetupMasteryUpdate() {
  $('.edit-mastery').on('click', (e) => {
    const target = $(e.target);
    const indexId = target.data('id');
    const studyId = target.data('study_id');
    const mastery = target.data('mastery');

    $.ajax({
      url     : `/api/studies/${studyId}/indices/${indexId}`, 
      type    : 'put',
      data    : {mastery},
      dataType: 'json',
    })
    .done((res) => {
      location.reload();
    });    
  });
}

// 初期処理
$(() => {
  SetupBatch();
  SetupCreateForm();
  SetupEditButton();
  SetupMasteryUpdate();
});