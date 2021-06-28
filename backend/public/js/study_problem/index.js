//-----------------------------------------------------------------------------
// 目次の新規登録フォームをセットアップ
//-----------------------------------------------------------------------------
function SetupCreateForm() 
{
  const createProblemAsync = () => 
  {
    const form = $("#create-form");
    const study_id = form.find("[name=study_id]").val();
    const indices  = form.find("[name=index]").val().split('.');

    const data = {
      kind     : form.find("[name=kind]").val(),
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
      url     : `/api/studies/${study_id}/problems`, 
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

  $('#create-button').on('click', createProblemAsync);
}

//-----------------------------------------------------------------------------
// 編集フォームクラス
//-----------------------------------------------------------------------------
class EditForm 
{
  constructor() {
    this.root = $('#edit-container');
    this.form = $('#edit-form');
    this.problem_id = this.form.find('[name=id]');
    this.study_id = this.form.find('[name=study_id]');
    this.title = this.form.find('[name=title]');
    this.index = this.form.find('[name=index]');
    this.mastery = this.form.find('[name=mastery]');
    this.kind    = this.form.find('[name=kind]');
    this.comment = this.form.find('[name=comment]');
    this.note_id = this.form.find('[name=note_id]');

    this.hide();
    $('#edit-button').on('click', this.update.bind(this));
  }

  show() {
    this.root.css('display', 'block');
  }

  hide() {
    this.root.css('display', 'none');
  }

  init(problem_id) {
    this.show();
    this.problem_id.val(problem_id);
    $.ajax({
      url     : `/api/studies/${this.studyId}/problems/${this.problemId}`, 
      type    : 'get',
    })
    .done((res) => {
      this.index.val(this.toIndex(res.data.major, res.data.minor, res.data.micro));
      this.title.val(res.data.title);
      this.mastery.val(res.data.mastery);
      this.comment.val(res.data.comment);
      this.note_id.val(res.data.note_id);
    });
  }

  update() 
  {
    console.log(this.data);
    $.ajax({
      url     : `/api/studies/${this.studyId}/problems/${this.problemId}`, 
      type    : 'put',
      data    : this.data,
      dataType: 'json',
    })
    .done((res) => {
      location.reload();
    });
  }

  get problemId() {
    return this.problem_id.val();
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
      kind: this.kind.val(),
      comment: this.comment.val(),
      note_id: this.note_id.val(),
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
  return false;
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
      url     : `/api/studies/${studyId}/problems/${indexId}`, 
      type    : 'put',
      data    : {mastery},
      dataType: 'json',
    })
    .done((res) => {
      location.reload();
    });    
  });

  return false;
}

// 初期処理
$(() => {
  SetupCreateForm();
  SetupEditButton();
  SetupMasteryUpdate();
});