$(() => {
  // markdownの入っているコンテンツを取得
  const contents = $('#contents');

  // markedのパラメータ
  const md = contents.html();
  
  const option = {
    breaks: true,
  }

  // markdownの変換
  contents.html(marked(md, option));

  // シンタックスハイライト
  hljs.highlightAll();
});