//*****************************************************************************
// StudyHub.js
//*****************************************************************************
const StudyHub = {};

//-----------------------------------------------------------------------------
// api section
//-----------------------------------------------------------------------------
{
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
          funcs[method](data, status, statusText); return;
        }
        
        if (status < 200 || 299 < status && funcs['fail']) {
          funcs['fail'](data, status, statusText);
        }
      }

      $.ajax(options)
        .done((res, _, xhr) => {
          callFunc(funcs, 'done', res, xhr.status, xhr.statusText);
        })
        .fail((res) => {
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
      console.log(params);
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

  StudyHub.api = api; // 割り当て
}