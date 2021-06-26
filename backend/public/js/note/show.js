$(() => {
  // 要素取得
  const data = $('#_data');
  const view = $('#_view');

  // markedの内容を取得
  const md = data.val();
  
  const option = {
    breaks: true,
  }

  // markdownを表示
  view.html(marked(md, option));

  // シンタックスハイライト
  hljs.highlightAll();
});