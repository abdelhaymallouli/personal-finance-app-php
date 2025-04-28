document.addEventListener('DOMContentLoaded', function () {
    // ===== Add Transaction Modal =====
    const addModal = document.getElementById('transactionModal');
    const addCloseBtn = addModal.querySelector('.close');
    const addBtn = document.querySelector('.btn-success');

    addBtn.addEventListener('click', function (e) {
        e.preventDefault();
        addModal.style.display = 'block';
    });

    addCloseBtn.addEventListener('click', function () {
        addModal.style.display = 'none';
    });

    // Close Add Modal on outside click
    window.addEventListener('click', function (e) {
        if (e.target === addModal) {
            addModal.style.display = 'none';
        }
    });

    // ===== Edit Transaction Modal =====
    const editModal = document.getElementById('editTransactionModal');
    const editFrame = document.getElementById('editTransactionFrame');
    const editCloseBtn = editModal.querySelector('.close');

    // Global function to open Edit modal from inline onclick
    window.openEditModal = function (id) {
        editFrame.src = 'edit_transactions.php?id=' + id;
        editModal.style.display = 'block';
    };

    editCloseBtn.addEventListener('click', function () {
        editModal.style.display = 'none';
        editFrame.src = ''; // Optional: reset iframe
    });

    // Close Edit Modal on outside click
    window.addEventListener('click', function (e) {
        if (e.target === editModal) {
            editModal.style.display = 'none';
            editFrame.src = '';
        }
    });

    // ===== Listen for 'closeModal' message from iframe (for both modals) =====
    window.addEventListener('message', function (event) {
        if (event.data === 'closeModal') {
            addModal.style.display = 'none';
            editModal.style.display = 'none';
            addModal.querySelector('iframe')?.setAttribute('src', '');
            editFrame.setAttribute('src', '');

            // Optional: refresh to show updated transaction list
            location.reload();
        }
    });
});
