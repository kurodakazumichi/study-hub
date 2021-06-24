//*****************************************************************************
// StudyHub.js
//*****************************************************************************
const StudyHub = {};

//-----------------------------------------------------------------------------
// api section
//-----------------------------------------------------------------------------
{
  const loader = {
    show: () => { $('#_loader').show(); },
    hide: () => { $('#_loader').hide(); },
  };

  api = {
    /**
     * 
     * @param {*} options APIを呼び出すのに必要なパラメータ群
     * @param {*} funcs コールバック用の関数群
     */
    ajax: (options, funcs) => {

      const callFunc = (funcs, method, data, status, statusText) => 
      {
        if (funcs[method]) {
          console.log(funcs[method]);
          funcs[method](data, status, statusText); 
          return;
        }
        
        if (status < 200 || 299 < status && funcs['fail']) {
          funcs['fail'](data, status, statusText);
        }
      }

      loader.show();

      $.ajax(options)
        .done((res, _, xhr) => {
          loader.hide();
          callFunc(funcs, 'done', res, xhr.status, xhr.statusText);
        })
        .fail((res) => {
          loader.hide();
          callFunc(funcs, `r${res.status}`, res.responseJSON, res.status, res.statusText);
        });
    }    
  };

  //---------------------------------------------------------------------------
  // Category API
  api.category = 
  {
    // 新規作成
    create: (params) => {
      api.ajax({
        url : `/api/categories`,
        type: 'post',
        data: params.data,
        dataType: 'json'
      }, params);
    },

    // 編集
    update: (id, params) => {
      api.ajax({
        url : `/api/categories/${id}`,
        type: 'put',
        data: params.data,
        dataType: 'json'
      }, params);
    },

    // 削除
    delete: (id, params) => {
      api.ajax({
        url : `/api/categories/${id}`,
        type: 'delete',
        dataType: 'json',
      }, params);
    },

    // 並び替え
    sort: (params) => {
      api.ajax({
        url     : `api/categories/sort`,
        type    : 'put',
        data    : params.data,
        dateType: 'json'
      }, params);
    },
  }

  //---------------------------------------------------------------------------
  // Variety API
  api.variety = 
  {
    // 新規作成
    create: (params) => {
      api.ajax({
        url : `/api/varieties`,
        type: 'post',
        data: params.data,
        dataType: 'json'
      }, params);
    },

    // 編集
    update: (id, params) => {
      api.ajax({
        url : `/api/varieties/${id}`,
        type: 'put',
        data: params.data,
        dataType: 'json'
      }, params);
    },

    // 削除
    delete: (id, params) => {
      api.ajax({
        url : `/api/varieties/${id}`,
        type: 'delete',
        dataType: 'json',
      }, params);
    },

    // 並び替え
    sort: (params) => {
      api.ajax({
        url     : `api/varieties/sort`,
        type    : 'put',
        data    : params.data,
        dateType: 'json'
      }, params);
    },
  }  

  StudyHub.api = api; // 割り当て
}

//-----------------------------------------------------------------------------
// components section
//-----------------------------------------------------------------------------
{
  //---------------------------------------------------------------------------
  // Notice Component
  class Notice 
  {
    constructor(id) 
    {
      this.root = $(id);
      this.alerts = $(this.root.find(".alerts")[0]);
      this._init();
    }

    show() {
      this.root.show();
      return this;
    }

    hide() {
      this.root.hide();
      return this;
    }

    clear() {
      this.alerts.html('');
      return this;
    }

    addItem(item) {
      this.alerts.append(`<p class="alerts__item">${item}</p>`);
      return this;
    }

    addItems(items) {
      items.map((item) => { this.addItem(item); });
      return this;
    }

    setItem(item) {
      this.clear().addItem(item);
      return this;
    }

    setItems(items) {
      this.clear().addItems(items);
      return this;
    }    

    danger() {
      this.alerts.attr('class', 'alerts alerts--danger');
      this.show();
      return this;
    }

    success() {
      this.alerts.attr('class', 'alerts alerts--success');
      this.show();
      return this;
    }

    _init() {
      this.root.on('click', this._onClick.bind(this));
    }

    _onClick(e) {
      this.hide();
    }    
  };

  // Factory
  StudyHub.components = {
    notice: (id) => { return new Notice(id); }
  }
}