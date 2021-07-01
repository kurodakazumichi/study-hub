// 初期処理
$(() => {

  const { api, components } = StudyHub;

  const page = {
    notice: components.notice('#_notice'),
  }

  //--------------------------------------------------------------------------
  // フォーム
  class Form 
  {
    constructor(id) {
      this.ui = {
        root: $(id)
      }
      this._setupUI();
    }

    get mode() {
      return (!this.id)? "create" : "update";
    }

    get id() {
      return this.ui.input.id.val();
    }

    set id(v) {
      this.ui.input.id.val(v);
    }

    get data() {
      const { input } = this.ui;

      return {
        category_id: input.categoryId.val(),
        variety_id : input.varietyId.val(),
        name       : input.name.val(),
        order_no   : input.orderNo.val(),
        link       : input.link.val(),
        note_id    : input.noteId.val(),
        difficulty : input.difficulty.val()
      }
    }

    set data(v) {
      const { input } = this.ui;
      input.categoryId.val(v.category_id);
      input.varietyId.val(v.variety_id);
      input.name.val(v.name);
      input.orderNo.val(v.order_no);
      input.link.val(v.link);
      input.noteId.val(v.note_id);
      input.difficulty.val(v.difficulty);
    }

    update() {
      this.ui.text.id.html((this.id)? this.id : "新規");
      
      if (this.mode === "update" && !this.data.note_id) {
        this.ui.action.note.show();
      } else {
        this.ui.action.note.hide();
      }
    }

    // form内のUIを取得して保持する
    _setupUI() 
    {
      // 入力
      const input = {
        id         : this.ui.root.find('[name=id]'),
        categoryId : this.ui.root.find('[name=category_id]'),
        varietyId  : this.ui.root.find('[name=variety_id]'),
        name       : this.ui.root.find('[name=name]'),
        orderNo    : this.ui.root.find('[name=order_no]'),
        link       : this.ui.root.find('[name=link]'),
        noteId     : this.ui.root.find('[name=note_id]'),
        difficulty : this.ui.root.find('[name=difficulty]')
      }

      this.ui.input = input;

      // text
      this.ui.text = {
        id: $(this.ui.root.find('._text-id')[0])
      };

      // action
      this.ui.action = {
        note: $(this.ui.root.find('._lnk-note')[0]),
        save: $(this.ui.root.find('._btn-save')[0]),
      }

      // Eventを割り当てる
      this.ui.action.save.on('click', this.onSave.bind(this));

      // 更新
      this.update();
    }

    onSave() {
      api.study.create({
        data: this.data,
        done: () => { location.reload(); },
        fail: (data) => { 
          page.notice
            .setItem(data.errors.category_id)
            .addItem(data.errors.variety_id)
            .addItem(data.errors.name)
            .danger();
        }
      })
    }
  }

  //--------------------------------------------------------------------------
  // タブ
  class Tabs 
  {
    constructor(id) {
      this.id = id;
      $(id).tabs();
      $(id).removeClass('ui-corner-all');
    }

    active(index) {
      $(this.id).tabs('option', 'active', index);
    }

    activeSearch() {
      this.active(0);
    }

    activeForm() {
      this.active(1);
    }
  }  

  page.form = new Form("#_tab-form");
  page.tabs = new Tabs("#_tab");
  
});