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

      api.category.create({
        data: this.data,
        done: () => { location.reload(); },
        r422: (data) => {
          page.notice.setItem(data.errors.name).danger();
        },
        fail: (data) => {
          page.notice.setItems(data.errors).danger();
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

  //--------------------------------------------------------------------------
  // 編集
  class Update {
    constructor(selector) {
      $(selector).on('blur', this.onBlur.bind(this));
    }

    onBlur(e) {
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
        done: (data) => { 
          page.notice.setItem(data.message).success();
        },
        r422: (data) => {
          page.notice.setItem(data.errors.name).danger();
        },
        fail: (data) => {
          page.notice.setItems(data.errors).danger();
        }
      });
    }
  }  

  //--------------------------------------------------------------------------
  // 削除
  class Destory {
    constructor(selector) {
      $(selector).on('click', this.onClick.bind(this));
    }
    
    onClick(e) 
    {
      if (!confirm('削除しますか？')) return;

      const id = $(e.target).data('id');

      api.category.delete(id, {
        done: ()     => { location.reload(); },
        fail: (data) => { page.notice.setItems(data.errors).danger(); }
      });
      return false;      
    }
  }

  //--------------------------------------------------------------------------
  // 並び替え
  class Sort 
  {
    constructor(id) 
    {
      this.startingIDs = []; // ソート開始時のIDの並び
      this.root = $(id);
      this._init();
    }

    _init() {
      this.root.sortable({
        activate: this.onActivate.bind(this),
        update  : this.onUpdate.bind(this),
      });
    }

    // ドラック開始時にIDの並びを保存
    onActivate(e, ui) {
      this.startingIDs = this.currentIDs;
    }

    // ドラック完了時にAPIコール
    onUpdate(e, ui) 
    {
      const updatedIDs = this.currentIDs;

      // 移動先の位置を探す
      const index = updatedIDs.findIndex((id) => ui.item[0].id == id);

      // 移動するIDと、移動先のID
      const from_id = ui.item[0].id;
      const to_id   = this.startingIDs[index];

      api.category.sort({
        data: { from_id, to_id },
        done : (() => { page.notice.setItem('成功').success(); }),
        fail : (() => { page.notice.setItem('失敗').danger(); }),
      });
    }

    // 現状の並びのID配列を取得
    get currentIDs() {
      return this.root.sortable("toArray");
    }

  }  

  new Create("#_create-form");
  new Update("#_sortable .name")
  new Destory(".btn._delete");
  new Sort("#_sortable");

});