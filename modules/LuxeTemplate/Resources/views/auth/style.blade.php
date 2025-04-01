<style>
    .auth-link {
        font-weight: bold;
        text-decoration: none;
        margin-right: 15px;
        cursor: pointer;
    }

    .auth-link:hover {
        text-decoration: underline;
    }

    .auth-link.active {
        font-weight: bold;
        color: #000;
    }

    .auth-form input {
        font-size: 16px;
    }

    .btn {
        font-weight: bold;
    }

    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.34);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        padding: 20px;
    }

    .modal-backdrop {
        z-index: 1040 !important;
    }

    .modal-dialog {
        max-width: 500px;
    }

    .modal-dialog-centered {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

</style>