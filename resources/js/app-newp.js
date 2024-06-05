import '../scss/app-newp.scss'

import * as bootstrap from 'bootstrap'

document.getElementById('open_btn').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('open-sidebar');
});
