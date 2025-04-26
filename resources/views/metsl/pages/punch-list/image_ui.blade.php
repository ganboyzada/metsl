<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="_token" content="{{ csrf_token() }}">
    <title>0. Design</title>
    <link
      type="text/css"
      href="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.css"
      rel="stylesheet"
    />
<link
  rel="stylesheet"
  href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.css"
/>

    <style>
      @import url(http://fonts.googleapis.com/css?family=Noto+Sans);
      html,
      body {
        height: 100%;
        margin: 0;
      }
    </style>
  </head>
  <body>
    <input type="hidden" name="project_id" value="3"/>
    <input type="hidden" name="punch_list_id" value="1"/>

    <div id="tui-image-editor-container"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.js"
    ></script>
    <script
      type="text/javascript"
      src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"
    ></script>
<script src="{{ asset('js/tui-image-editor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/theme/white-theme.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/theme/black-theme.js') }} "></script>
    <script>
      // Image editor
      var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
        includeUI: {
          loadImage: {
            path: 'http://127.0.0.1:8000/storage/project3/drawings/462573476_419893921164922_1904837710647096461_n%20(1).png',
            name: 'SampleImage',
          },
          theme: blackTheme, // or whiteTheme
          initMenu: 'filter',
          menuBarPosition: 'bottom',
        },
        cssMaxWidth: 700,
        cssMaxHeight: 500,
        usageStatistics: false,
      });
      window.onresize = function () {
        imageEditor.ui.resizeEditor();
      };
    </script>
  </body>
</html>
