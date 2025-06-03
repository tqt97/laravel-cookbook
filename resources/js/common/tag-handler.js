export default function initializeTagNoneOptionHandler(elementId = 'tags') {
    const select = document.getElementById(elementId);
    if (!select) {
        console.warn(`Tag select element with ID '${elementId}' not found.`);
        return;
    }

    select.addEventListener('change', function () {

        const noneOptionSelected = Array.from(this.selectedOptions).some(opt => opt.value === '__none__');

        if (noneOptionSelected) {
            Array.from(this.options).forEach(option => {
                option.selected = false;
            });
        }
    });
}
