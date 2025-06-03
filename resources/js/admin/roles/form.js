document.addEventListener('DOMContentLoaded', () => {
    const updateParentCheckbox = (group) => {
        const children = document.querySelectorAll(`.group-${group}`);
        const parent = document.querySelector(`.group-checkbox[data-group="${group}"]`);
        const allChecked = [...children].every(chk => chk.checked);
        const someChecked = [...children].some(chk => chk.checked);

        parent.checked = allChecked;
        parent.indeterminate = !allChecked && someChecked;
    };

    // Handle parent to children
    document.querySelectorAll('.group-checkbox').forEach(parent => {
        const group = parent.dataset.group;

        parent.addEventListener('change', () => {
            const children = document.querySelectorAll(`.group-${group}`);
            children.forEach(child => {
                child.checked = parent.checked;
            });
        });
    });

    // Handle children to parent (2 chiều)
    document.querySelectorAll('.child-checkbox').forEach(child => {
        const classes = [...child.classList];
        const group = classes.find(c => c.startsWith('group-'))?.replace('group-', '');

        child.addEventListener('change', () => {
            updateParentCheckbox(group);
        });

        // Cập nhật ban đầu
        if (group) updateParentCheckbox(group);
    });

    // Check All box
    const checkAllBox = document.getElementById('check-all');

    checkAllBox.addEventListener('change', () => {
        const allCheckboxes = document.querySelectorAll('.child-checkbox, .group-checkbox');
        // allCheckboxes.forEach(chk => chk.checked = checkAllBox.checked);
        allCheckboxes.forEach(chk => {
            chk.checked = checkAllBox.checked;
            chk.indeterminate = false; // reset indeterminate luôn
        });
    });

    const updateCheckAllState = () => {
        const allChildren = document.querySelectorAll('.child-checkbox');
        const allChecked = [...allChildren].every(c => c.checked);
        const someChecked = [...allChildren].some(c => c.checked);

        checkAllBox.checked = allChecked;
        checkAllBox.indeterminate = !allChecked && someChecked;
    };

    updateCheckAllState(); // init state
});
