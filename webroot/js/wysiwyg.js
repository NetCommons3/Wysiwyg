/**
 * @fileoverview Wysiwyg Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */

NetCommonsApp.requires.push('ui.tinymce');


/**
 * NetCommonsWysiwyg factory
 */
NetCommonsApp.factory('NetCommonsWysiwyg', function() {

  /**
   * tinymce optins
   *
   * @type {{mode: string, menubar: string, plugins: string, toolbar: string}}
   */
  var options = {
    mode: 'exact',
    menubar: false,
    plugins: 'advlist textcolor colorpicker table hr emoticons charmap ' +
        'link media image code preview searchreplace paste',
    toolbar: [
              'fontselect fontsizeselect formatselect ' +
              '| bold italic underline strikethrough ' +
              '| subscript superscript | forecolor backcolor ' +
              '| removeformat',
              'undo redo | alignleft aligncenter alignright ' +
              '| bullist numlist | outdent indent blockquote ' +
              '| table | hr | emoticons | tex | link unlink',
              'media books image newdocument | pastetext code preview'
    ],
    paste_as_text: true,
    setup: function(editor) {
      editor.addButton('tex', {
        text: 'Tex',
        icon: false,
        onclick: function() {
          editor.windowManager.alert('Tex');
        }
      });
      editor.addButton('books', {
        text: '書籍',
        icon: false,
        onclick: function() {
          editor.windowManager.alert('書籍検索');
        }
      });
    }
    // language: 'ja'
  };

  /**
   * variables
   *
   * @type {Object.<string>}
   */
  var variables = {
    options: options
  };

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var functions = {
    /**
     * new method
     */
    new: function() {
      return angular.extend(variables, functions);
    }
  };

  return functions.new();
});