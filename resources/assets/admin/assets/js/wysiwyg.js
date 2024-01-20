import tinyMCE from 'tinymce';

window.tinyMCESetting = {
    selector: '.wysiwyg',
    theme: 'silver',
    mobile: {theme: 'mobile'},
    height: 350,
    menubar: false,
    branding: false,
    image_advtab: true,
    automatic_uploads: true,
    media_alt_source: false,
    media_poster: false,
    relative_urls: false,
    directionality: 'ltr',
    // cache_suffix: `?v=${FleetCart.version}`,
    plugins: 'lists, link, table, image, media, paste, autosave, autolink, wordcount, code, fullscreen',
    toolbar: 'styleselect bold italic underline | fontsizeselect | forecolor backcolor | bullist numlist | alignleft aligncenter alignright | outdent indent | image media link table | code fullscreen',

    file_picker_callback: filemanager.tinyMceCallback
};
tinyMCE.baseURL = '/assets/admin/vendors/js/wysiwyg';
tinyMCE.init(window.tinyMCESetting);

console.log('here editor');