$(document).ready(function () {
    new TomSelect("#fruit", {
        plugins: ['remove_button'],
    });

    var dropzoneConfig = {
        preview: true,
        accepted: ['jpg', 'jpeg', 'png'],
        dropzoneTemplate: '<div class="clean-dropzone"><div class="clean-dropzone-area"></div><div class="clean-dropzone-message"></div><div class="clean-dropzone-preview margin-top-0"></div></div>',
        parentTemplate: '<div class="row-padding margin-left-0"></div>',
        childTemplate: '<div class="col s6 m6 l3 padding-left-0"></div>',
        imageClass: 'margin-top-1 rounded',
        language: {
            emptyText: '[Drop Images Here or Click To Upload]',
            dragText: '[Drop Images Here]',
            dropText: '[_t_ Image(s)]'
        },
    };

    $('#gallery').clean_dropzone(dropzoneConfig);
    $('#logo').clean_dropzone({
        preview: true,
        language: {
            emptyText: '[Drop One Image Here or Click To Upload]',
            dragText: '[Drop One Image Here]',
            dropText: '[_t_ File]'
        }
    });
});