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

      // 通信失敗時のコールバックを呼び出すための関数
      const callFailFunction = (funcs, data, status, statusText) => 
      {
        // ステータスコードに対応したコールバックがあればそれを呼ぶ(r500, r422)など
        const name = `r${status}`;

        if (funcs[name]) {
          funcs[name](data, status, statusText);
          return;  
        }

        // fallback
        funcs['fail'] && funcs['fail'](data, status, statusText);
      }

      $.ajax(options)
        .done((res, statusText, xhr) => 
        {
          // validationエラーになった時、何故か422ではなく、常にstatus 200が返ってくる。
          // 200の時に、レスポンスには errors という項目は含まれないが、もし含まれていた場合はエラー扱いとし
          // failを422 扱いで呼び出すようにしてとりあえず逃げる。
          if (typeof (res.errors) !== "undefined") {
            callFailFunction(funcs, res, 422, "Unprocessable Entity by app");
            return;
          }

          if (funcs.done) {
            funcs.done(res, xhr.status, xhr.statusText); 
          }
        })
        .fail((res) => {
          callFailFunction(funcs, res.responseJSON, res.status, res.statusText);
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
    }
  }

  StudyHub.api = api; // 割り当て
}