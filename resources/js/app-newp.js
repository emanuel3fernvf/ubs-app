import '../scss/app-newp.scss';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import jQuery from 'jquery';
window.$ = jQuery;

import toastr from 'toastr';

window.toastr = toastr;

window.toastr.options = {
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut",
    "progressBar": true
};

document.getElementById('open_btn').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('open-sidebar');
});

$(document).ready(function() {

    window.generalResponseModalEl = document.getElementById('general-response-modal');
    window.generalResponseModal = new bootstrap.Modal(generalResponseModalEl);

    window.addEventListener('general-response-modal', event => {
        if (!event.detail.message) {
            return;
        }

        let modalTitle = generalResponseModalEl.querySelector('.modal-title');
        let modalBody = generalResponseModalEl.querySelector('.modal-body');

        modalTitle.innerText = event.detail.title;
        modalBody.innerHTML = event.detail.message;

        generalResponseModal.show();
    });

    window.addEventListener('toast', event => {
        if (!event.detail.message) {
            return;
        }

        if (event.detail.success) {
            return toastr.success(event.detail.message);
        }

        return toastr.error(event.detail.message);
    });

    window.addEventListener('close-general-response-modal', event => {
        generalResponseModal.hide();
    });

    window.addEventListener('open-general-response-modal', event => {
        generalResponseModal.show();
    });

});
