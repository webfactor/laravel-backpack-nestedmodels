<style>
    .modal.new-child-modal{
        display: block !important; /* I added this to see the modal, you don't need this */
        height: 100%;
        height: 100vh;
    }

    /* Important part */
    .modal.new-child-modal .modal-dialog{
        overflow-y: initial !important
    }
    .modal.new-child-modal .modal-body{
        height: 80%;
        height: 80vh;
        overflow-y: auto;
    }
</style>