//*****************************************************************************
// StudyHub.js
//*****************************************************************************
const StudyHub = {};

//-----------------------------------------------------------------------------
// api section
//-----------------------------------------------------------------------------
{
  api = {
    ajax: (options, done, fail) => {
      $.ajax(options)
        .done((res) => { done(res, xhr.status, xhr.statusText); })
        .fail((res) => { fail(res.responseJSON, res.status, res.statusText); });
    }    
  };

  api.category = {
    delete(params) {
      api.ajax(
        {
          url : `/api/categories/${params.id}`,
          type: 'delete',
        },
        params.done,
        params.fail
      );
    }
  }

  StudyHub.api = api; // 割り当て
}