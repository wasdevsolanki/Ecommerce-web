$(document).ready(function() {
    $('.summernote').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['fontfamily'],
            ['fontsize'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],

        autogrow: true,
        removeformatPasted: false,
        semantic: false,
        resetCss: true,
        lang: 'en',
        plugins: {
            fontsize: {
                allowCustomSize: true,
                sizeList: [
                    '12px',
                    '14px',
                    '16px'
                ]
            },
            fontfamily: {
                fontList: [
                    {name: 'Arial', family: 'Arial, Helvetica, sans-serif'},
                    {name: 'Comic Sans', family: '\'Comic Sans MS\', Textile, cursive, sans-serif'},
                    {name: 'Open Sans', family: '\'Open Sans\', sans-serif'}
                ]
            }
        }
    });
});