import initializeTagNoneOptionHandler from '../../common/tag-handler.js';

document.addEventListener('DOMContentLoaded', function () {
    initializeTagNoneOptionHandler('tags');
    function clearTags() {
        const select = document.getElementById('tags');
        for (const option of select.options) {
            option.selected = false;
        }
    }
});
