$(() => {
  // 要素取得
  const data = $('#_data');
  const view = $('#_view');

  // markedの内容を取得
  const md = data.val();
  
  // markdownを表示
  my_marked(view, md);
});