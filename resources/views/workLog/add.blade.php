
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8" />
    <title>Simple example - Editor.md examples</title>
    <link rel="stylesheet" href="{{asset('static/editormd-log/css/write.css')}}" />
    <link rel="stylesheet" href="{{asset('static/editormd-log/css/editormd.css')}}" />
    <link rel="shortcut icon" href="https://pandao.github.io/editor.md/favicon.ico" type="image/x-icon" />
</head>
<body>
<div id="layout">
    <header>
        <h1>Simple example</h1>
    </header>
    <div id="test-editormd" style="margin-left: 20px">
                <textarea style="display:none;">[TOC]

#### Disabled options

- TeX (Based on KaTeX);
- Emoji;
- Task lists;
- HTML tags decode;
- Flowchart and Sequence Diagram;

#### Editor.md directory

    editor.md/
            lib/
            css/
            scss/
            tests/
            fonts/
            images/
            plugins/
            examples/
            languages/     
            editormd.js
            ...

```html
&lt;!-- English --&gt;
&lt;script src="../dist/js/languages/en.js"&gt;&lt;/script&gt;

&lt;!-- 繁體中文 --&gt;
&lt;script src="../dist/js/languages/zh-tw.js"&gt;&lt;/script&gt;
```
</textarea>
    </div>
</div>
<script src="{{asset('static/editormd-log/js/jquery.min.js')}}"></script>
<script src="{{asset('static/editormd-log/js/editormd.min.js')}}"></script>
<script type="text/javascript">
    var testEditor;

    $(function() {
        testEditor = editormd("test-editormd", {
            width   : "45%",
            height  : 380,
            syncScrolling : "single",
            path    : "/static/editormd-log/lib/"
        });

        /*
        // or
        testEditor = editormd({
            id      : "test-editormd",
            width   : "90%",
            height  : 640,
            path    : "../lib/"
        });
        */
    });
</script>
</body>
</html>