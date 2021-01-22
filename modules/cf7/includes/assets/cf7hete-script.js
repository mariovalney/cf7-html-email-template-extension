'use strict';

jQuery(document).ready(function($) {
    function load_editor(id) {
        var editor = ace.edit(id);

        editor.setTheme('ace/theme/monokai');
        editor.setShowPrintMargin(false);
        editor.setFontSize(14);

        editor.session.setMode('ace/mode/html');
        editor.session.setOption('useWorker', false);

        editor.renderer.setScrollMargin(0, 10, 0, 10);
    }

    load_editor('cf7hete-module-html-template-header-html');
    load_editor('cf7hete-module-html-template-footer-html');
});
