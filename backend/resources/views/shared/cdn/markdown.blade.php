<!-- Marked.js -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<!-- highlight.js -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.0.1/styles/monokai-sublime.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.0.1/highlight.min.js"></script>

<!-- MathJax -->
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

<!-- Twitter -->
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

<script>
// Marked.jsのカスタマイズ
function my_marked(view, markdownString) 
{
  // Override renderer function
  const renderer = new marked.Renderer();

  // リンクのURLがTwitterだったらTwitterの埋め込みタグにする
  renderer.link = (href, title, text) => 
  {     
    href = StudyHub.helper.cleanUrl(renderer.options.sanitize, renderer.options.baseUrl, href);

    if (href === null) {
      return text;
    }

    if (href.match(/https:\/\/twitter.com*/)?.index === 0) {
      return `
      <blockquote class="twitter-tweet">
        (ツイート埋め込み処理中)
        <a href="${href}">tweet</a>
      </blockquote>
      `
    } else {
      let out = '<a href="' + escape(href) + '"';
      if (title) {
        out += ' title="' + title + '"';
      }
      out += '>' + text + '</a>';
      return out;
    }
  }    

  const option = {
    breaks: false,
    renderer,
  }

  // markdownを表示
  const md = marked(markdownString, option);
  $(view).html(md);

  if (typeof twttr !== "undefined") {
    twttr.widgets.load();
  }
  
  // シンタックスハイライト
  hljs.highlightAll();

  if (typeof MathJax.texReset === 'function') {
    MathJax.texReset();
    MathJax.typesetPromise();
  }
}

// MathJaxの設定
window.MathJax = {
  tex: {
    inlineMath: [['$', '$'], ['\\(', '\\)']]
  }
};
</script>